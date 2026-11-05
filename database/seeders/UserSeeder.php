<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        $admin = User::updateOrCreate(
            ['email' => 'admin@annur.sch.id'],
            [
                'name' => 'Administrator An-Nur',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->forceFill(['email_verified_at' => now()])->save();

        $staff = User::updateOrCreate(
            ['email' => 'adit@annur.sch.id'],
            [
                'name' => 'Adit - Staff Humas & CRM',
                'role' => 'staff',
                'password' => Hash::make('password123'),
            ]
        );

        $staff->forceFill(['email_verified_at' => now()])->save();
    }
}
