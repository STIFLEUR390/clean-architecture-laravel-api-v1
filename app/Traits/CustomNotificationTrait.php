<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CustomNotificationTrait
{
    public function countNotificationType($notifiable_type)
    {
        return DB::table('notifications')->where('notifiable_type', $notifiable_type)->count();
    }

    public function getNotificationType($notifiable_type)
    {
        return DB::table('notifications')->where('notifiable_type', $notifiable_type)->get();
    }

    public function countUnReadNotificationType($notifiable_type)
    {
        return DB::table('notifications')->where('notifiable_type', $notifiable_type)->whereNull('read_at')->count();
    }

    public function getUnReaNotificationType($notifiable_type)
    {
        return DB::table('notifications')->where('notifiable_type', $notifiable_type)->whereNull('read_at')->get();
    }
}
