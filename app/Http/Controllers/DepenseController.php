<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $showButton='no';
        $sortis = Sorti::with('Produitname', 'category','User')->get();
        $depenses = Depense::orderBy('created_at', 'DESC')->get();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('depenses',
        compact(
            'countKurangura',
        'warnCount',
        'userRole',
        'sortis',
        'depenses',
        'showButton'));
    }

    public function depense_edit($id)
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $depense = Depense::find($id);
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('editDepense',
        compact(
            'countKurangura',
        'warnCount',
        'userRole',
        'depense'));
    }

    public function depense_store(Request $request){
        $amount=$request->quantite;
        $destination=$request->Destination;
        $description=$request->Description;

        $data=new Depense();
        $data->date=Carbon::now()->toDateString();
        $data->amount=$amount;
        $data->Destination=$destination;
        $data->Description=$description;

        $data->save();

        if($data->save()){
            return redirect()->back()->with('savePerte','Depense enrengistre avec succes !');
        }
    }
    public function depenseUpdate(Request $request,$id){
        $amount=$request->quantite;
        $destination=$request->Destination;
        $description=$request->Description;

        $data= Depense::find($id);
        $data->amount=$amount;
        $data->Destination=$destination;
        $data->Description=$description;

        $data->save();

        if($data->save()){
            return redirect()->route('depense_create')->with('updateDepense','Depense modifie avec succes !');
        }
    }



    public function DepenseListSortedByDate(Request $request)
    {
        $fromDate=$request->fromDate;
        $endDate=$request->endDate;
        if($fromDate && $endDate){
        $userRole=User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $sortis = Sorti::with('Category','Produitname','User')->whereBetween('date',[$fromDate,$endDate])->get();
        $showButton='yes';
        $depenses = Depense::orderBy('created_at', 'DESC')->whereBetween('date',[$fromDate,$endDate])->get();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();

        return view('depenses', compact('depenses','sortis','userRole','showButton','countKurangura','warnCount'));
        }else{
        return redirect()->route('depense_create');
        }
    }
}
