<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'books.view',
            'books.create',
            'books.update',
            'books.delete',
            'users.manage-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $admin = Role::findOrCreate('Admin', 'web');
        $dosen = Role::findOrCreate('Dosen', 'web');
        $mahasiswa = Role::findOrCreate('Mahasiswa', 'web');

        $admin->syncPermissions($permissions);
        $dosen->syncPermissions(['books.view', 'books.create', 'books.update']);
        $mahasiswa->syncPermissions(['books.view']);

        $users = [
            ['name' => 'Admin', 'email' => 'admin@example.com', 'role' => 'Admin'],
            ['name' => 'Dosen', 'email' => 'dosen@example.com', 'role' => 'Dosen'],
            ['name' => 'Mahasiswa', 'email' => 'mahasiswa@example.com', 'role' => 'Mahasiswa'],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'email_verified_at' => now(),
                ],
            );

            $user->syncRoles([$data['role']]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
