<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NewNotificationsCount extends Controller
{
    public static function boot()
    {
        return Notification::where("read", false)->count("id");
    }
}
