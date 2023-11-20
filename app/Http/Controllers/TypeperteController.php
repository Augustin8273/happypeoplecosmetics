<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perte;
use App\Models\Product;
use App\Models\Kurangura;
use App\Models\Typeperte;
use Illuminate\Http\Request;

class TypeperteController extends Controller
{
    //
    public function type_perte_create()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $typeperte = Typeperte::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('typeperte',compact('countKurangura','warnCount','userRole','typeperte'));
    }

    public function type_perte_store(Request $request){
        $name=$request->nameType;
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $check=Typeperte::where('name','=',$name)->first();
        if($check){
            return back()->with('saveErrorArticleMessage','Desole, le type de perte existe deja');
        }else{
            $data=new Typeperte();
            $data->name=$name;
            $data->user_id=$userRole->id;
            $data->save();

            if($data->save()){
                return back()->with('saveProductArticle','Succes, le type de perte enregistre avec succes !');
            }
        }

    }
}
