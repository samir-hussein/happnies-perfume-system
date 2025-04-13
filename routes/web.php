<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Expenses\ExpensesController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\Pay\PayController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Safe\SafeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Wholesale\WholesaleController;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get("/licence", function () {
//     return view("error.licence");
// })->name('licence');


Route::middleware("already.inuse")->group(function () {
    Route::get('/first-use', function () {
        return view('register');
    })->name("first-use");

    Route::post('/register', [AuthController::class, "store"])->name("register");
});

Route::get("online/order", [OrderController::class, "onlineOrdersList"])->name("order.online");
Route::get("online/order/{order}", [OrderController::class, "onlineShow"])->name("order.online.show");
Route::get("online/order/{order}/done", [OrderController::class, "onlinePay"])->name("order.online.done");
Route::delete("online/order/{order}/cancel", [OrderController::class, "onlineCancel"])->name("order.online.cancel");

Route::get("login", function () {
    return view('login');
})->name("login");

Route::post("login", [AuthController::class, "login"])->name("login.submit");

Route::get("/product/search", [ProductController::class, "search"])->name("product.search");

Route::get("/pay", [PayController::class, "store"])->name("pay.store");
Route::get("/pay/{order}", [PayController::class, "update"])->name("pay.update");

Route::middleware("first.use")->group(function () {
    Route::get('/', function () {
        return view('welcome', [
            "employees" => Employee::latest()->get("name")
        ]);
    })->name('home');

    Route::get('/online', function () {
        return view('online', [
            "employees" => Employee::latest()->get("name")
        ]);
    })->name('online');

    Route::prefix("dashboard")->name("dashboard.")->middleware("auth")->group(function () {
        Route::get('/home', [WelcomeController::class, "index"])->name('home');

        Route::get('/profile', function () {
            return view('dashboard.profile');
        })->name('profile');

        Route::get("wholesale", [WholesaleController::class, 'index'])->name('wholesale.index');
        Route::post("wholesale", [WholesaleController::class, 'store'])->name('wholesale.store');

        Route::get('report', [ReportController::class, 'index'])->name('report.index');

        Route::put('/profile', [ProfileController::class, "update"])->name('profile.update');

        Route::get('logout', [AuthController::class, "logout"])->name("logout");

        Route::get('notification', [NotificationController::class, "index"])->name("notification.index");
        Route::get('notification/new/count', [NotificationController::class, "newCount"])->name("notification.new.count");

        Route::apiResource("category", CategoryController::class)->missing(function () {
            return abort(404);
        })->except("show");

        Route::apiResource("employee", EmployeeController::class)->missing(function () {
            return abort(404);
        })->except("show");

        Route::post("/partner/store-capital", [PartnerController::class, "storeCapital"])->name("partner.capital.store");
        Route::post("/partner/pay-profits", [PartnerController::class, "payProfits"])->name("partner.payProfits.store");

        Route::get("/client", [ClientController::class, "index"])->name("client.index");

        Route::apiResource("partner", PartnerController::class)->missing(function () {
            return abort(404);
        });

        Route::get("online/order", [OrderController::class, "online"])->name("order.online");

        Route::apiResource("order", OrderController::class)->missing(function () {
            return abort(404);
        })->only(["index", "show"]);

        Route::apiResource("safe", SafeController::class)->missing(function () {
            return abort(404);
        })->only(["index", "store"]);

        Route::apiResource("expenses", ExpensesController::class)->missing(function () {
            return abort(404);
        })->only(["index", "store"]);

        Route::resource("user", UserController::class)->missing(function () {
            return abort(404);
        })->only(["create", "index", "destroy", "store"]);

        Route::resource("/product", ProductController::class)->missing(function () {
            return abort(404);
        })->except("edit");
    });
});
