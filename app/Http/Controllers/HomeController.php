<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function add_products(Request $request)
    {
        $name = $request->get('name');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        DB::table('products')->insert([
            [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price
            ]

        ]);
        return redirect()->route('sanpham');
    }
    public function delete_products($id)
    {
        DB::table('products')->where('id', '=', $id)->delete();
        return redirect()->route('sanpham');
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
    public function delete_users(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->delete();
        return redirect()->route('nhanvien');
    }
    public function update_users(Request $request){
        $products =  DB::table('users')->where('id', '=', $request->id)->get();
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
}
