<?php

namespace App\Http\Controllers\Thesis;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Psy\Output\Theme;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentThesisController extends Controller
{
    public function index() {
        $user = Auth::guard('student')->user();
        $theses = $user->theses()->get();
        $theses->each(function ($thesis) {
            if ($thesis->is_done && $thesis->pivot->status === 'on going') {
                $thesis->display_status = 'finished';
            } else {
                $thesis->display_status = $thesis->pivot->status;
            }
        });
        // dd($theses);
        return view('student.thesis.show', compact('user', 'theses'));
    }

    private function authorizeStudent(Thesis $thesis) {
        $studentId = Auth::guard('student')->id();

        $isRelated = $thesis
            ->students()
            ->where('students.id', $studentId)
            ->exists();

        if (! $isRelated) {
            throw new NotFoundHttpException();
        }
    }

    public function paper(Thesis $thesis) {
        $this->authorizeStudent($thesis);

        $user = Auth::guard('student')->user();
        return view('student.thesis.paper', compact('user', 'thesis'));
    }

    public function download(Thesis $thesis) {
        $this->authorizeStudent($thesis);

        if (!$thesis->paper_path || !Storage::disk('public')->exists($thesis->paper_path)) {
            throw new NotFoundHttpException();
        }

        return Storage::disk('public')->download($thesis->paper_path);
    }

    public function create() {
        $user = Auth::guard('student')->user();

        return view('student.thesis.create', compact('user'));
    }
    
    public function findStudent(Request $request) {
        $q = $request->query('q');
        $user = Auth::guard('student')->user();

        if (!$q) {
            return response()->json([]);
        }

        return Student::where('name', 'LIKE', "%{$q}%")
            ->whereNotIn('id', [$user->id])
            ->limit(10)
            ->get();
    }
    
    public function findLecturer(Request $request) {
        $q = $request->query('q');

        if (!$q) {
            return response()->json([]);
        }

        return Lecturer::where('name', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get();
    }

    public function accept(Thesis $thesis) {
        // thesis->pivot->status = requested
        $user = Auth::guard('student')->user();

        $pivot = $user->theses()
            ->where('thesis_id', $thesis->id)
            ->wherePivot('status', 'requested')
            ->first();

        if (!$pivot) {
            return back()->with('error', 'Invalid thesis status.');
        }
        
        $user->theses()
            ->where('is_done', false)
            ->wherePivot('status', 'on going')
            ->updateExistingPivot(
                $user->theses->pluck('id')->toArray(),
                ['status' => 'cancelled'],
                false
        );

        $user->theses()
            ->updateExistingPivot($thesis->id, [
                'status' => 'on going',
        ]);
        
        return back()->with('success', __('thesis.thesis_accepted'));
    }

    public function reject(Thesis $thesis) {
        // thesis->pivot->status = requested
        $user = Auth::guard('student')->user();
        
        $pivot = $user->theses()
            ->where('thesis_id', $thesis->id)
            ->wherePivot('status', 'requested')
            ->first();

        if (!$pivot) {
            return back()->with('error', __('thesis.invalid_status'));
        }

        $user->theses()
            ->updateExistingPivot($thesis->id, [
                'status' => 'rejected',
        ]);
        
        return back()->with('success', __('thesis.thesis_rejected'));
    }

    public function store(Request $request) {
        
        $authStudent = Auth::guard('student')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'students' => ['required', 'array', 'min:1', 'max:3'],
            'students.*' => ['exists:students,id'],
            'lecturers' => ['required', 'array', 'min:1', 'max:3'],
            'lecturers.*' => ['exists:lecturers,id'],
        ]);

        DB::transaction(function () use ($validated, $authStudent) {
            $ongoingPivot = DB::table('student_thesis')
                ->where('student_id', $authStudent->id)
                ->where('status', 'on going')
                ->first();
            
            if ($ongoingPivot) {
                DB::table('student_thesis')
                    ->where('student_id', $authStudent->id)
                    ->where('thesis_id', $ongoingPivot->thesis_id)
                    ->update(['status' => 'cancelled']);
            }

            $thesis = Thesis::create([
                'title' => $validated['name'],
            ]);

            foreach ($validated['students'] as $studentId) {
                $thesis->students()->attach($studentId, [
                    'status' => 'requested',
                ]);
            }

            $thesis->students()->attach($authStudent->id, [
                'status' => 'on going',
            ]);

            foreach ($validated['lecturers'] as $index => $lecturerId) {
                $thesis->lecturers()->attach($lecturerId, [
                    'position' => $index + 1,
                    'status'   => 'requesting',
                ]);
            }
        });

        return redirect()
            ->route('student.thesis.show')
            ->with('success', __('thesis.thesis_created'));
    }
}
