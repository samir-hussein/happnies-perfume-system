<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $user = User::find(auth()->id());

        $validated = $request->validated();

        if ($validated['password']) {
            if (!Hash::check($validated['old_password'], auth()->user()->password)) {
                return back()->with('error', 'كلمة المرور الحالية غير صحيحة');
            }

            $validated['password'] = Hash::make($validated['password']);
            $user->update($validated);
            return Logout::boot("تم تغيير كلمة المرور بنجاح .");
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'تم تغيير البيانات الشخصية بنجاح.');
    }
}
