<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;

class ProductArticleController extends Controller
{
    //

    public function produit_article_create()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('productArticle',compact('countKurangura','warnCount','userRole'));
    }

    public function produit_article_list()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = ProductArticle::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('productArticleList', compact('article','countKurangura','warnCount','userRole'));
    }

    public function produit_article_update_create($id)
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = ProductArticle::find($id);
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('productArticleUpdate',compact('article','countKurangura','warnCount','userRole'));
    }

    public function productArticleStore(Request $request)
    {

        $nameProduct = $request->nameProduct;
        $wholeSalePrice = $request->wholeSalePrice;
        $discount = $request->discount;
        if ($discount) {
            $checkExist = ProductArticle::where('nameProduct', '=', $nameProduct)->first();
            if ($checkExist) {
                return back()->with('saveErrorArticleMessage', 'Desole, le nom du produit existe deja, veuillez essayer un autre !');
            }
            $article = new ProductArticle();
            $article->nameProduct = $nameProduct;
            $article->wholeSalePrice = $wholeSalePrice;
            $article->discount = $discount;

            $article->save();

            if ($article->save()) {
                return redirect()->route('produit_list')->with('saveProductArticle', 'Nom du produit enregistre avec succes');
            }
        } else {
            $checkExist = ProductArticle::where('nameProduct', '=', $nameProduct)->first();
            if ($checkExist) {
                return back()->with('saveErrorArticleMessage', 'Desole, le nom du produit existe deja, veuillez essayer un autre !');
            }
            $article = new ProductArticle();
            $article->nameProduct = $nameProduct;
            $article->wholeSalePrice = $wholeSalePrice;

            $article->save();

            if ($article->save()) {
                return redirect()->route('produit_list')->with('saveProductArticle', 'Nom du produit enregistre avec succes');
            }
        }
    }

    public function productArticleUpdate(Request $request,$id)
    {

        $nameProduct = $request->nameProduct;
        $wholeSalePrice = $request->wholeSalePrice;
        $discount = $request->discount;
        if ($discount) {

            $article = ProductArticle::find($id);
            $article->nameProduct = $nameProduct;
            $article->wholeSalePrice = $wholeSalePrice;
            $article->discount = $discount;

            $article->save();

            if ($article->save()) {
                return redirect()->route('produit_list')->with('updateProductArticle', 'Nom du produit modifie avec succes');
            }
        } else {

            $article = ProductArticle::find($id);
            $article->nameProduct = $nameProduct;
            $article->wholeSalePrice = $wholeSalePrice;

            $article->save();

            if ($article->save()) {
                return redirect()->route('produit_list')->with('updateProductArticle', 'Nom du produit modifie avec succes');
            }
        }
    }

}
