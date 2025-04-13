<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class MarkAlertList extends Controller
{
    public static function boot($list)
    {
        $ids = [];

        foreach ($list as $item) {
            array_push($ids, $item->id);
        }

        Notification::whereIn("id", $ids)->update([
            "alert" => true
        ]);
    }
}
