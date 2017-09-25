<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/9/24
 * Time: 9:47
 */

namespace App\Events;


class CreatedMeeting extends Event
{
    public $users;
    public $metting;

    public function __construct($users, $metting)
    {
        $users = $this->getUsers($users);
        $this->users = $users;
        $this->metting = $metting;
    }

}