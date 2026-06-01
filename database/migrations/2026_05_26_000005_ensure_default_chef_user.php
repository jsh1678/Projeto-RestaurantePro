<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $existingId = DB::table('users')->where('email', 'chef@restaurante.com')->value('id');

        $data = [
            'name' => 'Chef Pedro',
            'role' => 'chef',
            'ativo' => true,
            'updated_at' => $now,
        ];

        if ($existingId) {
            DB::table('users')->where('id', $existingId)->update($data);
            return;
        }

        DB::table('users')->insert(array_merge($data, [
            'email' => 'chef@restaurante.com',
            'password' => Hash::make('password'),
            'created_at' => $now,
        ]));
    }

    public function down(): void
    {
        DB::table('users')
            ->where('email', 'chef@restaurante.com')
            ->where('name', 'Chef Pedro')
            ->delete();
    }
};
