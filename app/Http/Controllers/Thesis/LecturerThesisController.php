<?php

namespace App\Http\Controllers\Thesis;

use App\Http\Controllers\Controller;
use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LecturerThesisController extends Controller
{
    public function index() {
        $user = Auth::guard('lecturer')->user();
        $theses = $user->theses()->get();
        $theses->each(function ($thesis) {
            if ($thesis->is_done && $thesis->pivot->status === 'on going') {
                $thesis->display_status = 'finished';
            } else {
                $thesis->display_status = $thesis->pivot->status;
            }
        });
        return view('lecturer.thesis.show', compact('user', 'theses'));
    }

    private function authorizeLecturer(Thesis $thesis) {
        $lecturerId = Auth::guard('lecturer')->id();

        abort_if(!$thesis
            ->lecturers()
            ->where('lecturer.id', $lecturerId)
            ->exists(), 404);
    }

    public function paper(Thesis $thesis) {
        // dd($thesis);
        $this->authorizeLecturer($thesis);

        $user = Auth::guard('lecturer')->user();
        return view('lecturer.thesis.paper', compact('user', 'thesis'));
    }

    public function download(Thesis $thesis) {
        $this->authorizeLecturer($thesis);

        abort_if(!$thesis->paper_path || !Storage::disk('public')->exists($thesis->paper_path), 404);

        return Storage::disk('public')->download($thesis->paper_path);
    }

    public function approve(Thesis $thesis) {
        // thesis->pivot->position == 1, thesis->pivot->status == on going
        $user = Auth::guard('lecturer')->user();

        $pivot = $user->theses()
            ->where('thesis_id', $thesis->id)
            ->wherePivot('position', 1)
            ->wherePivot('status', 'on going')
            ->first();

        if (!$pivot) {
            return back()->with('error', __('thesis.not_authorized'));
        }

        $thesis->update([
            'is_done' => true,
        ]);

        return back()->with('success', __('thesis.thesis_approved'));
    }
    
    public function accept(Thesis $thesis) {
        // thesis->pivot->status = requesting
        $user = Auth::guard('lecturer')->user();

        $pivot = $user->theses()
            ->where('thesis_id', $thesis->id)
            ->wherePivot('status', 'requesting')
            ->first();

        if (!$pivot) {
            return back()->with('error', __('thesis.invalid_status'));
        }

        $user->theses()
            ->updateExistingPivot($thesis->id, [
                'status' => 'on going',
            ]);

        return back()->with('success', __('thesis.thesis_accepted'));
    }

    public function reject(Thesis $thesis) {
        // thesis->pivot->status = requesting
        $user = Auth::guard('lecturer')->user();

        $pivot = $user->theses()
            ->where('thesis_id', $thesis->id)
            ->wherePivot('status', 'requesting')
            ->first();

        if (!$pivot) {
            return back()->with('error', __('thesis.invalid_status'));
        }

        $currentPosition = $pivot->pivot->position;

        DB::transaction(function () use ($thesis, $user, $currentPosition) {
            $user->theses()
                ->updateExistingPivot($thesis->id, [
                    'status' => 'rejected',
                ]);
            $lecturersToShift = $thesis->lecturers()
                ->wherePivot('position', '>', $currentPosition)
                ->get();

            foreach ($lecturersToShift as $lecturer) {
                $thesis->lecturers()
                    ->updateExistingPivot($lecturer->id, [
                        'position' => $lecturer->pivot->position - 1,
                    ]);
            }
        });

        return back()->with('success', __('thesis.thesis_rejected'));
    }

}
