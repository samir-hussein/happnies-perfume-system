<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
    public static function boot(array $request)
    {
        $request['password'] = Hash::make($request['password']);

        try {
            DB::beginTransaction();
            User::create($request);

            DB::commit();
            return back()->with("success", "تم انشاء الحساب بنجاح");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withError('لقد حدث خطأ ما.');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withError('لقد حدث خطأ ما.');
        }
    }
}
