<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Entrees;
use App\Models\Product;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function productCreate(){

        $article = ProductArticle::all();
        return view('addProduct',compact('article'));
    }

    public function stockList(){

        $article = ProductArticle::all();
        $product = Product::with('Produitname')->get();
        return view('stock',compact('product','article'));
    }
    public function productListShow(){

        $article = ProductArticle::all();
        $product = Product::with('Produitname')->get();
        return view('productListShow',compact('product','article'));
    }

    public function histoEntrees(){

        $article = ProductArticle::all();
        $product = Entrees::with('Produitname')->get();
        return view('entrees',compact('product','article'));
    }
    public function kurangura(){

        $article = Kurangura::all();
        return view('kurangura',compact('article'));
    }


    public function guhinduraKimwe($id)
    {
        $article = Kurangura::find($id);
        return view('kuranguraGuhindura',compact('article'));
    }
    public function gufutaKimwe($id)
    {
        $article = Kurangura::find($id);
        $article->delete();
        return back()->with('saveErrorArticleMessage','Produit retire sur la liste avec succes');
    }

    public function kuranguraStore(Request $request){

        $nameProduct = $request->nameProduct;
        $quantite = $request->quantite;
        $description = $request->description;
        if ($description) {
            $checkExist = Kurangura::where('nameProduct', '=', $nameProduct)->first();
            if ($checkExist) {
                return back()->with('saveErrorArticleMessage', 'Desole, le nom du produit est deja sur la liste des achats a venir, veuillez essayer un autre !');
            }
            $article = new Kurangura();
            $article->nameProduct = $nameProduct;
            $article->quantite = $quantite;
            $article->description = $description;

            $article->save();

            if ($article->save()) {
                return redirect()->route('rangura')->with('saveProductArticle', 'Nom du produit enregistre avec succes');
            }
        } else {
            $checkExist = Kurangura::where('nameProduct', '=', $nameProduct)->first();
            if ($checkExist) {
                return back()->with('saveErrorArticleMessage', 'Desole, le nom du produit est deja sur la liste des achats a venir, veuillez essayer un autre !');
            }
            $article = new Kurangura();
            $article->nameProduct = $nameProduct;
            $article->quantite = $quantite;

            $article->save();

            if ($article->save()) {
                return redirect()->route('rangura')->with('saveProductArticle', 'Nom du produit enregistre avec succes');
            }
        }
    }

    public function guhinduraIbirangurwa(Request $request,$id){
        $nameProduct = $request->nameProduct;
        $quantite = $request->quantite;
        $description = $request->description;
            $article = Kurangura::find($id);
            $article->nameProduct = $nameProduct;
            $article->quantite = $quantite;
            $article->description = $description;

            $article->save();

            if ($article->save()) {
                return redirect()->route('rangura')->with('updateProductArticle', 'Ikidandazwa co kurangura casubiwemwo neza cane !');
            }

}

    public function productStore(Request $request){

        $nameProduct=$request->article_id;
        $quantite=$request->quantite;
        $prixUnitaire=$request->prixUnitaire;
        // $observation=$request->observation;

        for ($i = 0; $i < count($nameProduct); $i++) {
        $dataProduct = Product::where('product_article_id', $nameProduct[$i])->first();
        $Qtotal = 0;
        if($dataProduct){
            $qtty=$dataProduct->quantity;
            $dataProduct->quantity=$quantite[$i]+$qtty;
            $qttyActuelStock=$quantite[$i]+$qtty;
            $dataProduct->unitPrice = $prixUnitaire[$i];
            $dataProduct->totalPrice = $qttyActuelStock*$prixUnitaire[$i];
            $dataProduct->save();
        }else{
            $dataProduct=new Product();
                $dataProduct->date = Carbon::now()->toDateString();
                $dataProduct->product_Article_id = $nameProduct[$i];
                $dataProduct->quantity = $quantite[$i];
                $dataProduct->unitPrice = $prixUnitaire[$i];
                $dataProduct->totalPrice = $quantite[$i]*$prixUnitaire[$i];
                // 'observation' => $observation[$i];

                $dataProduct->save();
        }

        $dataProduct=new Entrees();
                $dataProduct->date = Carbon::now()->toDateString();
                $dataProduct->product_Article_id = $nameProduct[$i];
                $dataProduct->quantity = $quantite[$i];
                $dataProduct->unitPrice = $prixUnitaire[$i];
                $dataProduct->totalPrice = $quantite[$i]*$prixUnitaire[$i];

                $dataProduct->save();

        }

        if($dataProduct->save()){
                return redirect()->route('stock')->with('saveProduct', 'Stock approvisionne avec succes');
            }

    }

    public function gufutaIbirangurwa(){
        Kurangura::truncate();
        return redirect()->back()->with('saveProductArticle', 'Mwafuse neza urupapuro rw'.'ibirangurwa');
    }
}
