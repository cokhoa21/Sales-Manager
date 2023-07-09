<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// use GuzzleHttp\Psr7\Request;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('viewlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([CheckLogin::class])->group(function ()
{
    Route::get('/', function ()
    {
        return view('index');
    })->name('index');
    Route::get('/sanpham', function ()
    {
        $products = DB::table('products')->get();
        // return response()->json([
        //     'products' => $products
        // ]);
        return view('sanpham', compact('products'));
    })->name('sanpham');

    Route::get('/thongkesanpham', function (){
        $results = DB::table('bill')
            ->select('product_id', DB::raw('SUM(quality) AS quality_product'))
            ->groupBy('product_id')
            ->orderByDesc('quality_product')
            ->limit(5)
            ->get();
        foreach ($results as $item){
            $item->name = DB::table('products')->where('id', '=', $item->product_id)->first()->name;
        }

        return view('thongkesanpham', [
            'results' => $results
        ]);
    })->name('thongkesanpham');

    Route::get('/thongkekhachhang', function (){
        $results = DB::table('bill')
            ->select('customer_id', DB::raw('SUM(total_price) AS total_cus_price'))
            ->groupBy('customer_id')
            ->orderByDesc('total_cus_price')
            ->limit(5)
            ->get();
        foreach ($results as $item){
            $item->name = DB::table('customers')->where('id', '=', $item->customer_id)->first()->name;
        }
        return view('thongkekhachhang', [
            'results' => $results
        ]);
    })->name('thongkekhachhang');
    Route::get('/thongkenhanvien', function ()
    {
        $results = DB::table('bill')
            ->select('nv_id', DB::raw('SUM(total_price) AS total_revenue'))
            ->groupBy('nv_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();
        foreach ($results as $item){
            $item->name = DB::table('users')->where('id', '=', $item->nv_id)->first()->email;
        }
        $arrLalbe =[];
        $stringLable ='';
        $arrData = [];
        $users = DB::table('users')->get();
        foreach ($users as $user){
            $arrLalbel[] = $user->email;
           foreach ($results as $result){
               if($user->id == $result->nv_id){
                   $arrData[] = $result->total_revenue;
               }
           }
        }
        foreach ($arrLalbel as $key => $value){
            $stringLable .= $value.', ';
            if(!isset($arrData[$key])){
                $arrData[$key] = 0;
            }
        }

        return view('thongkenhanvien', [
            'chartLabel' =>             $stringLable,

            'chartData' =>             implode(', ', ($arrData)),

        ]);
    })->name('thongkenhanvien');

    Route::get('/thongkeloinhuan', function (Request $request)
    {
        $timeSelect = 7;
        if($request->time){
            $timeSelect = $request->time;
        }
        $totalPrice              = DB::table('bill')->sum('total_price');
        $totalCost               = $totalPrice - DB::table('bill')->sum('total_cost');

        $time = now();
        $data = [];
        $data2= [];
        $label = [];
        for($i = 0; $i < $timeSelect; $i++)
        {
            $dataTime = $time->subDay($i);
            $label[] = $time->format('d-m-Y');
            $day = $dataTime->day;
            $month = $dataTime->month;
            $year = $dataTime->year;
            $data[$i] = DB::table('satistic')
                ->where('day', '=', $day)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->sum('total');
            $cost =DB::table('satistic')
                ->where('day', '=', $day)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->sum('cost');
            $data2[$i] = $data[$i] - $cost;
        }

        return view('thongkeloinhuan',
            [

                'totalPrice'        => $totalPrice,
                'totalCost'         => $totalCost,
                'dataChart'              => implode(', ', array_reverse($data)),
                'dataChart2'              => implode(', ', array_reverse($data2)),
                'labelChart'              => implode(', ', array_reverse($label)),
                'timeSelect'        => $timeSelect,
            ]
        );
    })->name('thongkeloinhuan');

    Route::get('/thongke', function ()
    {
        $totalProductBIll        = DB::table('bill')->sum('quality');
        $totalPrice              = DB::table('bill')->sum('total_price');
        $totalCustomerBest       = DB::table('bill')
            ->select('customer_id', DB::raw('SUM(total_price) as total_spent'))
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->first();
        $totalCustomerBest->name = DB::table('customers')->where('id', '=', $totalCustomerBest->customer_id)->first()->name;
        $productBest             = DB::table('bill')
            ->select('product_id', DB::raw('SUM(quality) as total_quality'))
            ->groupBy('product_id')
            ->orderByDesc('total_quality')
            ->first();
        $productBest->name       = DB::table('products')->where('id', '=', $productBest->product_id)->first()->name;

        $time = now();
        $data = [];
        for($i = 0; $i < 7; $i++)
        {
            $dataTime = $time->subDay($i);
            $day = $dataTime->day;
            $month = $dataTime->month;
            $year = $dataTime->year;
            $data[$i] = DB::table('satistic')
                ->where('day', '=', $day)
                ->where('month', '=', $month)
                ->where('year', '=', $year)
                ->sum('quality');
        }
        return view('thongke',
            [
                'totalProductBIll'  => $totalProductBIll,
                'totalPrice'        => $totalPrice,
                'totalCustomerBest' => $totalCustomerBest,
                'productBest'       => $productBest,
                'dataChart'              => implode(', ', array_reverse($data))
        ]
        );
    })->name('thongke');

    Route::get('/api/sanpham', function (Request $request)
    {
        $keyword = $request->id;

        $products = DB::table('products')
            ->where('id', 'like', '%' . $keyword . '%')
            ->orWhere('name', 'like', '%' . $keyword . '%')
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/api/nhanvien', function (Request $request)
    {
        $keyword  = $request->id;
        $products = DB::table('users')
            ->where('role', '=', '0')
            ->where(function ($query) use ($keyword)
            {
                $query->orWhere('id', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/nhanvien', function ()
    {

        return view('quanlynhanvien');
    })->name('nhanvien');

    Route::get('/donhang', function ()
    {
        $bill = DB::table('bill')->get();
        foreach ($bill as $item)
        {
            $item->customer_name = DB::table('customers')->where('id', '=', $item->customer_id)->first()->name;
            $item->product_name  = DB::table('products')->where('id', '=', $item->product_id)->first()->name;
        }
        return view('donhang', [
            'bill' => $bill

        ]);
    })->name('donhang');


    Route::get('/khachhang', function ()
    {

        return view('quanlykhachhang');
    })->name('khachhang');
    Route::get('/api/khachhang', function (Request $request)
    {
        $keyword  = $request->id;
        $products = DB::table('customers')
            ->where(function ($query) use ($keyword)
            {
                $query->orWhere('id', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%');
            })
            ->get();
        return response()->json([
            'products' => $products
        ]);
    });
    Route::get('/banhang', [HomeController::class, 'banhang'])->name('banhang');

    Route::post('/add_products', [HomeController::class, 'add_products'])->name('add_products');
    Route::post('/add_employee', [HomeController::class, 'add_employee'])->name('add_employee');

    Route::post('/add_customer', [HomeController::class, 'add_customer'])->name('add_customer');
    Route::post('/add_bill', [HomeController::class, 'add_bill'])->name('add_bill');
    Route::get('/check_bill', [HomeController::class, 'check_bill'])->name('check_bill');

    Route::get('/delete_products/{id}', [HomeController::class, 'delete_products'])->name('delete_products');
    Route::get('/delete_users/{id}', [HomeController::class, 'delete_users'])->name('delete_users');
    Route::get('/update/{id}', [HomeController::class, 'update_products'])->name('update_products');
    Route::get('/update_users/{id}', [HomeController::class, 'update_users'])->name('update_users');
    Route::get('/update_customer/{id}', [HomeController::class, 'update_customer'])->name('update_customer');
    Route::get('/delete_customer/{id}', [HomeController::class, 'delete_customer'])->name('delete_customer');
    Route::get('/delete_bill/{id}', [HomeController::class, 'delete_bill'])->name('delete_bill');

    Route::get('/edit/{id}', [HomeController::class, 'edit_products'])->name('edit_products');
    Route::get('/edit_users/{id}', [HomeController::class, 'edit_users'])->name('edit_users');
    Route::get('/edit_customer/{id}', [HomeController::class, 'edit_customer'])->name('edit_customer');


});
