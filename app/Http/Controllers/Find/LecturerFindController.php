<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Lecturer;
use App\Models\OfficeHour;
use App\Models\Student;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LecturerFindController extends Controller
{
    public function calendar() {
        $user = Auth::guard('lecturer')->user();

        $lecturers = Lecturer::all();

        return view('lecturer.find.schedule', compact(
            'user',
            'lecturers'
        ));
    }
    
    public function scheduleEvents(Request $request) {
        $lecturerId = $request->query('lecturer_id');
        $start = Carbon::parse($request->query('start'));
        $end = Carbon::parse($request->query('end'));


        $appointments = Appointment::where('lecturer_id', $lecturerId)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get()
            ->map(function ($a) {
                return [
                    'id'    => 'a-'.$a->id,
                    'title' => $a->thesis->title,
                    'start' => $a->start_time,
                    'end'   => $a->end_time,
                    'backgroundColor' => '#e74c3c',
                    'editable' => false,
                    'extendedProps' => [
                        'type' => 'appointment',
                        'status' => $a->status,
                    ],
                ];
            });
        
        $appointments = collect($appointments);
        $officeHours = collect();

        $rules = OfficeHour::where('lecturer_id', $lecturerId)->get();

        foreach ($rules as $rule) {
            $period = CarbonPeriod::create($start, $end);

            foreach ($period as $date) {
                if ($date->dayOfWeek !== (int) $rule->day_of_week) {
                    continue;
                }

                $officeHours->push([
                    'id' => 'o-'.$rule->id.'-'.$date->format('Ymd'),
                    'title' => 'Office Hour',
                    'start' => $date->format('Y-m-d').' '.$rule->start_time,
                    'end' => $date->format('Y-m-d').' '.$rule->end_time,
                    'backgroundColor' => '#3498db',
                    'editable' => false,
                ]);
            }
        }

        // $officeHours = OfficeHour::where('lecturer_id', $lecturerId)
        //     ->orderBy('start_time')
        //     ->get()
        //     ->map(function ($o) {
        //         return [
        //             'id' => 'o-'.$o->id,
        //             'title' => 'Office Hour',
        //             'daysOfWeek' => [(int) $o->day_of_week], // REQUIRED
        //             'startTime' => $o->start_time,           // TIME ONLY
        //             'endTime' => $o->end_time,               // TIME ONLY
        //             'backgroundColor' => '#3498db',
        //             'editable' => false,
        //             'display' => 'background', // optional (see below)
        //             'extendedProps' => [
        //                 'type' => 'office_hour',
        //             ],
        //         ];
        //     });
        // $officeHours = collect($officeHours);
        
        // dd($appointments, $officeHours);
        
        return response()->json(
            $officeHours
                ->merge($appointments)
                ->sortBy('start')
                ->values()
        );
    }

    public function listStudent() {
        $user = Auth::guard('lecturer')->user();
        $students = Student::all();
        return view('lecturer.find.student', compact('user', 'students'));
    }

    public function findStudent(Request $request) {
        $q = $request->q;

        if (!$q) {
            return response()->json(
                Student::all()
            );
        }

        $students = Student::when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                ->orWhere('NIM', 'like', "%{$q}%")
                ->orWhere('major', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
        })->get();
        
        return response()->json($students);
    }

    public function setOffice(Request $request) {
        $lecturer = Auth::guard('lecturer')->user();

        $schedules = $request->input('schedules', []);
        // dd($schedules);
        DB::transaction(function () use ($lecturer, $schedules) {
            $lecturer->officeHours()->delete();
            foreach ($schedules as $schedule) {
                // dd($schedule['day'], $schedule['start'], $schedule['end'], $schedule);
                if (
                    empty($schedule['day']) ||
                    empty($schedule['start']) ||
                    empty($schedule['end'])
                ) {
                    continue;
                }
                if ($schedule['start'] >= $schedule['end']) {
                    return back()->with('error', __('schedule.time error'));
                }
                $lecturer->officeHours()->create([
                    'day_of_week' => (int) $schedule['day'],
                    'start_time' => $schedule['start'],
                    'end_time' => $schedule['end'],
                ]);
            }
        });

        return back()->with('success', __('schedule.update office'));
    }
}
