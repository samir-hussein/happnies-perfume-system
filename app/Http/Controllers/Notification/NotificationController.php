<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return Index::boot();
    }

    public static function store($products)
    {
        return Store::boot($products);
    }

    public static function alertList()
    {
        return AlertList::boot();
    }

    public static function markAlertList($products)
    {
        return MarkAlertList::boot($products);
    }

    public static function newCount()
    {
        return NewNotificationsCount::boot();
    }
}
