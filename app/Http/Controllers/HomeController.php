<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function saveAddress(Request $request)
    {
        $request->validate([
            'street'=>'required',
            'city'=>'required',
            'postal_code'=>'required',
            'country'=>'required'
        ]);

        $user = Auth::user();
        $user->address()->save([
            'street' => $request->get('street'),
            'city' => $request->get('city'),
            'postal_code' => $request->get('postal_code'),
            'country' => $request->get('country'),
        ]);
    }
}
