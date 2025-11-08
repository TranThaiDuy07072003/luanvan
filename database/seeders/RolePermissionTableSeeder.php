<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::Where('name', 'admin')->first();
        $staffRole = Role::Where('name', 'staff')->first();

        $permissions = Permission::all();


        // Gán tất cả quyền cho vai trò admin
        $adminRole->permissions()->sync($permissions);


        // Gán quyền quản lý sản phẩm và liên hệ cho vai trò staff
        $staffPermissions = $permissions->whereIn('name', [
            'manager_products',
            'manager_contacts'
        ]);
        $staffRole->permissions()->sync($staffPermissions);
    }
}
