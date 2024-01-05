<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\PerteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductArticleController;
use App\Http\Controllers\SortiController;
use App\Http\Controllers\TypeperteController;
use App\Models\Typeperte;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'index'])->name('loginCreate');

Route::post('login',[UserController::class,'login'])->name('login');
Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::middleware(['checkIfLoggedIn'])->group(function () {

Route::get('Dashboard',[UserController::class,'dashboard'])->name('dashboard');

Route::get('product_create',[ProductController::class,'productCreate'])->name('productCreate');
Route::post('product_store',[ProductArticleController::class,'productArticleStore'])->name('productStore');
Route::get('stock',[ProductController::class,'stockList'])->name('stock');
Route::get('produit_article',[ProductArticleController::class,'produit_article_create'])->name('produit_article');
Route::get('produit_update_create/{id}',[ProductArticleController::class,'produit_article_update_create'])->name('produit_update_create');
Route::post('produit_update/{id}',[ProductArticleController::class,'productArticleUpdate'])->name('produit_update');
Route::get('produit_article_list',[ProductArticleController::class,'produit_article_list'])->name('produit_list');


Route::post('stock_approvisonner',[ProductController::class,'productStore'])->name('approvisonner');
Route::get('histoEntrees',[ProductController::class,'histoEntrees'])->name('histoEntrees');
Route::get('list',[ProductController::class,'productListShow'])->name('productListShow');
Route::get('Kurangura',[ProductController::class,'kurangura'])->name('rangura');
Route::post('Kurangura_kubika',[ProductController::class,'kuranguraStore'])->name('ranguraStore');
Route::get('gufuta',[ProductController::class,'gufutaIbirangurwa'])->name('futa');
Route::get('guhindura_ikidandazwa/{id}',[ProductController::class,'guhinduraKimwe'])->name('guhinduraKimwe');
Route::post('guhindura/{id}',[ProductController::class,'guhinduraIbirangurwa'])->name('guhindura');
Route::get('gufutaKimwe/{id}',[ProductController::class,'gufutaKimwe'])->name('gufutaKimwe');

Route::get('category_create/',[CategoryController::class,'category_create'])->name('category_create');
Route::post('category_store/',[CategoryController::class,'category_store'])->name('category_store');
Route::get('category_update_create/{id}',[CategoryController::class,'category_update_create'])->name('category_update_create');
Route::post('category_update/{id}',[CategoryController::class,'category_update'])->name('category_update');
Route::get('category_delete/{id}',[CategoryController::class,'category_delete'])->name('category_delete');

Route::get('/kurangura_pdf',[UserController::class,'kurangura_pdf'])->name('kurangura_pdf');
Route::get('/Profile/{id}',[UserController::class,'Profile'])->name('Profile');
Route::get('/addUserCreate',[UserController::class,'addUserCreate'])->name('addUserCreate');
Route::post('/addUser',[UserController::class,'addUser'])->name('addUser');
Route::post('/editerUser/{id}',[UserController::class,'editerUser'])->name('editerUser');
Route::get('/editerUserAdmin/{id}',[UserController::class,'editerUserAdmin'])->name('editerUserAdmin');
Route::post('/editerUserAdminStore/{id}',[UserController::class,'editerUserAdminStore'])->name('editerUserAdminStore');
Route::post('/changePassword/{id}',[UserController::class,'changePassword'])->name('changePassword');

Route::get('sorti_create/',[SortiController::class,'productSortir'])->name('productSortir');
Route::post('sorti_store/',[SortiController::class,'productSortirStore'])->name('productSortirStore');
Route::get('sorti_list/',[SortiController::class,'sortiList'])->name('sortiList');
Route::get('bill/{id}',[SortiController::class,'bill'])->name('bill');


Route::get('stockEdit/{id}',[ProductController::class,'stockEdit'])->name('stockEdit');
Route::post('stockUpdate/{id}',[ProductController::class,'stockUpdate'])->name('stockUpdate');
Route::get('runningLowStock/',[ProductController::class,'runningLow'])->name('runningLow');


Route::get('SortieListRangeExport/',[SortiController::class,'SortieListRangeExport'])->name('SortieListRangeExport');
Route::get('SortieListSortedByDate/',[SortiController::class,'SortieListSortedByDate'])->name('SortieListSortedByDate');
Route::get('SortieListExport/',[SortiController::class,'SortieListExport'])->name('SortieListExport');
Route::get('stockListExport/',[SortiController::class,'stockListExport'])->name('stockListExport');
Route::get('entreeListExport/',[SortiController::class,'entreeListExport'])->name('entreeListExport');

Route::get('stockListSortir/',[ProductController::class,'stockListSortir'])->name('stockListSortir');
Route::post('productRechercheSortirStore/{id}',[SortiController::class,'productRechercheSortirStore'])->name('productRechercheSortirStore');
Route::get('stockListSortirVendreRedirectPage/{id}',[SortiController::class,'stockListSortirVendreRedirectPage'])->name('stockListSortirVendreRedirectPage');

Route::get('perte_create/',[PerteController::class,'perte_create'])->name('perte_create');
Route::post('perte_store/',[PerteController::class,'perte_store'])->name('perte_store');
Route::get('editPerte/{id}',[PerteController::class,'editPerte'])->name('editPerte');
Route::post('updatePerte/{id}',[PerteController::class,'updatePerte'])->name('updatePerte');

Route::get('type_perte_create/',[TypeperteController::class,'type_perte_create'])->name('type_perte_create');
Route::post('type_perte_store/',[TypeperteController::class,'type_perte_store'])->name('type_perte_store');

Route::get('depense_create/',[DepenseController::class,'depense_create'])->name('depense_create');
Route::post('depense_store/',[DepenseController::class,'depense_store'])->name('depense_store');
Route::get('depense_edit/{id}',[DepenseController::class,'depense_edit'])->name('depense_edit');
Route::post('depenseUpdate/{id}',[DepenseController::class,'depenseUpdate'])->name('depenseUpdate');
Route::get('DepenseListSortedByDate/',[DepenseController::class,'DepenseListSortedByDate'])->name('DepenseListSortedByDate');


Route::get('billtest/',[UserController::class,'billtest'])->name('billtest');
Route::get('error/',[UserController::class,'errorC'])->name('error');


});
