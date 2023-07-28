<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->roles();

        $this->setupAdmin();
    }

    public function roles()
    {
        Role::updateOrCreate(['name' => UserRoleEnum::Admin]);
    }

    private function setupAdmin()
    {
        $user = User::query()->updateOrCreate(['email' => 'admin@admin.com'], [
            'name'     => 'Administration',
            'password' => bcrypt('secret'),
        ]);
        $user->assignRole(UserRoleEnum::Admin->value);
    }
}
