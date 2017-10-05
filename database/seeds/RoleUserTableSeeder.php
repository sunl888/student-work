<?php

class RoleUserTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'role_id' => 1
            ],
            [
                'user_id' => 2,
                'role_id' => 2
            ],
            [
                'user_id' => 3,
                'role_id' => 3
            ]
        ];
        for ($i = 4; $i <= $this->userCount + 3; $i++) {
            $data[] = [
                'user_id' => $i,
                'role_id' => random_int(2, 3)
            ];
        }

        DB::table('role_user')->insert($data);
    }
}
