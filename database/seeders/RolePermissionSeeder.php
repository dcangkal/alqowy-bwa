<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $studentRole = Role::create([
            'name' => 'student'
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);

        $userOwner = User::create([
            'name' => 'undas',
            'occupation' => 'Owner',
            'avatar' => 'images/default-avatar.png',
            'email' => 'owner@undas.id',
            'password' => bcrypt('password'),   
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
