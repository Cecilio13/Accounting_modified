<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Customers;
use App\ProductsAndServices;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        return redirect()->intended('/dashboard');
    }
}
