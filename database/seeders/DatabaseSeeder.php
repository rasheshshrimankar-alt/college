<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Notice;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Scholarship;
use App\Models\LibraryBook;
use App\Models\Admission;
use App\Models\Subject;
use App\Models\Examination;
use App\Models\Result;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Placement;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMIN USERS ─────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@smartcampus.edu',
            'phone'    => '9999900001',
            'role'     => 'admin',
            'password' => Hash::make('Admin@123'),
            'status'   => 'active',
        ]);

        // ─── DEPARTMENTS ─────────────────────────────────────────────
        $depts = [
            ['name'=>'Computer Science & Engineering','code'=>'CSE','description'=>'Covers algorithms, programming, AI, and software engineering.','head_name'=>'Dr. Rajesh Kumar','established_year'=>1990],
            ['name'=>'Electronics & Communication','code'=>'ECE','description'=>'Covers circuits, communication systems, and embedded systems.','head_name'=>'Dr. Priya Sharma','established_year'=>1992],
            ['name'=>'Mechanical Engineering','code'=>'ME','description'=>'Covers thermodynamics, machine design, and manufacturing.','head_name'=>'Prof. Anil Verma','established_year'=>1988],
            ['name'=>'Civil Engineering','code'=>'CE','description'=>'Covers structural engineering, construction, and surveying.','head_name'=>'Dr. Sunita Patel','established_year'=>1988],
            ['name'=>'Business Administration','code'=>'MBA','description'=>'Covers management, marketing, finance and entrepreneurship.','head_name'=>'Dr. Meera Joshi','established_year'=>1998],
        ];
        $departments = [];
        foreach ($depts as $d) {
            $departments[] = Department::create($d + ['status'=>'active']);
        }

        // ─── COURSES ─────────────────────────────────────────────────
        $courses = [
            ['department_id'=>$departments[0]->id,'name'=>'B.Tech Computer Science','code'=>'BTECH-CS','duration_years'=>4,'total_semesters'=>8,'fees_per_semester'=>45000,'total_seats'=>60],
            ['department_id'=>$departments[0]->id,'name'=>'M.Tech Computer Science','code'=>'MTECH-CS','duration_years'=>2,'total_semesters'=>4,'fees_per_semester'=>55000,'total_seats'=>30],
            ['department_id'=>$departments[1]->id,'name'=>'B.Tech Electronics','code'=>'BTECH-EC','duration_years'=>4,'total_semesters'=>8,'fees_per_semester'=>42000,'total_seats'=>60],
            ['department_id'=>$departments[2]->id,'name'=>'B.Tech Mechanical','code'=>'BTECH-ME','duration_years'=>4,'total_semesters'=>8,'fees_per_semester'=>40000,'total_seats'=>60],
            ['department_id'=>$departments[3]->id,'name'=>'B.Tech Civil','code'=>'BTECH-CE','duration_years'=>4,'total_semesters'=>8,'fees_per_semester'=>38000,'total_seats'=>60],
            ['department_id'=>$departments[4]->id,'name'=>'Master of Business Administration','code'=>'MBA-GEN','duration_years'=>2,'total_semesters'=>4,'fees_per_semester'=>60000,'total_seats'=>40],
        ];
        $courseModels = [];
        foreach ($courses as $c) {
            $courseModels[] = Course::create($c + ['status'=>'active','description'=>'A comprehensive program in '.$c['name']]);
        }

        // ─── SUBJECTS ─────────────────────────────────────────────────
        $subjects = Subject::insert([
            ['course_id'=>$courseModels[0]->id,'department_id'=>$departments[0]->id,'name'=>'Data Structures','code'=>'CS101','semester'=>1,'credits'=>4,'type'=>'theory','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['course_id'=>$courseModels[0]->id,'department_id'=>$departments[0]->id,'name'=>'Database Management','code'=>'CS102','semester'=>1,'credits'=>4,'type'=>'theory','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['course_id'=>$courseModels[0]->id,'department_id'=>$departments[0]->id,'name'=>'Operating Systems','code'=>'CS201','semester'=>2,'credits'=>4,'type'=>'theory','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['course_id'=>$courseModels[0]->id,'department_id'=>$departments[0]->id,'name'=>'Computer Networks','code'=>'CS202','semester'=>2,'credits'=>4,'type'=>'theory','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['course_id'=>$courseModels[1]->id,'department_id'=>$departments[1]->id,'name'=>'Circuit Theory','code'=>'EC101','semester'=>1,'credits'=>4,'type'=>'theory','status'=>'active','created_at'=>now(),'updated_at'=>now()],
        ]);
        $subjectModels = Subject::all();

        // ─── FACULTY ─────────────────────────────────────────────────
        $facultyData = [
            ['name'=>'Dr. Rajesh Kumar','email'=>'rajesh@smartcampus.edu','dept'=>0,'designation'=>'Professor','qual'=>'Ph.D Computer Science','spec'=>'Machine Learning','exp'=>'15 years'],
            ['name'=>'Prof. Anjali Singh','email'=>'anjali@smartcampus.edu','dept'=>0,'designation'=>'Associate Professor','qual'=>'M.Tech CS','spec'=>'Web Technologies','exp'=>'10 years'],
            ['name'=>'Dr. Priya Sharma','email'=>'priya@smartcampus.edu','dept'=>1,'designation'=>'Professor','qual'=>'Ph.D Electronics','spec'=>'VLSI Design','exp'=>'12 years'],
            ['name'=>'Prof. Anil Verma','email'=>'anil@smartcampus.edu','dept'=>2,'designation'=>'Professor','qual'=>'M.Tech Mechanical','spec'=>'Thermodynamics','exp'=>'18 years'],
            ['name'=>'Dr. Sunita Patel','email'=>'sunita@smartcampus.edu','dept'=>3,'designation'=>'Professor','qual'=>'Ph.D Civil','spec'=>'Structural Engg.','exp'=>'14 years'],
            ['name'=>'Dr. Meera Joshi','email'=>'meera@smartcampus.edu','dept'=>4,'designation'=>'Professor','qual'=>'Ph.D Management','spec'=>'Finance','exp'=>'11 years'],
        ];
        $facultyUser = User::create(['name'=>'Demo Faculty','email'=>'faculty@smartcampus.edu','phone'=>'9999900002','role'=>'faculty','password'=>Hash::make('Faculty@123'),'status'=>'active']);
        $facultyModels = [];
        foreach ($facultyData as $i => $f) {
            $user = ($i === 0) ? $facultyUser : User::create(['name'=>$f['name'],'email'=>$f['email'],'phone'=>'9000000'.(200+$i),'role'=>'faculty','password'=>Hash::make('Faculty@123'),'status'=>'active']);
            $facultyModels[] = Faculty::create([
                'user_id'       => $user->id,
                'department_id' => $departments[$f['dept']]->id,
                'faculty_id'    => 'FAC' . str_pad($i+1, 3, '0', STR_PAD_LEFT),
                'designation'   => $f['designation'],
                'qualification' => $f['qual'],
                'specialization'=> $f['spec'],
                'experience'    => $f['exp'],
                'joining_date'  => Carbon::now()->subYears(rand(2, 10)),
                'salary'        => rand(50000, 150000),
                'gender'        => $i % 2 == 0 ? 'male' : 'female',
                'status'        => 'active',
            ]);
        }

        // ─── STUDENTS ────────────────────────────────────────────────
        $studentUser = User::create(['name'=>'Demo Student','email'=>'student@smartcampus.edu','phone'=>'9999900003','role'=>'student','password'=>Hash::make('Student@123'),'status'=>'active']);
        $studentNames = [
            'Arjun Sharma','Priya Patel','Rahul Singh','Anjali Gupta','Karan Mehta',
            'Sneha Joshi','Amit Kumar','Pooja Verma','Rohit Das','Nidhi Rao',
            'Vishal Tiwari','Swati Mishra','Deepak Nair','Riya Kapoor','Suresh Reddy',
            'Meena Pillai','Akash Jain','Kavya Pandey','Nikhil Bose','Tanvi Desai',
        ];
        $studentModels = [];
        foreach ($studentNames as $i => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@student.smartcampus.edu';
            $user  = ($i === 0) ? $studentUser : User::create(['name'=>$name,'email'=>$email,'phone'=>'9000000'.(100+$i),'role'=>'student','password'=>Hash::make('Student@123'),'status'=>'active']);
            if ($i === 0) { $studentUser->update(['name'=>$name]); }
            $courseIdx = $i % count($courseModels);
            $studentModels[] = Student::create([
                'user_id'          => $user->id,
                'course_id'        => $courseModels[$courseIdx]->id,
                'department_id'    => $departments[$courseModels[$courseIdx]->department_id == $departments[0]->id ? 0 : ($courseIdx % 5)]->id,
                'student_id'       => 'STU' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                'roll_number'      => '2024' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                'current_semester' => rand(1, 4),
                'current_year'     => rand(1, 2),
                'batch_year'       => '2024-25',
                'gender'           => $i % 3 == 0 ? 'female' : 'male',
                'blood_group'      => ['A+','B+','O+','AB+'][rand(0,3)],
                'guardian_name'    => 'Guardian of '.$name,
                'guardian_phone'   => '9100000'.$i,
                'fees_paid'        => rand(10000, 50000),
                'fees_due'         => rand(0, 20000),
                'status'           => 'active',
            ]);
        }

        // ─── NOTICES ─────────────────────────────────────────────────
        $noticeData = [
            ['title'=>'Semester Examination Schedule - November 2026','content'=>'The semester examinations for all courses will commence from November 15, 2026. Students are advised to collect their hall tickets from the examination cell. The detailed schedule is attached below.','category'=>'exam','is_important'=>true],
            ['title'=>'Fee Payment Deadline Extended','content'=>'The deadline for semester fee payment has been extended to December 15, 2026. Students are requested to pay their fees before the deadline to avoid late fine charges.','category'=>'fee','is_important'=>true],
            ['title'=>'Annual Sports Day - Registration Open','content'=>'Annual Sports Day will be held on December 20, 2026. Students can register for various sports events at the Physical Education department. Participation certificates will be awarded.','category'=>'event','is_important'=>false],
            ['title'=>'College Closed for Diwali Holidays','content'=>'The college will remain closed from November 8-14, 2026 for Diwali holidays. Regular classes will resume from November 15, 2026.','category'=>'holiday','is_important'=>false],
            ['title'=>'Guest Lecture on Artificial Intelligence','content'=>'A special guest lecture on Artificial Intelligence and Future of Technology will be delivered by Dr. Anil Kumar from IIT Delhi on November 20, 2026 at 11:00 AM in the Main Auditorium.','category'=>'general','is_important'=>false],
        ];
        foreach ($noticeData as $n) {
            Notice::create($n + ['target'=>'all','publish_date'=>Carbon::today(),'expiry_date'=>Carbon::today()->addDays(30),'created_by'=>$admin->id,'status'=>'active']);
        }

        // ─── NEWS ─────────────────────────────────────────────────────
        $newsData = [
            ['title'=>'SMART CAMPUS Ranks Among Top 50 Engineering Colleges','content'=>'SMART CAMPUS College of Technology has been ranked among the top 50 engineering colleges in India by the National Institutional Ranking Framework (NIRF) 2026. This is a proud achievement for our institution.','category'=>'achievement','is_featured'=>true],
            ['title'=>'Students Win National Hackathon','content'=>'A team of four B.Tech students from the Computer Science department won first prize at the National Hackathon 2026. The team developed an AI-powered solution for rural healthcare.','category'=>'achievement','is_featured'=>true],
            ['title'=>'New Research Lab Inaugurated','content'=>'A state-of-the-art AI and Machine Learning Research Laboratory has been inaugurated by the college management. The lab is equipped with high-performance computing systems and GPU clusters.','category'=>'infrastructure','is_featured'=>false],
            ['title'=>'Industry Partnership with TechCorp Solutions','content'=>'SMART CAMPUS College of Technology has signed an MoU with TechCorp Solutions for student internships, industrial training, and campus placements. This partnership will benefit over 200 students annually.','category'=>'industry','is_featured'=>false],
        ];
        foreach ($newsData as $n) {
            News::create($n + ['created_by'=>$admin->id,'status'=>'published','views'=>rand(50,500)]);
        }

        // ─── EVENTS ──────────────────────────────────────────────────
        $eventData = [
            ['title'=>'Annual Technical Fest - TECHNOMANIA 2026','description'=>'Three-day technical fest featuring hackathons, robotics competitions, paper presentations, and workshops by industry experts.','venue'=>'Main Campus Ground','start_datetime'=>Carbon::now()->addDays(10),'end_datetime'=>Carbon::now()->addDays(13),'organizer'=>'Technical Club','category'=>'technical','status'=>'upcoming'],
            ['title'=>'Cultural Fest - UTSAV 2026','description'=>'Annual cultural celebration showcasing music, dance, drama, and art. Open for all students and faculty.','venue'=>'Open Air Theatre','start_datetime'=>Carbon::now()->addDays(20),'end_datetime'=>Carbon::now()->addDays(22),'organizer'=>'Cultural Committee','category'=>'cultural','status'=>'upcoming'],
            ['title'=>'Campus Placement Drive - TechGiant Corp','description'=>'TechGiant Corp will be conducting campus placement for B.Tech final year students. Package: 8-15 LPA.','venue'=>'Placement Cell, Block B','start_datetime'=>Carbon::now()->addDays(5),'end_datetime'=>Carbon::now()->addDays(5),'organizer'=>'Placement Cell','category'=>'placement','status'=>'upcoming'],
            ['title'=>'Alumni Meet 2026','description'=>'Annual alumni gathering for networking, knowledge sharing, and industry interactions. All alumni are welcome.','venue'=>'College Auditorium','start_datetime'=>Carbon::now()->addDays(30),'end_datetime'=>Carbon::now()->addDays(30),'organizer'=>'Alumni Association','category'=>'alumni','status'=>'upcoming'],
        ];
        foreach ($eventData as $e) {
            Event::create($e + ['created_by'=>$admin->id]);
        }

        // ─── SCHOLARSHIPS ─────────────────────────────────────────────
        $scholarships = [
            ['name'=>'Central Government Scholarship','description'=>'Government scholarship for economically weaker sections.','provider'=>'Government','amount'=>25000,'eligibility'=>'Family income < 2.5 LPA, 60% in previous exam','application_deadline'=>Carbon::now()->addDays(60),'status'=>'active'],
            ['name'=>'Merit Scholarship','description'=>'College scholarship for academic excellence.','provider'=>'College','amount'=>15000,'eligibility'=>'Top 10% academic performers','application_deadline'=>Carbon::now()->addDays(45),'status'=>'active'],
            ['name'=>'Girls Empowerment Scholarship','description'=>'Special scholarship for female students in STEM.','provider'=>'Government','amount'=>20000,'eligibility'=>'Female students in engineering courses','application_deadline'=>Carbon::now()->addDays(30),'status'=>'active'],
            ['name'=>'Sports Excellence Scholarship','description'=>'For students with outstanding sports achievements.','provider'=>'College','amount'=>10000,'eligibility'=>'State/National level sports representation','application_deadline'=>Carbon::now()->addDays(20),'status'=>'active'],
        ];
        foreach ($scholarships as $s) {
            Scholarship::create($s);
        }

        // ─── LIBRARY BOOKS ───────────────────────────────────────────
        $books = [
            ['title'=>'Introduction to Algorithms','author'=>'Cormen, Leiserson, Rivest','isbn'=>'9780262033848','publisher'=>'MIT Press','publication_year'=>2022,'category'=>'Computer Science','total_copies'=>5,'available_copies'=>3],
            ['title'=>'Database System Concepts','author'=>'Silberschatz, Korth, Sudarshan','isbn'=>'9780078022159','publisher'=>'McGraw-Hill','publication_year'=>2020,'category'=>'Computer Science','total_copies'=>4,'available_copies'=>2],
            ['title'=>'Computer Networks','author'=>'Andrew S. Tanenbaum','isbn'=>'9780132126953','publisher'=>'Pearson','publication_year'=>2021,'category'=>'Computer Science','total_copies'=>3,'available_copies'=>3],
            ['title'=>'Engineering Mathematics','author'=>'B.S. Grewal','isbn'=>'9788174091956','publisher'=>'Khanna Publications','publication_year'=>2021,'category'=>'Mathematics','total_copies'=>10,'available_copies'=>7],
            ['title'=>'Principles of Management','author'=>'Koontz & Weihrich','isbn'=>'9780071077859','publisher'=>'McGraw-Hill','publication_year'=>2019,'category'=>'Management','total_copies'=>4,'available_copies'=>4],
            ['title'=>'Signals and Systems','author'=>'Oppenheim & Willsky','isbn'=>'9780138147570','publisher'=>'Pearson','publication_year'=>2020,'category'=>'Electronics','total_copies'=>3,'available_copies'=>1],
        ];
        foreach ($books as $b) {
            LibraryBook::create($b + ['location'=>'Rack '.rand(1,10),'status'=>'available']);
        }

        // ─── PLACEMENTS ───────────────────────────────────────────────
        $companies = [
            ['company'=>'TCS','position'=>'Software Engineer','package'=>7.5],
            ['company'=>'Infosys','position'=>'Systems Engineer','package'=>6.5],
            ['company'=>'Wipro','position'=>'Project Engineer','package'=>7.0],
            ['company'=>'Google India','position'=>'SDE-1','package'=>28.0],
            ['company'=>'Amazon','position'=>'SDE-1','package'=>24.5],
            ['company'=>'Microsoft','position'=>'Software Engineer','package'=>22.0],
        ];
        foreach ($studentModels as $i => $student) {
            if ($i < count($companies)) {
                $company = $companies[$i];
                Placement::create([
                    'student_id'    => $student->id,
                    'company_name'  => $company['company'],
                    'position'      => $company['position'],
                    'package_lpa'   => $company['package'],
                    'placement_type'=> 'campus',
                    'academic_year' => '2024-25',
                    'offer_date'    => Carbon::now()->subDays(rand(10,60)),
                    'status'        => 'offered',
                ]);
            }
        }

        // ─── GALLERY ─────────────────────────────────────────────────
        $galleryItems = [
            ['title'=>'Campus Main Building','category'=>'campus'],
            ['title'=>'Computer Lab','category'=>'labs'],
            ['title'=>'Library Reading Hall','category'=>'library'],
            ['title'=>'Annual Sports Day','category'=>'events'],
            ['title'=>'Cultural Fest 2025','category'=>'events'],
            ['title'=>'Science Exhibition','category'=>'academic'],
            ['title'=>'Basketball Court','category'=>'sports'],
            ['title'=>'Seminar Hall','category'=>'campus'],
        ];
        foreach ($galleryItems as $i => $g) {
            Gallery::create($g + ['image_path'=>'gallery-placeholder.jpg','created_by'=>$admin->id,'is_featured'=>$i<3,'status'=>'active','description'=>'Campus '.$g['title']]);
        }

        // ─── EXAMINATION & RESULTS ───────────────────────────────────
        if ($subjectModels->count() > 0 && count($studentModels) > 0) {
            $exam = Examination::create([
                'course_id'     => $courseModels[0]->id,
                'department_id' => $departments[0]->id,
                'name'          => 'Mid-Semester Examination Oct 2026',
                'exam_type'     => 'internal',
                'semester'      => 1,
                'academic_year' => '2024-25',
                'start_date'    => Carbon::now()->subDays(15),
                'end_date'      => Carbon::now()->subDays(10),
                'total_marks'   => 50,
                'passing_marks' => 20,
                'status'        => 'completed',
            ]);
            foreach ($studentModels as $student) {
                if ($student->course_id === $courseModels[0]->id) {
                    foreach ($subjectModels->take(2) as $subject) {
                        $marks = rand(20, 50);
                        Result::create([
                            'student_id'    => $student->id,
                            'examination_id'=> $exam->id,
                            'subject_id'    => $subject->id,
                            'marks_obtained'=> $marks,
                            'total_marks'   => 50,
                            'percentage'    => ($marks / 50) * 100,
                            'status'        => $marks >= 20 ? 'pass' : 'fail',
                            'faculty_id'    => $facultyModels[0]->id,
                        ]);
                    }
                }
            }
        }

        // ─── FEES ────────────────────────────────────────────────────
        $fee = Fee::create([
            'course_id'   => $courseModels[0]->id,
            'fee_type'    => 'tuition',
            'amount'      => 45000,
            'academic_year'=> '2024-25',
            'semester'    => 1,
            'due_date'    => Carbon::now()->addDays(30),
            'status'      => 'active',
        ]);
        foreach ($studentModels as $i => $student) {
            if ($i < 10) {
                FeePayment::create([
                    'student_id'     => $student->id,
                    'fee_id'         => $fee->id,
                    'amount_paid'    => 45000,
                    'payment_date'   => Carbon::now()->subDays(rand(1,30)),
                    'payment_method' => ['cash','online','upi'][rand(0,2)],
                    'receipt_number' => 'RCP' . str_pad(1000 + $i, 6, '0', STR_PAD_LEFT),
                    'status'         => 'paid',
                ]);
            }
        }

        // ─── ADMISSIONS ──────────────────────────────────────────────
        $admissionNames = ['Rahul Sharma','Priya Gupta','Amit Patel','Neha Singh','Rohan Joshi'];
        foreach ($admissionNames as $i => $name) {
            Admission::create([
                'course_id'            => $courseModels[$i % count($courseModels)]->id,
                'department_id'        => $departments[$i % count($departments)]->id,
                'application_number'   => 'ADM2024' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                'applicant_name'       => $name,
                'applicant_email'      => strtolower(str_replace(' ','.',$name)) . '@gmail.com',
                'applicant_phone'      => '9' . rand(100000000, 999999999),
                'previous_qualification'=> '12th / Intermediate',
                'previous_percentage'  => rand(60, 95) + (rand(0,99)/100),
                'academic_year'        => '2024-25',
                'status'               => ['pending','approved','approved','rejected','waitlisted'][$i],
            ]);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Default Accounts:');
        $this->command->info('  Admin   → admin@smartcampus.edu   / Admin@123');
        $this->command->info('  Faculty → faculty@smartcampus.edu / Faculty@123');
        $this->command->info('  Student → student@smartcampus.edu / Student@123');
    }
}
