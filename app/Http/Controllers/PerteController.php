<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Perte;
use App\Models\Product;
use App\Models\Kurangura;
use App\Models\Typeperte;
use Illuminate\Http\Request;

class PerteController extends Controller
{
    //
    public function perte_create()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $ProduitStock = Product::with('Produitname', 'category')->get();
        $typeperte = Typeperte::all();
        $ProduitPerdu = Perte::orderBy('created_at', 'DESC')->with('Produitname', 'category','Typeperte')->get();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('pertes',compact('countKurangura','warnCount','userRole','ProduitStock','typeperte','ProduitPerdu'));
    }

    public function perte_store(Request $request)
    {
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product=$request->nameProduct;
        $quantity=$request->quantite;
        $typeperte=$request->typeperte;
        $description=$request->Description;

        $ProduitStock = Product::where('product_Article_id', '=',$product)->first();
        $QttStock=$ProduitStock->quantity;
        if($quantity>$QttStock){
            return redirect()->back()->with('saveErrorPerte','Erreur, la quantite perdue est superieur a la quantite que vous avez actuellement dans le stock !');
        }
        $unitPrice=$ProduitStock->unitPrice;
        $QttResta=$QttStock-$quantity;
        $totalPrice=$unitPrice*$QttResta;

        $ProduitPerdu = new Perte();
        $ProduitPerdu->date= Carbon::now()->toDateString();
        $ProduitPerdu->product_Article_id= $product;
        $ProduitPerdu->category_id = $ProduitStock->category_id;
        $ProduitPerdu->quantity= $quantity;
        $ProduitPerdu->unitPrice= $unitPrice;
        $ProduitPerdu->totalPrice= $quantity*$unitPrice;
        $ProduitPerdu->typeperte_id = $typeperte;
        $ProduitPerdu->Description = $description;
        $ProduitPerdu->user_id = $userRole->id;
        $ProduitPerdu->save();

        if($ProduitPerdu->save()){
        $quantityDecrement=Product::where('product_Article_id', '=',$product)->first();
        $quantityDecrement->quantity=$QttStock-$quantity;
        $quantityDecrement->totalPrice=$totalPrice;
        $quantityDecrement->save();
        if($quantityDecrement->save()){
            return redirect()->back()->with('savePerte','Perte enrengistre avec succes !');
        }
        }
    }

    public function updatePerte(Request $request,$id)
    {
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product=$request->nameProduct;
        $quantity=$request->quantite;
        $typeperte=$request->typeperte;
        $description=$request->Description;

        $ProduitStock = Product::where('product_Article_id', '=',$product)->first();
        $dataPerdu = Perte::where('product_Article_id', '=',$product)->first();
        $QttStock=$ProduitStock->quantity;
        $qttPerdu=$dataPerdu->quantity;
        $qttzero=$quantity-$qttPerdu;

        if($quantity>$QttStock){
            return redirect()->back()->with('saveErrorPerte','Erreur, la quantite perdue est superieur a la quantite que vous avez actuellement dans le stock !');
        }

        if($quantity>$qttPerdu){
            $quttyAsoustraire=$quantity-$qttPerdu;
            $QttResta=$QttStock-$quttyAsoustraire;

        $unitPrice=$ProduitStock->unitPrice;
        $totalPrice=$unitPrice*$QttResta;

        $ProduitPerdu = Perte::find($id);
        $ProduitPerdu->product_Article_id= $product;
        $ProduitPerdu->category_id = $ProduitStock->category_id;
        $ProduitPerdu->quantity= $quantity;
        $ProduitPerdu->unitPrice= $unitPrice;
        $ProduitPerdu->totalPrice= $quantity*$unitPrice;
        $ProduitPerdu->typeperte_id = $typeperte;
        $ProduitPerdu->Description = $description;
        $ProduitPerdu->save();

        if($ProduitPerdu->save()){
        $quantityDecrement=Product::where('product_Article_id', '=',$product)->first();
        $quantityDecrement->quantity=$QttResta;
        $quantityDecrement->totalPrice=$totalPrice;
        $quantityDecrement->save();
        }
        if($quantityDecrement->save()){
            return redirect()->route('perte_create')->with('savePerte','Perte Modifier avec succes !');
        }
        }
    }

    public function editPerte($id){

        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $product = Product::with('Produitname', 'category')->get();
        $perteType = Typeperte::all();
        $pertes = Perte::with('Produitname','Typeperte')->where('id','=',$id)->first();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

        return view('editPerte',compact('countKurangura','warnCount','product','perteType','pertes','userRole'));
        }
}
