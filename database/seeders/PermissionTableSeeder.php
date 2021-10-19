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
                'name' => 'technician_edit',
            ],

            [
                'name' => 'technician_delete',
            ],

            [
                'name' => 'technician_create',
            ],
            [
                'name' => 'technician_store',
            ],
            [
                'name' => 'technician_update',
            ],

            [
                'name' => 'technician_show',
            ],
            [
                'name' => 'technician_restore'
            ],


              // Time Slot permissions


            [
                'name' => 'timeslot_access',
            ],

            [
                'name' => 'timeslot_create',
            ],

            [
                'name' => 'timeslot_store',
            ],

            [
                'name' => 'timeslot_edit',
            ],

            [
                'name' => 'timeslot_update',
            ],
            [
                'name' => 'timeslot_destroy'
            ],
            [
                'name' => 'timeslot_restore',
            ],
            [
                'name' => 'timeslot_delete',
            ],


            // Banner Multiple permissions


            [
                'name' => 'banner_multiple_access',
            ],

            [
                'name' => 'banner_multiple_create',
            ],

            [
                'name' => 'banner_multiple_store',
            ],

            [
                'name' => 'banner_multiple_show',
            ],

            [
                'name' => 'banner_multiple_edit',
            ],
            [
                'name' => 'banner_multiple_update'
            ],
            [
                'name' => 'banner_multiple_delete',
            ],
            [
                'name' => 'banner_multiple_restore',
            ],


             // Banner Single permissions


            [
                'name' => 'banner_single_access',
            ],            

            [
                'name' => 'banner_single_edit',
            ],

            [
                'name' => 'banner_single_update',
            ],




            // Order permissions


            [
                'name' => 'order_access',
            ],

            [
                'name' => 'order_change_status',
            ],

            [
                'name' => 'order_admin_payment_received_status',
            ],

            [
                'name' => 'order_asign',
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
