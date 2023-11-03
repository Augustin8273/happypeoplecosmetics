<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductArticleController;

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
Route::get('dashboard',[UserController::class,'dashboard'])->name('dashboard');
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

Route::get('/kurangura_pdf',[UserController::class,'kurangura_pdf'])->name('kurangura_pdf');
});
