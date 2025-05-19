<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\UserProfile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@dewi.my.id',
            'password' => bcrypt('nimda'),
        ]);

        $roles = ['admin', 'user', 'approver', 'vendor'];
        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        Department::create([
            'code' => 'PUR',
            'name' => 'Purchasing',
        ]);

        $admin->assignRole('admin');
        $admin->departments()->sync(1);

        UserProfile::create([
            'user_id' => $admin->id,
            'nik' => '000000'
        ]);
    }
}
