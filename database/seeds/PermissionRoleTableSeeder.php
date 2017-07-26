<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->insert(
            [
                [
                    'permission_id' => 1,
                    'role_id' => 1
                ],
                [
                    'permission_id' => 1,
                    'role_id' => 2
                ],
                [
                    'permission_id' => 2,
                    'role_id' => 3
                ],
                [
                    'permission_id' => 3,
                    'role_id' => 3
                ],
                [
                    'permission_id' => 4,
                    'role_id' => 1
                ],
                [
                    'permission_id' => 4,
                    'role_id' => 2
                ]
            ]
        );
    }
}
