<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'CSE', 'name' => 'Computer Science & Engineering', 'description' => 'Programming, computing, artificial intelligence and software engineering.', 'head_name' => 'Dr. Rajesh Kumar', 'established_year' => 1990],
            ['code' => 'ECE', 'name' => 'Electronics & Communication', 'description' => 'Electronics, communication systems and embedded technology.', 'head_name' => 'Dr. Priya Sharma', 'established_year' => 1992],
            ['code' => 'ME', 'name' => 'Mechanical Engineering', 'description' => 'Mechanical design, manufacturing and thermodynamics.', 'head_name' => 'Prof. Anil Verma', 'established_year' => 1988],
            ['code' => 'CE', 'name' => 'Civil Engineering', 'description' => 'Civil, structural and construction engineering.', 'head_name' => 'Dr. Sunita Patel', 'established_year' => 1988],
            ['code' => 'MBA', 'name' => 'Business Administration', 'description' => 'Business, management, finance and entrepreneurship.', 'head_name' => 'Dr. Meera Joshi', 'established_year' => 1998],
        ];

        $departmentIds = [];
        foreach ($departments as $data) {
            $department = Department::updateOrCreate(
                ['code' => $data['code']],
                $data + ['status' => 'active']
            );
            $departmentIds[$data['code']] = $department->id;
        }

        $courses = [
            ['department' => 'CSE', 'name' => 'B.Tech Computer Science', 'code' => 'BTECH-CS', 'duration_years' => 4, 'total_semesters' => 8, 'fees_per_semester' => 45000, 'total_seats' => 60],
            ['department' => 'CSE', 'name' => 'M.Tech Computer Science', 'code' => 'MTECH-CS', 'duration_years' => 2, 'total_semesters' => 4, 'fees_per_semester' => 55000, 'total_seats' => 30],
            ['department' => 'ECE', 'name' => 'B.Tech Electronics', 'code' => 'BTECH-EC', 'duration_years' => 4, 'total_semesters' => 8, 'fees_per_semester' => 42000, 'total_seats' => 60],
            ['department' => 'ME', 'name' => 'B.Tech Mechanical', 'code' => 'BTECH-ME', 'duration_years' => 4, 'total_semesters' => 8, 'fees_per_semester' => 40000, 'total_seats' => 60],
            ['department' => 'CE', 'name' => 'B.Tech Civil', 'code' => 'BTECH-CE', 'duration_years' => 4, 'total_semesters' => 8, 'fees_per_semester' => 38000, 'total_seats' => 60],
            ['department' => 'MBA', 'name' => 'Master of Business Administration', 'code' => 'MBA-GEN', 'duration_years' => 2, 'total_semesters' => 4, 'fees_per_semester' => 60000, 'total_seats' => 40],
        ];

        foreach ($courses as $data) {
            $departmentCode = $data['department'];
            unset($data['department']);

            Course::updateOrCreate(
                ['code' => $data['code']],
                $data + [
                    'department_id' => $departmentIds[$departmentCode],
                    'description' => 'A comprehensive academic programme in ' . $data['name'] . '.',
                    'status' => 'active',
                ]
            );
        }
    }
}
