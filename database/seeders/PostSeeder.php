<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->truncate();

        $users = DB::table('users')->get();
        $now = Date('Y-m-d H:i:s');

        $data = [];
        foreach ($users as $user) {
            $max = $user->id % 3;
            if($max === 0) {
                continue;
            }

            for ($i = 1; $i <= $max ; $i++) {
                $data[] = [
                    'user_id' => $user->id,
                    'title' => "title_{$user->id}_{$i}",
                    'body' => "body_{$user->id}_{$i}",
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('posts')->insert($data);
    }
}
