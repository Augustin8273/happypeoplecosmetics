<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sorti;
use App\Models\Entrees;
use App\Models\Product;
use App\Models\Category;
use App\Models\Kurangura;
use App\Models\FamilyOffer;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SortiController extends Controller
{
    //

    public function productSortir()
    {

        $product = Product::with('Produitname', 'Category')->get();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        return view('sortis', compact('product', 'countKurangura', 'warnCount', 'userRole'));
    }


    public function productSortirStore(Request $request)
    {

        $nameProduct = $request->product_id;
        $quantite = $request->quantite;
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

        if ($quantite) {
            for ($i = 0; $i < count($nameProduct); $i++) {
                $Qt = Product::where('product_Article_id', $nameProduct[$i])->first();

                if ($Qt->quantity < $quantite[$i]) {
                    return back()->with('messageQuantite', 'Attention, Verifier dans le stock, la quantite que vous voulez livrer de l' . "'" . 'un des articles , depasse la quantite se trouvant dans le stock ! ');
                }
            }
        }
        $numberBillFetch = DB::table('sortis')->distinct()->count('numeroSorti');
        $numberBill = $numberBillFetch + 1;

        for ($i = 0; $i < count($nameProduct); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct[$i])->first();
            $dataSortie = new Sorti();
            $unPrice = $dataProduct->unitPrice;
            $dataSortie->date = Carbon::now()->toDateString();
            $dataSortie->numeroSorti = $numberBill;
            $dataSortie->quantity = $quantite[$i];
            $dataSortie->unitPrice = $dataProduct->unitPrice;
            $dataSortie->totalPrice = $quantite[$i] * $unPrice;
            $dataSortie->product_Article_id = $nameProduct[$i];
            $dataSortie->category_id = $dataProduct->category_id;
            $dataSortie->user_id = $userRole->id;
            $dataSortie->save();

            if ($dataSortie->save()) {
                $totalQuantity = $dataProduct->quantity;
                $dataProduct->quantity = $totalQuantity - $quantite[$i];
                $Qrestant = $totalQuantity - $quantite[$i];
                $dataProduct->totalPrice = $unPrice * $Qrestant;

                $dataProduct->save();
            }
        }


        if ($dataProduct->save()) {
            return redirect()->route('bill', $numberBill)->with('sortiProduct', 'Operation reussie !');
        }
    }

    public function sortiList()
    {

        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $article = ProductArticle::all();
        $product = Sorti::with('Produitname', 'Category', 'User')->get();
        $showButton = 'no';
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        return view('sortiList', compact('product', 'article', 'showButton', 'countKurangura', 'warnCount', 'userRole'));
    }

    public function offreList()
    {

        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $article = ProductArticle::all();
        $product = FamilyOffer::with('Produitname', 'Category', 'User')->get();
        $showButton = 'no';
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        return view('offreList', compact('product', 'article', 'showButton', 'countKurangura', 'warnCount', 'userRole'));
    }

    public function bill($id)
    {
        $bill = Sorti::where('numeroSorti', $id)->first();
        $billData = Sorti::with('Category', 'Produitname')->where('numeroSorti', '=', $id)->get();
        $userOperation = User::where('id', '=', $bill->user_id)->first();
        $current = Carbon::now()->toDateTimeString();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();


        return view('bill', compact(
            'bill',
            'billData',
            'current',
            'userRole',
            'userOperation',
            'countKurangura',
            'warnCount'
        ));
    }

    public function billOfferFmily($id)
    {
        $bill = FamilyOffer::where('numeroSorti', $id)->first();
        $billData = FamilyOffer::with('Category', 'Produitname')->where('numeroSorti', '=', $id)->get();
        $userOperation = User::where('id', '=', $bill->user_id)->first();
        $current = Carbon::now()->toDateTimeString();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();


        return view('billOfferFmily', compact(
            'bill',
            'billData',
            'current',
            'userRole',
            'userOperation',
            'countKurangura',
            'warnCount'
        ));
    }


    // PDF EXPORTATION


    public function SortieListSortedByDate(Request $request)
    {

        $fromDate = $request->fromDate;
        $endDate = $request->endDate;
        if ($fromDate && $endDate) {
            $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
            $product = Sorti::with('Category', 'Produitname', 'User')->whereBetween('date', [$fromDate, $endDate])->get();
            $showButton = 'yes';
            $countKurangura = Kurangura::all()->count();
            $warnCount = Product::all();

            return view('sortiList', compact('product', 'userRole', 'showButton', 'countKurangura', 'warnCount'));
        } else {
            $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

            $product = Sorti::with('Category', 'Produitname', 'User')->get();
            return redirect()->route('sortiList');
        }
    }

    // PDF EXPORTATION
    public function SortieListRangeExport(Request $request)
    {
        $fromDate = $request->fromDate;
        $endDate = $request->endDate;
        if ($fromDate && $endDate) {
            $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
            $product = Sorti::with('Category', 'Produitname', 'User')->whereBetween('date', [$fromDate, $endDate])->get();
            $current = Carbon::now()->toDateString();
            $pdf = PDF::loadView('PDF.historicSortieRange', ['product' => $product, 'current' => $current, 'userRole' => $userRole, 'fromDate' => $fromDate, 'endDate' => $endDate]);
            return $pdf->download('hpc-historique-sorties-du ' . $fromDate . '_au_' . $endDate . '.pdf');
        } else {

            return redirect()->route('sortiList');
        }
    }

    public function SortieListExport()
    {

        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Sorti::with('Category', 'Produitname', 'User')->get();
        $current = Carbon::now()->toDateString();
        $pdf = PDF::loadView('PDF.historicSortieAll', ['product' => $product, 'current' => $current, 'userRole' => $userRole]);
        return $pdf->download('hpc-historique-sorties-du-debut-a-la-fin.pdf');
    }

    public function stockListExport()
    {
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Category', 'Produitname')->get();
        $current = Carbon::now()->toDateString();
        $pdf = PDF::loadView('PDF.stock', ['product' => $product, 'current' => $current, 'userRole' => $userRole]);
        return $pdf->download('hpc-etat-du-stock-du-debut-au-' . $current . '.pdf');
    }
    public function entreeListExport()
    {
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Entrees::with('Category', 'Produitname')->get();
        $current = Carbon::now()->toDateString();
        $pdf = PDF::loadView('PDF.entree', ['product' => $product, 'current' => $current, 'userRole' => $userRole]);
        return $pdf->download('hpc-historique-des-entrees-du-debut-au-' . $current . '.pdf');
    }

    public function stockListSortirVendreRedirectPage($id)
    {

        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Produitname', 'Category')->where('product_Article_id', '=', $id)->first();
        return view('sortirRecherchePageRedirect', compact('product', 'article', 'category', 'countKurangura', 'warnCount', 'userRole'));
    }

    public function stockListSortirOfferRedirectPage($id)
    {

        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Product::with('Produitname', 'Category')->where('product_Article_id', '=', $id)->first();
        return view('sortirRechercheOfferPageRedirect', compact('product', 'article', 'category', 'countKurangura', 'warnCount', 'userRole'));
    }


    public function productRechercheSortirStore(Request $request, $id)
    {

        $nameProduct = $id;
        $quantite = $request->quantite;
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

        if ($quantite) {
            for ($i = 0; $i < count($quantite); $i++) {
                $Qt = Product::where('product_Article_id', $nameProduct)->first();

                if ($Qt->quantity < $quantite[$i]) {
                    return back()->with('messageQuantite', 'Attention, Verifier dans le stock, la quantite que vous voulez livrer de cet article  , depasse la quantite se trouvant dans le stock ! ');
                }
            }
        }
        $numberBillFetch = DB::table('sortis')->distinct()->count('numeroSorti');
        $numberBill = $numberBillFetch + 1;

        for ($i = 0; $i < count($quantite); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct)->first();
            $dataSortie = new Sorti();
            $unPrice = $dataProduct->unitPrice;
            $dataSortie->date = Carbon::now()->toDateString();
            $dataSortie->numeroSorti = $numberBill;
            $dataSortie->quantity = $quantite[$i];
            $dataSortie->unitPrice = $dataProduct->unitPrice;
            $dataSortie->totalPrice = $quantite[$i] * $unPrice;
            $dataSortie->product_Article_id = $nameProduct;
            $dataSortie->category_id = $dataProduct->category_id;
            $dataSortie->user_id = $userRole->id;
            $dataSortie->save();

            if ($dataSortie->save()) {
                $totalQuantity = $dataProduct->quantity;
                $dataProduct->quantity = $totalQuantity - $quantite[$i];
                $Qrestant = $totalQuantity - $quantite[$i];
                $dataProduct->totalPrice = $unPrice * $Qrestant;

                $dataProduct->save();
            }
        }


        if ($dataProduct->save()) {
            return redirect()->route('bill', $numberBill)->with('sortiProduct', 'Operation reussie !');
        }
    }

    public function productRechercheOfferSortirStore(Request $request, $id)
    {

        $nameProduct = $id;
        $quantite = $request->quantite;
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

        if ($quantite) {
            for ($i = 0; $i < count($quantite); $i++) {
                $Qt = Product::where('product_Article_id', $nameProduct)->first();

                if ($Qt->quantity < $quantite[$i]) {
                    return back()->with('messageQuantite', 'Attention, Verifier dans le stock, la quantite que vous voulez livrer de cet article  , depasse la quantite se trouvant dans le stock ! ');
                }
            }
        }
        $numberBillFetch = DB::table('family_offers')->distinct()->count('numeroSorti');
        $numberBill = $numberBillFetch + 1;

        for ($i = 0; $i < count($quantite); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct)->first();
            $dataSortie = new FamilyOffer();
            $unPrice = $dataProduct->unitPrice;
            $dataSortie->date = Carbon::now()->toDateString();
            $dataSortie->numeroSorti = $numberBill;
            $dataSortie->quantity = $quantite[$i];
            $dataSortie->unitPrice = $dataProduct->unitPrice;
            $dataSortie->totalPrice = $quantite[$i] * $unPrice;
            $dataSortie->product_Article_id = $nameProduct;
            $dataSortie->category_id = $dataProduct->category_id;
            $dataSortie->user_id = $userRole->id;
            $dataSortie->save();

            if ($dataSortie->save()) {
                $totalQuantity = $dataProduct->quantity;
                $dataProduct->quantity = $totalQuantity - $quantite[$i];
                $Qrestant = $totalQuantity - $quantite[$i];
                $dataProduct->totalPrice = $unPrice * $Qrestant;

                $dataProduct->save();
            }
        }


        if ($dataProduct->save()) {
            return redirect()->route('billOfferFmily', $numberBill)->with('sortiProduct', 'Operation reussie !');
        }
    }


    #CHANGING OR CANCEL SOLD PRODUCTS

    public function changeCancelRedirectPage(Request $request, $id)
    {

        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $product = Sorti::with('Produitname', 'Category')->where('id', '=', $id)->first();
        $request->session()->put('sortiProdChange_id', $id);
        $productStock = Product::with('Produitname', 'Category')->get();
        return view('changeCancelSelect', compact('product', 'productStock', 'article', 'category', 'countKurangura', 'warnCount', 'userRole'));
    }

    public function changeCancelRedirectPageSelect($id)
    {

        $sorti_Id = session()->get('sortiProdChange_id');
        $article = ProductArticle::all();
        $category = Category::all();
        $countKurangura = Kurangura::all()->count();
        $warnCount = Product::all();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $productSorti = Sorti::with('Produitname', 'Category')->where('id', '=', $sorti_Id)->first();
        $product = Product::with('Produitname', 'Category')->where('product_article_id', '=',$id )->first();
        return view('changeCancelSelectProduct', compact('product', 'productSorti', 'article', 'category', 'countKurangura', 'warnCount', 'userRole'));
    }

    public function changeDeleteSortiExchanged(Request $request, $id)
    {

        $sorti_Id = session()->get('sortiProdChange_id');

        $nameProduct = $id;
        $quantite = $request->quantite;
        $quantit = $request->quantit;
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

        if ($quantite) {
            for ($i = 0; $i < count($quantite); $i++) {
                $Qt = Product::where('product_Article_id', $nameProduct)->first();

                if ($Qt->quantity < $quantite[$i]) {
                    return back()->with('messageQuantite', 'Attention, Verifier dans le stock, la quantite que vous voulez livrer comme echange de cet article  , depasse la quantite se trouvant dans le stock ! ');
                }
            }
        }

        $productSorti = Sorti::with('Produitname', 'Category')->where('id', '=', $sorti_Id)->first();
        $proIdSor=$productSorti->produitname->id;

        $dataSortieCheck = Sorti::where('id', session()->get('sortiProdChange_id'))->first();
        $dataQuantityToChange = $dataSortieCheck->quantity;
        $dataQuantityToChangeunitPrice = $dataSortieCheck->unitPrice;
        $dataToIncrement = Product::with('Produitname', 'Category')->where('product_article_id', '=',$proIdSor )->first();

        if ($quantit > $dataQuantityToChange) {
            return back()->with('messageQuantite', 'Attention, la quantite que vous voulez changer, depasse la quantite que vous avez livre avant ! ');
        }
        if ($quantit == $dataQuantityToChange) {

            $qttStock = $dataToIncrement->quantity;
            $Uprice = $dataToIncrement->unitPrice;
            $TotalQuantityIncrease = $quantit + $qttStock;

            $dda= Product::where('product_article_id', $proIdSor)->first();
            $dda->quantity = $TotalQuantityIncrease;
            $dda->totalPrice = $TotalQuantityIncrease * $Uprice;
            // dd($TotalQuantityIncrease);
            $dda->save();
            if($dda->save()){
                $dataSortieCheck->quantity=0;;
                $dataSortieCheck->unitPrice=0;;
                $dataSortieCheck->totalPrice=0;;
                $dataSortieCheck->save();

        $numberBillFetch = DB::table('sortis')->distinct()->count('numeroSorti');
        $numberBill = $numberBillFetch + 1;

        for ($i = 0; $i < count($quantite); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct)->first();
            $dataSortie = new Sorti();
            $unPrice = $dataProduct->unitPrice;
            $dataSortie->date = Carbon::now()->toDateString();
            $dataSortie->numeroSorti = $numberBill;
            $dataSortie->quantity = $quantite[$i];
            $dataSortie->unitPrice = $dataProduct->unitPrice;
            $dataSortie->totalPrice = $quantite[$i] * $unPrice;
            $dataSortie->product_Article_id = $nameProduct;
            $dataSortie->category_id = $dataProduct->category_id;
            $dataSortie->user_id = $userRole->id;
            $dataSortie->save();

            if ($dataSortie->save()) {
                $totalQuantity = $dataProduct->quantity;
                $dataProduct->quantity = $totalQuantity - $quantite[$i];
                $Qrestant = $totalQuantity - $quantite[$i];
                $dataProduct->totalPrice = $unPrice * $Qrestant;

                $dataProduct->save();
            }
        }


        if ($dataProduct->save()) {
            return redirect()->route('bill', $numberBill)->with('sortiProduct', 'Operation reussie !');
        }

            }

        }
        if ($quantit < $dataQuantityToChange) {

            $qttStock = $dataToIncrement->quantity;
            $Uprice = $dataToIncrement->unitPrice;
            $TotalQuantityIncrease = $quantit + $qttStock;

            $dda= Product::where('product_article_id', $proIdSor)->first();
            $dda->quantity = $TotalQuantityIncrease;
            $dda->totalPrice = $TotalQuantityIncrease * $Uprice;

            $dda->save();
            if($dda->save()){
                $dataSortieCheck->quantity=$dataQuantityToChange-$quantit;
                $qtt=$dataQuantityToChange-$quantit;
                $Pttl=$qtt*$dataQuantityToChangeunitPrice;;
                $dataSortieCheck->unitPrice=$dataQuantityToChangeunitPrice;
                $dataSortieCheck->totalPrice=$Pttl;
                $dataSortieCheck->save();

        $numberBillFetch = DB::table('sortis')->distinct()->count('numeroSorti');
        $numberBill = $numberBillFetch + 1;

        for ($i = 0; $i < count($quantite); $i++) {
            $dataProduct = Product::where('product_article_id', $nameProduct)->first();
            $dataSortie = new Sorti();
            $unPrice = $dataProduct->unitPrice;
            $dataSortie->date = Carbon::now()->toDateString();
            $dataSortie->numeroSorti = $numberBill;
            $dataSortie->quantity = $quantite[$i];
            $dataSortie->unitPrice = $dataProduct->unitPrice;
            $dataSortie->totalPrice = $quantite[$i] * $unPrice;
            $dataSortie->product_Article_id = $nameProduct;
            $dataSortie->category_id = $dataProduct->category_id;
            $dataSortie->user_id = $userRole->id;
            $dataSortie->save();

            if ($dataSortie->save()) {
                $totalQuantity = $dataProduct->quantity;
                $dataProduct->quantity = $totalQuantity - $quantite[$i];
                $Qrestant = $totalQuantity - $quantite[$i];
                $dataProduct->totalPrice = $unPrice * $Qrestant;

                $dataProduct->save();
            }
        }


        if ($dataProduct->save()) {
            return redirect()->route('bill', $numberBill)->with('sortiProduct', 'Operation reussie !');
        }

            }

        }
    }

    public function returnStock($id){
        $sorti_Id = session()->get('sortiProdChange_id');


        $productSorti = Sorti::with('Produitname', 'Category')->where('id', '=', $sorti_Id)->first();
        $proIdSor=$productSorti->produitname->id;
        $quantit=$productSorti->quantity;

        $dataSortieCheck = Sorti::where('id', session()->get('sortiProdChange_id'))->first();
        $dataQuantityToChange = $dataSortieCheck->quantity;
        $dataQuantityToChangeunitPrice = $dataSortieCheck->unitPrice;
        // $dataToIncrement = Product::where('product_article_id', $nameProduct)->first();
        $dataToIncrement = Product::with('Produitname', 'Category')->where('product_article_id', '=',$proIdSor )->first();

            $qttStock = $dataToIncrement->quantity;
            $Uprice = $dataToIncrement->unitPrice;
            $TotalQuantityIncrease = $quantit + $qttStock;

            $dda= Product::where('product_article_id', $proIdSor)->first();
            $dda->quantity = $TotalQuantityIncrease;
            $dda->totalPrice = $TotalQuantityIncrease * $Uprice;
            // dd($TotalQuantityIncrease);
            $dda->save();
            if($dda->save()){
                $dataSortieCheck->quantity=0;;
                $dataSortieCheck->unitPrice=0;;
                $dataSortieCheck->totalPrice=0;;
                $dataSortieCheck->save();


        if ($dataSortieCheck->save()) {
            return redirect()->route('stock')->with('sortiReturnProduct', 'Produit retourne en stock avec success !');
        }

            }

    }
    public function returnStockOffreFamille($id){


        $productSorti = FamilyOffer::with('Produitname', 'Category')->where('id', '=', $id)->first();
        $proIdSor=$productSorti->produitname->id;
        $quantit=$productSorti->quantity;

        $dataToIncrement = Product::with('Produitname', 'Category')->where('product_article_id', '=',$proIdSor )->first();

            $qttStock = $dataToIncrement->quantity;
            $Uprice = $dataToIncrement->unitPrice;
            $TotalQuantityIncrease = $quantit + $qttStock;

            $dda= Product::where('product_article_id', $proIdSor)->first();
            $dda->quantity = $TotalQuantityIncrease;
            $dda->totalPrice = $TotalQuantityIncrease * $Uprice;
            $dda->save();
            if($dda->save()){
                $dataoffer = FamilyOffer::where('id', '=',$id)->first();
                $dataofferDelete=$dataoffer->delete();

        if ($dataofferDelete) {
            return redirect()->route('stock')->with('sortiReturnProduct', 'Produit retourne en stock avec success !');
        }

            }

    }

    public function kill_sorti_session()
    {
        if (session()->has('sortiProdChange_id')) {
            Session()->pull('sortiProdChange_id');
            return redirect()->route('sortiList');
        }
    }
}
