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

class StudentFindController extends Controller
{
    private function getLecturer(Student $user) {
        $thesis = $user->theses()
            ->where('is_done', false)
            ->wherePivot('status', 'on going')
            ->first();
        if (!$thesis) {
            $lecturers = Lecturer::all()
                ->map(function ($lecturer) {
                        $lecturer->is_assigned = false;
                        $lecturer->position = null;
                        return $lecturer;
                    });
            return $lecturers;
        }
        
        if ($thesis) {
            $assignedLecturers = $thesis->lecturers()
                ->orderBy('lecturer_thesis.position')
                ->get()
                ->map(function ($lecturer) {
                    $lecturer->is_assigned = true;
                    return $lecturer;
                });
    
            $assignedIds = $assignedLecturers->pluck('id');
    
            $unassignedLecturers = Lecturer::whereNotIn('id', $assignedIds)
                ->get()
                ->map(function ($lecturer) {
                    $lecturer->is_assigned = false;
                    $lecturer->position = null;
                    return $lecturer;
                });
    
            $lecturers = $assignedLecturers->concat($unassignedLecturers);
            
            return $lecturers;
        }
    }

    public function listLecturer() {
        $user = Auth::guard('student')->user();

        $lecturers = $this->getLecturer($user);

        return view('student.find.lecturer', compact('user', 'lecturers'));
    }

    public function findLecturer(Request $request) {
        $user = Auth::guard('student')->user();
        $q = $request->q;

        if (!$q) {
            return response()->json(
                $this->getLecturer($user)
            );
        }

        $lecturers =  $this->getLecturer($user)
            ->filter(fn ($l) => str_contains(
                strtolower($l->name),
                strtolower($q)
            ))
            ->values();
        
        return response()->json($lecturers);
    }

    public function lecturerCalendar() {
        $user = Auth::guard('student')->user();

        $thesis = $user->theses()
                ->where('is_done', false)
                ->wherePivot('status', 'on going')
                ->first();
        
        if (!$thesis) {
            return back()->with('error', __('consult.no thesis yet'));
        }

        $lecturers = $thesis->lecturers()->select('id', 'name')->get();

        return view('student.find.schedule', compact(
            'user',
            'thesis',
            'lecturers'
        ));
    }
    
    public function lecturerScheduleEvents(Request $request) {
        $user = Auth::guard('student')->user();

        $thesis = $user->theses()
                ->where('is_done', false)
                ->wherePivot('status', 'on going')
                ->firstOrFail();

        $lecturerId = $request->query('lecturer_id');
        $start = Carbon::parse($request->query('start'));
        $end = Carbon::parse($request->query('end'));

        abort_unless(
            $thesis->lecturers()->where('lecturers.id', $lecturerId)->exists(),
            403
        );

        // $appointments = Appointment::where('lecturer_id', $lecturerId)
        //     ->whereNotIn('status', ['cancelled'])
        //     ->orderBy('start_time')
        //     ->get()
        //     ->map(function ($a) {
        //         return [
        //             'id'    => $a->id,
        //             'title' => $a->thesis->title,
        //             'start' => $a->start_time,
        //             'end'   => $a->end_time,
        //         ];
        //     });
        

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

        return response()->json(
            $officeHours
                ->merge($appointments)
                ->sortBy('start')
                ->values()
        );  
    }

}
