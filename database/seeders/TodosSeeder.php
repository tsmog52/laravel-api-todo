<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todos')->insert([
            [
                'title' =>'買い物に行く',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' =>'掃除をする',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
