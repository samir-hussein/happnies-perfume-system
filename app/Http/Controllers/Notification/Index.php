<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot()
    {
        Notification::where("read", false)->update(["read" => true]);

        return view("dashboard.notifications.index", [
            "notifications" => Notification::latest()->get()
        ]);
    }
}
