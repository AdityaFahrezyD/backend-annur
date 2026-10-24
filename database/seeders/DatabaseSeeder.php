<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SchoolProfileSeeder::class,
            TeacherSeeder::class,
            AchievementSeeder::class,
            CompetitionSeeder::class,
            CurriculumSeeder::class,
            GallerySeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
