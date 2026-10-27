<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();

        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            SchoolProfileSeeder::class,
            AchievementSeeder::class,
            CompetitionSeeder::class,
            CurriculumContentSeeder::class,
            GallerySeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
