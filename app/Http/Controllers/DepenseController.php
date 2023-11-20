<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perte;
use App\Models\Sorti;
use App\Models\Depense;
use App\Models\Product;
use App\Models\Kurangura;
use App\Models\Typeperte;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    //
    public function depense_create()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $sortis = Sorti::with('Produitname', 'category','User')->get();
        $depenses = Depense::orderBy('created_at', 'DESC')->get();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('depenses',compact('countKurangura','warnCount','userRole','sortis','depenses'));
    }
}
