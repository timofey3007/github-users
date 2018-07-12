<?php

namespace App\Admin;

/**
 * Class Helper
 * @package App\Admin
 */
class Helper
{
    /**
     * @var string
     */
    private $queue_modify_key = 'seed-is-available';

    /**
     * By this Redis key we will retrace seeding status
     * @return bool|string
     */
    public function seedingIsRunning()
    {
        $is_create = \Redis::get($this->queue_modify_key);

        return $is_create;
    }

    /**
     *
     *
     * @param bool $status
     */
    public function modifySeedQueueStatus(bool $status)
    {
        \Redis::set($this->queue_modify_key, $status);
        \Redis::expire($this->queue_modify_key, 3600);
    }
}