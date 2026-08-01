<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed the departments table with the same name and code
        Department::insert([
            ['code' => 'CS', 'name' => 'Computer Science'],
            ['code' => 'IT', 'name' => 'Information Technology'],
            ['code' => 'BM', 'name' => 'Business Management'],
            ['code' => 'ACC', 'name' => 'Accounting'],
            ['code' => 'EE', 'name' => 'Electrical Engineering'],
            ['code' => 'CHN', 'name' => 'Chinese Literature'],
            ['code' => 'ENG', 'name' => 'English Literature'],
        ]);
    }
}
