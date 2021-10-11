<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [

            // admin panel permissions

            [
                'name' => 'admin_panel_access',
            ],

            // user permissions

            [
                'name' => 'users_access',
            ],

            [
                'name' => 'user_edit',
            ],

            [
                'name' => 'user_delete',
            ],

            [
                'name' => 'user_create',
            ],

            [
                'name' => 'user_show',
            ],
            [
                'name' => 'user_restore'
            ],


            // role permissions

            [
                'name' => 'roles_access',
            ],

            [
                'name' => 'role_edit',
            ],

            [
                'name' => 'role_delete',
            ],

            [
                'name' => 'role_create',
            ],

            [
                'name' => 'role_show',
            ],


            // permission permissions

            [
                'name' => 'permissions_access',
            ],

            [
                'name' => 'permission_edit',
            ],

            [
                'name' => 'permission_delete',
            ],

            [
                'name' => 'permission_create',
            ],


            // category permissions

            [
                'name' => 'category_access',
            ],

            [
                'name' => 'category_create',
            ],

            [
                'name' => 'category_store',
            ],

            [
                'name' => 'category_show',
            ],
            [
                'name' => 'category_edit',
            ],
            [
                'name' => 'category_update',
            ],
            [
                'name' => 'category_destroy',
            ],
            [
                'name' => 'category_restore',
            ],
            [
                'name' => 'category_delete',
            ],


            // service permissions

            [
                'name' => 'service_access',
            ],
            [
                'name' => 'service_create',
            ],
            [
                'name' => 'service_store',
            ],
            [
                'name' => 'service_show',
            ],
            [
                'name' => 'service_edit',
            ],
            [
                'name' => 'category_update',
            ],
            [
                'name' => 'service_update',
            ],
            [
                'name' => 'service_destroy',
            ],
            [
                'name' => 'service_restore',
            ],
            [
                'name' => 'service_delete'
            ],


            // Technician permissions


            [
                'name' => 'technician_access',
            ],

            [
                'name' => 'technicians_edit',
            ],

            [
                'name' => 'technician_delete',
            ],

            [
                'name' => 'technician_create',
            ],

            [
                'name' => 'technician_show',
            ],
            [
                'name' => 'technician_restore'
            ],



        ];

        foreach($permissions as $permission){
            $checkExist = Permission::where('name',$permission['name'])->get();
            if(!isset($checkExist[0]->id)){
            Permission::create($permission);
        }
        }

    }
}
