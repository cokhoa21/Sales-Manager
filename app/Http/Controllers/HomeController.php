<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{


    public function banhang()
    {
        return view('banhang',[
            'products' => DB::table('products')->get(),
            'customers' => DB::table('customers')->get(),
        ]);
    }
    public function add_products(Request $request)
    {
        $name = $request->get('name');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $price_cost = $request->get('price_cost');

        DB::table('products')->insert([
            [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'price_cost' => $price_cost,
            ]

        ]);
        return redirect()->route('sanpham');
    }


    public function delete_products($id)
    {
        DB::table('products')->where('id', '=', $id)->delete();
        return redirect()->route('sanpham');
    }

    public function delete_bill($id)
    {
        DB::table('bill')->where('id', '=', $id)->delete();
        return redirect()->route('donhang');
    }
    public function update_products($id)
    {
        $products =  DB::table('products')->where('id', '=', $id)->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function edit_products(Request $request, $id)
    {
        $name = $request->get('name');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        // dd($name,$quantity,$price);
        DB::table('products')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        return redirect()->route('sanpham');
    }
    public function add_employee(Request $request)
    {
        $randomString = strval(rand(10000, 99999));
        $email = $request->email;
        DB::table('users')->insert([
            [
                'email' => $email,
                'role' => 0,
                'password' => $randomString,
            ],
        ]);
        $details = [
            'title' => 'Mật khẩu của bạn là',
            'body' => $randomString
        ];

        Mail::to($email)->send(new \App\Mail\MyTestMail($details));
        return redirect()->route('nhanvien');
    }

    public function add_customer(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $address = $request->address;
        $phone = $request->phone;
        DB::table('customers')->insert([
            [
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
        ]);

        return redirect()->route('khachhang');
    }

    public function add_bill(Request $request)
    {
        $customer_id = null;
        $array_product = [];
        foreach ($request->all() as $name => $value){
            if($name =='customer_id'){
                $customer_id = $value;
            }
            if(str_contains($name, 'quality-product-')){
                $id= str_replace('quality-product-','',$name);
                $array_product[$id] = $value;
            }
        }
        foreach ($array_product as $key => $value){
            $product = DB::table('products')->where('id', '=', $key)->first();
            if($product->quantity < $value){
                return response()->json([
                    'status' => -1,
                    'message' => 'Số lượng sản phẩm '.$product->name .' không đủ'
                ]);
            }
            $quantity = $product->quantity - $value;
            DB::table('products')
                ->where('id', $key)
                ->update([
                    'quantity' => $quantity,
                ]);
            DB::table('bill')->insert(
                [
                    'customer_id' => $customer_id,
                    'product_id' => $key,
                    'quality' => $value,
                    'nv_id' => Session::get('user')->id ?? 1,
                    'total_price' => $product->price * $value,
                    'total_cost' => $product->price_cost * $value,
                ]
            );
            $day = now()->day;
            $month = now()->month;
            $year = now()->year;
            $check = DB::table('satistic')->where('product_id', '=', $key)->where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->first();
            if(!$check){
                DB::table('satistic')->insert(
                    [
                        'product_id' => $key,
                        'quality' => $value,
                        'total' => $product->price * $value,
                        'cost' => $product->price_cost * $value,
                        'day' => $day,
                        'month' => $month,
                        'year' => $year,
                    ]
                );
            }else{
                $total = $check->total + ($product->price * $value);
                $cost = $check->cost + ($product->price_cost * $value);
                $quality = $check->quality + $value;
                DB::table('satistic')
                    ->where('id', $check->id)
                    ->update([
                        'quality' => $quality,
                        'total' => $total,
                        'cost' => $cost,
                    ]);
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Đã thêm thành công'
        ]);
    }

    public function delete_users(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->delete();
        return redirect()->route('nhanvien');
    }

    public function delete_customer(Request $request, $id){
        DB::table('customers')->where('id', '=', $id)->delete();
        return redirect()->route('khachhang');
    }
    public function update_users(Request $request){
        $products =  DB::table('users')->where('id', '=', $request->id)->get();
        return response()->json([
            'products' => $products
        ]);
    }

    public function update_customer(Request $request){
        $products =  DB::table('customers')->where('id', '=', $request->id)->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function edit_users(Request $request,$id){
        $email = $request->get('email');
        DB::table('users')
            ->where('id', $id)
            ->update([
                'email' => $email,
            ]);
        return redirect()->route('nhanvien');
    }

    public function edit_customer(Request $request,$id){
        $email = $request->get('email');
        $name = $request->get('name');
        $address = $request->get('address');
        $phone = $request->get('phone');
        DB::table('customers')
            ->where('id', $id)
            ->update([
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ]);
        return redirect()->route('khachhang');
    }

}
