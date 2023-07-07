<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckLogin;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('viewlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([CheckLogin::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');
    Route::get('/sanpham', function () {
        $products =  DB::table('products')->get();
        // return response()->json([
        //     'products' => $products
        // ]);
        return view('sanpham', compact('products'));
    })->name('sanpham');
    Route::get('/api/sanpham', function (Request $request) {
        $keyword = $request->id;

        $products = DB::table('products')
            ->where('id', 'like', '%' . $keyword . '%')
            ->orWhere('name', 'like', '%' . $keyword . '%')
            ->orWhere('quantity', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/api/nhanvien', function (Request $request) {
        $keyword = $request->id;
        $products = DB::table('users')
            ->where('role', '=', '0')
            ->where(function ($query) use ($keyword) {
                $query->orWhere('id', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/nhanvien', function () {
       
        return view('quanlynhanvien');
    })->name('nhanvien');

    Route::post('/add_products', [HomeController::class, 'add_products'])->name('add_products');
    Route::post('/add_employee', [HomeController::class, 'add_employee'])->name('add_employee');
    Route::get('/delete_products/{id}', [HomeController::class, 'delete_products'])->name('delete_products');
    Route::get('/delete_users/{id}', [HomeController::class, 'delete_users'])->name('delete_users');
    Route::get('/update/{id}', [HomeController::class, 'update_products'])->name('update_products');
    Route::get('/update_users/{id}', [HomeController::class, 'update_users'])->name('update_users');
    Route::get('/edit/{id}', [HomeController::class, 'edit_products'])->name('edit_products');
    Route::get('/edit_users/{id}', [HomeController::class, 'edit_users'])->name('edit_users');

});
