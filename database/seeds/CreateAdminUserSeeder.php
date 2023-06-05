<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::pluck('id','id')->all();
        $role->syncPermissions($permission);
        $user->assignRole([$role->id]);
    }
}
