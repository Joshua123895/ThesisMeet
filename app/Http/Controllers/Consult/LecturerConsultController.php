<?php

namespace App\Http\Controllers\Consult;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LecturerConsultController extends Controller
{
    public function review() {
        $user = Auth::guard('lecturer')->user();
        $appointments = $user->appointments()
        ->where('status', 'on review')
        ->get();
        return view('lecturer.consult.review', compact('user', 'appointments'));
    }

    public function ongoing() {
        $user = Auth::guard('lecturer')->user();
        $appointments = $user->appointments()
            ->where('status', 'finished')
            ->whereDate('start_time', '>=', Carbon::today())
            ->orderBy('start_time')
            ->orderBy('end_time')
            ->get();
        return view('lecturer.consult.ongoing', compact('user', 'appointments'));
    }
    
    public function history() {
        $user = Auth::guard('lecturer')->user();
        $appointments = $user->appointments()
            ->where(function ($q) {
                $q->where('status', 'cancelled')
                ->orWhereDate('start_time', '<', Carbon::today());
            })
            ->where('hidden_by_lecturer', false)
            ->orderBy('start_time', 'desc')
            ->orderBy('end_time')
            ->get();
        return view('lecturer.consult.history', compact('user', 'appointments'));
    }

    public function accept(Request $request, Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        abort_if($appointment->lecturer_id !== $user->id, 403);
        $appointment->status = 'finished';
        $appointment->save();
        return back()->with('success', __('consult.appointment accepted'));
    }

    public function reject(Request $request, Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        // dd($request, $appointment, $user);
        abort_if($appointment->lecturer_id !== $user->id, 403);

        $request->validate([
            'reason' => 'required|string|max:32'
        ]);

        $appointment->comments = $request->reason;
        $appointment->status = 'cancelled';
        $appointment->save();
        return back()->with('success', __('consult.appointment rejected'));
    }

    public function view(Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        abort_if($appointment->lecturer_id !== $user->id, 403);
        return view('lecturer.consult.view', compact('user', 'appointment'));
    }

    public function note(Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        abort_if($appointment->lecturer_id !== $user->id, 403);
        return view('lecturer.consult.notes', compact('user', 'appointment'));
    }

    public function updateNotes(Request $request, Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        abort_if($appointment->lecturer_id !== $user->id, 403);
        $validated = $request->validate([
            'comment' => 'required|string|max:32',
            'notes' => 'required|array',
            'notes.*' => 'string|min:10|max:255',
        ]);

        DB::transaction(function () use ($appointment, $validated) {
            $appointment->notes()->delete();

            foreach ($validated['notes'] ?? [] as $note) {
                $appointment->notes()->create([
                    'note' => $note,
                ]);
            }

            $appointment->comments = $validated['comment'];
            $appointment->save();
        });

        return redirect()->route('lecturer.consult.ongoing')->with('success', __('consult.notes updated'));
    }

    public function delete(Appointment $appointment) {
        $user = Auth::guard('lecturer')->user();
        abort_if($appointment->lecturer_id !== $user->id, 403);
        $appointment->hidden_by_lecturer = true;
        $appointment->save();
        return back()->with('success', __('consult.history hidden'));
    }

    public function clear() {
        $user = Auth::guard('lecturer')->user();
        $user->appointments()
            ->where(function ($q) {
                $q->where('status', 'cancelled')
                ->orWhereDate('start_time', '<', Carbon::today());
            })
            ->where('hidden_by_lecturer', false)
            ->update([
                'hidden_by_lecturer' => true
            ]);
        return back()->with('success', __('consult.history cleared'));
    }
}
