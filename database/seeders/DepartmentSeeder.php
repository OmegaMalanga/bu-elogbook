<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Computer Engineering',
            'Mechanical Engineering',
            'Electrical Engineering',
            'Water Resources Engineering',
            'Marine Engineering',
            'Polymer & Textile Engineering',
            'Agro Processing Engineering',
            'Mining Engineering',
            'Agricultural Mechanisation Engineering',
            'Ginning Engineering',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }
    }
}