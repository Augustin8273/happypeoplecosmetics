<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sorti;
use App\Models\Entrees;
use App\Models\Product;
use App\Models\Category;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function productCreate()
    {
        $category = Category::all();
        $article = ProductArticle::all();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('addProduct', compact('article', 'category','countKurangura','warnCount','userRole'));
    }

    public function productCreateRecherche($id)
    {
        $category = Category::all();
        $article = ProductArticle::where('id','=',$id)->first();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('approvisionerRecherche', compact('article', 'category','countKurangura','warnCount','userRole'));
    }

    public function stockList()
    {

        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Produitname', 'Category')->get();
        return view('stock', compact('product', 'article', 'category','countKurangura','warnCount','userRole'));
    }
    public function productListShow()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = ProductArticle::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Produitname', 'Category')->get();
        return view('productListShow', compact('product', 'article','countKurangura','warnCount','userRole'));
    }

    public function histoEntrees()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = ProductArticle::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Entrees::with('Produitname', 'Category')->get();
        return view('entrees', compact('product', 'article','countKurangura','warnCount','userRole'));
    }
    public function kurangura()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = Kurangura::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('kurangura', compact('article','countKurangura','warnCount','userRole'));
    }


    public function guhinduraKimwe($id)
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $article = Kurangura::find($id);
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('kuranguraGuhindura', compact('article','countKurangura','warnCount','userRole'));
    }
    public function gufutaKimwe($id)
    {
        $article = Kurangura::find($id);
        $article->delete();
        return back()->with('saveErrorArticleMessage', 'Produit retire sur la liste avec succes');
    }

    public function kuranguraStore(Request $request)
    {
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

    public function guhinduraIbirangurwa(Request $request, $id)
    {
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

    public function productStore(Request $request)
    {

        $nameProduct = $request->article_id;
        $quantite = $request->quantite;
        $prixUnitaire = $request->prixUnitaire;
        $nameCategory = $request->category;

        for ($i = 0; $i < count($nameProduct); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct[$i])->first();
            $Qtotal = 0;
            if ($dataProduct) {
                $qtty = $dataProduct->quantity;
                $qttyStatus = $dataProduct->status;
                $dataProduct->quantity = $quantite[$i] + $qtty;
                $qttyActuelStock = $quantite[$i] + $qtty;
                $dataProduct->unitPrice = $prixUnitaire[$i];
                $dataProduct->totalPrice = $qttyActuelStock * $prixUnitaire[$i];
                $dataProduct->category_id = $nameCategory[$i];
                if ($qtty <= 0) {
                    $dataProduct->status = $quantite[$i];
                } else {
                    $dataProduct->status = $qtty + $quantite[$i];
                }
                $dataProduct->save();
            } else {
                $dataProduct = new Product();
                $dataProduct->date = Carbon::now()->toDateString();
                $dataProduct->product_Article_id = $nameProduct[$i];
                $dataProduct->quantity = $quantite[$i];
                $dataProduct->unitPrice = $prixUnitaire[$i];
                $dataProduct->totalPrice = $quantite[$i] * $prixUnitaire[$i];
                $dataProduct->category_id = $nameCategory[$i];
                $dataProduct->status = $quantite[$i];

                $dataProduct->save();
            }

            $dataProducts = new Entrees();
            $dataProducts->date = Carbon::now()->toDateString();
            $dataProducts->product_Article_id = $nameProduct[$i];
            $dataProducts->quantity = $quantite[$i];
            $dataProducts->unitPrice = $prixUnitaire[$i];
            $dataProducts->totalPrice = $quantite[$i] * $prixUnitaire[$i];
            $dataProducts->category_id = $nameCategory[$i];

            $dataProducts->save();
        }

        if ($dataProducts->save()) {
            return redirect()->route('stock')->with('saveProduct', 'Stock approvisionne avec succes');
        }
    }

    public function stockEdit($id)
    {
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $category = Category::all();
        $ProduitStock = Product::with('Produitname', 'category')->where('id', $id)->first();
        $article = ProductArticle::all();
        $articleOne = ProductArticle::find($id);
        return view('stockEdit', compact(
            'article',
            'articleOne',
            'category',
            'ProduitStock',
            'countKurangura',
            'warnCount',
            'userRole'
        ));
    }

    public function stockUpdate(Request $request, $id)
    {
        $nameProduct = $request->article_id;
        $quantite = $request->quantite;
        $prixUnitaire = $request->prixUnitaire;
        $nameCategory = $request->category;

        $dataProduct = Product::find($id);
        $qttyStatus = $dataProduct->status;
        $dataProduct->product_Article_id = $nameProduct;
        $dataProduct->quantity = $quantite;
        $dataProduct->unitPrice = $prixUnitaire;
        $dataProduct->totalPrice = $quantite * $prixUnitaire;
        $dataProduct->category_id = $nameCategory;

        $dataProduct->save();

        if ($dataProduct->save()) {
            return redirect()->route('stock');
        }
    }

    public function runningLow()
    {
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $item = Product::with('Produitname', 'Category')->get();
        return view('runningLow', compact('item','warnCount','countKurangura','userRole'));
    }

    public function gufutaIbirangurwa()
    {
        Kurangura::truncate();
        return redirect()->back()->with('saveProductArticle', 'Mwafuse neza urupapuro rw' . 'ibirangurwa');
    }

    public function stockListSortir()
    {

        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Produitname', 'Category')->get();
        return view('sortirRecherche', compact('product', 'article', 'category','countKurangura','warnCount','userRole'));
    }




}
