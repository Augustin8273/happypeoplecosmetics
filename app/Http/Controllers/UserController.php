<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Product;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index(){

        return view('login');
    }
    public function dashboard(){
        $countStore=Product::all()->count();
        $countKurangura=Kurangura::all()->count();

        return view('dashboard',compact('countStore','countKurangura'));
    }

    public function login(Request $request){


        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        // check email if exist in database

        $champs = 'email';
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {

            $champs = 'username';
        }

        $user = User::where($champs, $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return redirect()->back()->with('message', 'Email ou Mot de passe est incorrect');
        } else {
            $request->session()->put('loginId', $user->id);
            $data = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

                return redirect()->route('dashboard');
        }
    }

        public function logout()
    {
        if (session()->has('loginId')) {
            Session()->pull('loginId');
            Session()->pull('message');
            Session()->pull('wellmessage');
            return redirect()->route('loginCreate');
        }
    }

    public function kurangura_pdf(){
        $item=Kurangura::all();
        $current=Carbon::now()->toDateString();
        $pdf = Pdf::loadView('kuranguraPdf',['item'=>$item,'current'=>$current]);
        return $pdf->download('Hpc-kurangura-Le-'.$current.'.pdf');
    }


}
