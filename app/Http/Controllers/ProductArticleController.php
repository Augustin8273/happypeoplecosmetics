<?php

namespace App\Http\Controllers;

use App\Models\ProductArticle;
use Illuminate\Http\Request;

class ProductArticleController extends Controller
{
    //

    public function produit_article_create()
    {

        return view('productArticle');
    }

    public function produit_article_list()
    {

        $article = ProductArticle::all();
        return view('productArticleList', compact('article'));
    }

    public function produit_article_update_create($id)
    {
        $article = ProductArticle::find($id);
        return view('productArticleUpdate',compact('article'));
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
