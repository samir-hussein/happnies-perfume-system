<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Index::boot();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.user.store");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        return Register::boot($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return Destroy::boot($user);
    }
}
