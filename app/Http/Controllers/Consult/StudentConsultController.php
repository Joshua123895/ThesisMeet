<?php

namespace App\Http\Controllers\Consult;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Lecturer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentConsultController extends Controller
{
    public function ongoing() {
        $user = Auth::guard('student')->user();
        $now = Carbon::now();

        $appointments = Appointment::with(['lecturer', 'thesis'])
            ->whereHas('thesis.students', function ($q) use ($user) {
                $q->where('students.id', $user->id);
            })
            ->where('end_time', '>=', $now)
            ->orderBy('start_time')
            ->get();

        return view('student.consult.ongoing', compact('user', 'appointments'));
    }

    public function history() {
        $user = Auth::guard('student')->user();
        $now = Carbon::now();


        $appointments = Appointment::with(['lecturer', 'thesis'])
            ->whereHas('thesis.students', function ($q) use ($user) {
                $q->where('students.id', $user->id);
            })
            ->where('end_time', '<', $now)
            ->whereDoesntHave('students', function ($q) use ($user) {
                $q->where('student_id', $user->id)
                ->where('hidden', true);
            })
            ->orderByDesc('start_time')
            ->get();
        
        // dd($appointments);
        
        return view('student.consult.history', compact('user', 'appointments'));
    }

    public function deleteHistory(Appointment $appointment) {
        $user = Auth::guard('student')->user();

        abort_unless(
            $appointment->thesis->students()->where('students.id', $user->id)->exists(),
            404
        );

        $appointment->students()->syncWithoutDetaching([
            $user->id => ['hidden' => true],
        ]);

        return back()->with('success', __('consult.hidden one history'));
    }

    public function clearHistory() {
        $user = Auth::guard('student')->user();
        $now = now();

        $appointments = Appointment::whereHas('thesis.students', function ($q) use ($user) {
                $q->where('students.id', $user->id);
            })
            ->where('end_time', '<', $now)
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->students()->syncWithoutDetaching([
                $user->id => ['hidden' => true],
            ]);
        }

        return back()->with('success', __('consult.cleared history'));
    }
    
    private function authorizeStudent(Appointment $appointment) {
        $studentId = Auth::guard('student')->id();

        $isRelated = $appointment->thesis
            ->students()
            ->where('students.id', $studentId)
            ->exists();

        if (! $isRelated) {
            throw new NotFoundHttpException();
        }
    }

    
    public function paper(Appointment $appointment) {
        $this->authorizeStudent($appointment);

        return view('student.paper.show', [
            'user' => Auth::guard('student')->user(),
            'appointment'=> $appointment,
        ]);
    }

    public function notes(Appointment $appointment) {
        $this->authorizeStudent($appointment);

        return view('student.paper.notes', [
            'user' => Auth::guard('student')->user(),
            'appointment' => $appointment,
        ]);
    }

    public function create() {
        $user = Auth::guard('student')->user();

        $activeThesis = $user->theses()
            ->wherePivot('status', 'on going')
            ->where('theses.is_done', false)
            ->first();

        if (!$activeThesis) {
            return back()->with('error', __('consult.no thesis yet'));
        }

        $lecturers = $activeThesis->lecturers;

        return view('student.consult.create', compact('lecturers', 'user'));
    }

    public function store(Request $request) {
        $student = Auth::guard('student')->user();
        
        $validated = $request->validate([
            'lecturer' => ['required', 'exists:lecturers,id'],
            
            'start_hh' => ['required', 'regex:/^(0[0-9]|1[0-9]|2[0-3])$/'],
            'start_mm' => ['required', 'regex:/^[0-5][0-9]$/'],
            'end_hh'   => ['required', 'regex:/^(0[0-9]|1[0-9]|2[0-3])$/'],
            'end_mm'   => ['required', 'regex:/^[0-5][0-9]$/'],
            
            'day'   => ['required', 'regex:/^(0[1-9]|[12][0-9]|3[01])$/'],
            'month' => ['required', 'regex:/^(0[1-9]|1[0-2])$/'],
            'year'  => ['required', 'digits:4', 'integer', 'min:2026'],
            
            'proposal_pdf' => ['required', 'file', 'mimetypes:application/pdf,application/octet-stream'],
            
            'notes'    => ['required', 'string'],
            'onsite'   => ['nullable'],
            'location' => ['required', 'string'],
        ]);

        $thesis = $student->theses()
            ->wherePivot('status', 'on going')
            ->firstOrFail();

        $start = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$request->year}-{$request->month}-{$request->day} {$request->start_hh}:{$request->start_mm}"
        );

        $end = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$request->year}-{$request->month}-{$request->day} {$request->end_hh}:{$request->end_mm}"
        );

        if ($end->lessThanOrEqualTo($start)) {
            throw ValidationException::withMessages([
                'end_time' => __('consult.end after start'),
            ]);
        }

        if ($start->isPast()) {
            throw ValidationException::withMessages([
                'start_time' => __('consult.appointment future'),
            ]);
        }

        if (!$request->hasFile('proposal_pdf')) {
            throw ValidationException::withMessages([
                'proposal_pdf' => __('consult.pdf required'),
            ]);
        }

        $pdfPath = $request->file('proposal_pdf')
            ->store('papers', 'public');

        $thesis->paper_path = $pdfPath;
        $thesis->save();

        Appointment::create([
            'start_time'        => $start,
            'end_time'          => $end,
            'comments'          => $validated['notes'],
            'thesis_id'         => $thesis->id,
            'lecturer_id'       => $validated['lecturer'],
            'status'            => 'on review',
            'paper_path'        => $pdfPath,
            'is_onsite'         => $request->boolean('onsite'),
            'location'          => $validated['location'],
        ]);

        return redirect()
            ->route('student.consult.ongoing')
            ->with('success', __('consult.appointment submitted'));
    }
}
