<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Lecturer;
use App\Models\OfficeHour;
use App\Models\Student;
use App\Models\Thesis;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $studentsList = [
            [
                'name'     => 'Joshua Michael Irwanto',
                'email'    => 'jojo05.irwanto@gmail.com',
                'password' => Hash::make('tugumuda'),
                'NIM'      => '2701234567',
                'major'    => collect([
                    'computer science',
                    'international business management'
                ])->random(),
                'image_path' => 'students/me.jpg',
                'email_verified_at' => now(),
            ],
            [
                'name'     => 'Kevin Adrian Wijaya',
                'email'    => 'kevin.wijaya@gmail.com',
                'password' => Hash::make('tugumuda'),
                'NIM'      => '2701234568',
                'major'    => collect([
                    'computer science',
                    'information systems'
                ])->random(),
                'image_path' => null,
            ],
            [
                'name'     => 'Michelle Aurelia Tan',
                'email'    => 'michelle.tan@gmail.com',
                'password' => Hash::make('tugumuda'),
                'NIM'      => '2701234569',
                'major'    => collect([
                    'international business management',
                    'digital marketing'
                ])->random(),
                'image_path' => null,
            ],
            [
                'name'     => 'Daniel Pratama Santoso',
                'email'    => 'daniel.santoso@gmail.com',
                'password' => Hash::make('tugumuda'),
                'NIM'      => '2701234570',
                'major'    => collect([
                    'computer science',
                    'data science'
                ])->random(),
                'image_path' => null,
            ],
            [
                'name'     => 'Clarissa Natalia Putri',
                'email'    => 'clarissa.putri@gmail.com',
                'password' => Hash::make('tugumuda'),
                'NIM'      => '2701234571',
                'major'    => collect([
                    'information systems',
                    'business analytics'
                ])->random(),
                'image_path' => null,
            ],
        ];

        $lecturersList = [
            [
                'name'       => 'Prof. Joshua Michael Irwanto',
                'email'      => 'joshua.irwanto@binus.ac.id',
                'password'   => Hash::make('admin123'),
                'phone'      => '081123456789',
                'profile'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image_path' => 'lecturers/695392092d7f9.png',
                'email_verified_at' => now(),
            ],
            [
                'name'       => 'Prof. Daniel Pratama',
                'email'      => 'daniel.pratama@binus.ac.id',
                'password'   => Hash::make('admin123'),
                'phone'      => '081123456789',
                'profile'    => 'Prof. Daniel Pratama focuses on Web Development, Mobile Development, and React. He holds a Ph.D. in Computer Science and was born on September 15, 1982, making him 43 years old. He completed his Bachelor degree at Telkom University, his Master degree in Software Development at the University of Glasgow, and his Doctorate from the University of Birmingham. He encourages students to build practical and user friendly applications.',
                'image_path' => 'lecturers/lec1.png',
            ],
            [
                'name'       => 'Dr. Steven Kurniawan',
                'email'      => 'steven.kurniawan@binus.edu',
                'password'   => Hash::make('admin123'),
                'phone'      => '081123456789',
                'profile'    => 'Dr. Steven Kurniawan specializes in Operating Systems, Computer Architecture, and C Programming. He holds a Ph.D. in Computer Engineering and was born on January 27, 1978, making him 47 years old. He earned his Bachelor degree from Universitas Diponegoro, his Master degree in Embedded Systems from TU Munich, and his Doctorate from RWTH Aachen University. He focuses on teaching how software interacts with hardware.',
                'image_path' => 'lecturers/lec2.png',
            ],
            [
                'name'       => 'Dr. Amelia Putri',
                'email'      => 'anelia.putri@binus.edu',
                'password'   => Hash::make('admin123'),
                'phone'      => '081123456789',
                'profile'    => 'Dr. Amelia Putri is a Computer Science lecturer specializing in Data Science, Machine Learning, and Python programming. She completed her Bachelor degree in Computer Science at Universitas Indonesia, continued her Master degree in Data Analytics at the University of Manchester, and earned her Doctorate from Imperial College London. Her teaching focuses on helping students analyze data and build intelligent systems to solve real world problems.',
                'image_path' => 'lecturers/lec3.png',
            ],
            [
                'name'       => 'Prof. Nicholas Tan',
                'email'      => 'nicholas.tan@binus.edu',
                'password'   => Hash::make('admin123'),
                'phone'      => '081123456789',
                'profile'    => 'Prof. Nicholas Tan specializes in Cloud Computing and Distributed Systems. He holds a Ph.D. in Computer Science and was born on December 2, 1999, making him 26 years old. He earned his Bachelor degree from Nanyang Technological University, his Master degree from ETH Zurich, and his Doctorate from Stanford University. His teaching focuses on large scale and cloud based systems.',
                'image_path' => 'lecturers/lec4.png',
            ],
        ];

        foreach ($studentsList as $s) {
            Student::create($s);
        }

        foreach ($lecturersList as $l) {
            Lecturer::create($l);
        }

        $cancelledThesis = Thesis::create([
            'is_done'  => false,
            'title' => 'Judul Thesis',
            'paper_path'=> null,
        ]);

        $finishedThesis = Thesis::create([
            'is_done'  => true,
            'title' => 'Authorship Attribution in Bahasa Indonesia Using Twitter Dataset on Political Topic',
            'paper_path'=> 'papers/192exq7daw8e.pdf',
        ]);
        
        $ongoingThesis = Thesis::create([
            'is_done'  => false,
            'title' => 'Multi-Agent Path Finding with Kinematic Constraints for Robotic Mobile Fulfillment Systems',
            'paper_path'=> 'papers/1706.09347.pdf',
        ]);

        $student = Student::where('id', 1)->firstOrFail();
        $student2 = Student::where('id', 2)->firstOrFail();
        $lecturer = Lecturer::where('id', 1)->firstOrFail();
        $lecturer2 = Lecturer::where('id', 2)->firstOrFail();

        $student->theses()->attach($ongoingThesis->id, [
            'status' => 'on going',
        ]);

        $student->theses()->attach($finishedThesis->id, [
            'status' => 'on going',
        ]);

        $student->theses()->attach($cancelledThesis->id, [
            'status' => 'rejected',
        ]);

        $student2->theses()->attach($ongoingThesis->id, [
            'status' => 'on going',
        ]);

        $lecturer->theses()->attach($ongoingThesis->id, [
            'position' => 1,
            'status'   => 'on going',
        ]);
        
        $lecturer->theses()->attach($finishedThesis->id, [
            'position' => 1,
            'status'   => 'on going',
        ]);
        
        $lecturer2->theses()->attach($ongoingThesis->id, [
            'position' => 2,
            'status'   => 'on going',
        ]);
        
        $lecturer2->theses()->attach($cancelledThesis->id, [
            'position' => 1,
            'status'   => 'rejected',
        ]);

        
        Appointment::create([
            'thesis_id'   => $ongoingThesis->id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => Carbon::now()->addDays(10)->hour(18)->minute(0),
            'end_time'    => Carbon::now()->addDays(10)->hour(20)->minute(30),
            'status'      => 'on review',
            'is_onsite'   => false,
            'paper_path'  => 'papers/1706.09347.pdf',
            'location'    => "https://us02web.zoom.us/j/86950852018?pwd=bDyjw5BnbmcbZgECznsom2sDSfgFzH.1",
            'comments'    => 'Reviewing Introduction',
        ]);

        Appointment::create([
            'thesis_id'   => $ongoingThesis->id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => Carbon::now()->addDays(4)->hour(10)->minute(0),
            'end_time'    => Carbon::now()->addDays(4)->hour(12)->minute(30),
            'status'      => 'finished',
            'is_onsite'   => false,
            'paper_path'  => 'papers/1706.09347.pdf',
            'location'    => "https://us02web.zoom.us/j/86950852018?pwd=bDyjw5BnbmcbZgECznsom2sDSfgFzH.1",
            'comments'    => 'Reviewing Abstract',
        ]);

        Appointment::create([
            'thesis_id'   => $ongoingThesis->id,
            'lecturer_id' => $lecturer2->id,
            'start_time'  => Carbon::now()->addDays(3)->hour(7)->minute(30),
            'end_time'    => Carbon::now()->addDays(3)->hour(10)->minute(0),
            'status'      => 'cancelled',
            'is_onsite'   => true,
            'paper_path'  => 'papers/1706.09347.pdf',
            'location'    => "A1707",
            'comments'    => "Honestly, I can do the appointment, but you know, my niece. She is sick.",
        ]);

        $appointment = Appointment::create([
            'thesis_id'   => $ongoingThesis->id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => Carbon::now()->subDays(2)->hour(13),
            'end_time'    => Carbon::now()->subDays(2)->hour(15)->minute(30),
            'status'      => 'finished',
            'is_onsite'   => true,
            'paper_path'  => 'papers/1706.09347.pdf',
            'location'    => "A1302",
            'comments'    => 'A lot of fixings are needed. Great overall',
        ]);

        $appointment->notes()->createMany([
            ['note' => 'In page 2, definition is unclear here.'],
            ['note' => 'Please cite a stronger reference from page 1 to 5!']
        ]);

        Appointment::create([
            'thesis_id'   => $ongoingThesis->id,
            'lecturer_id' => $lecturer2->id,
            'start_time'  => Carbon::now()->subDays(3)->hour(9)->minute(0),
            'end_time'    => Carbon::now()->subDays(3)->hour(12)->minute(0),
            'status'      => 'cancelled',
            'is_onsite'   => true,
            'paper_path'  => 'papers/1706.09347.pdf',
            'location'    => "C0212",
            'comments'    => 'Urgent businness meeting',
        ]);
        Appointment::create([
            'thesis_id'   => $finishedThesis->id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => Carbon::now()->subDays(4)->hour(9)->minute(30),
            'end_time'    => Carbon::now()->subDays(4)->hour(12)->minute(0),
            'status'      => 'finished',
            'is_onsite'   => false,
            'paper_path'  => 'papers/192exq7daw8e.pdf',
            'location'    => "https://us02web.zoom.us/j/86950852018?pwd=bDyjw5BnbmcbZgECznsom2sDSfgFzH.1",
            'comments'    => "It's done. Very good.",
        ]);
        Appointment::create([
            'thesis_id'   => $finishedThesis->id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => Carbon::now()->subDays(6)->hour(9)->minute(0),
            'end_time'    => Carbon::now()->subDays(6)->hour(12)->minute(30),
            'status'      => 'cancelled',
            'is_onsite'   => false,
            'paper_path'  => 'papers/192exq7daw8e.pdf',
            'location'    => "https://us02web.zoom.us/j/86950852018?pwd=bDyjw5BnbmcbZgECznsom2sDSfgFzH.1",
            'comments'    => 'Student missed the appointment',
        ]);

        OfficeHour::create([
            'lecturer_id' => 1,
            'day_of_week' => 1,
            'start_time' => "09:00:00",
            'end_time' => "18:00:00",
        ]);

        OfficeHour::create([
            'lecturer_id' => 1,
            'day_of_week' => 5,
            'start_time' => "09:00:00",
            'end_time' => "18:00:00",
        ]);
    }
}
