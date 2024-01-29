<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>'auth'],function(){
    Route::get('category',function(){
        return view('category');
    }); 
    Route::post('add-category',[App\Http\Controllers\CategoryController::class,'addCategory'])->name('add-category');
    Route::get('manageCategory',[App\Http\Controllers\CategoryController::class,'listCategory']);
    Route::get('editCat/{id}',[App\Http\Controllers\CategoryController::class,'editCategory']);
    Route::get('editCategory',[App\Http\Controllers\CategoryController::class,'editCategory']);
    Route::post('update-category',[App\Http\Controllers\CategoryController::class,'updateCategory']);

    Route::get('deleteCat/{id}',[App\Http\Controllers\CategoryController::class,'deleteCategory']);


    Route::get('product',[App\Http\Controllers\CategoryController::class,'fetchCategory'])->name('get-cat');
    Route::get('manageProducts',[App\Http\Controllers\productController::class,'listProduct']);
    Route::post('add-product',[App\Http\Controllers\productController::class,'addProduct'])->name('add-product');
    Route::get('editProduct/{id}',[App\Http\Controllers\productController::class,'editProduct']);
    Route::post('update-product',[App\Http\Controllers\productController::class,'updateProduct']);
    Route::get('deleteProduct/{id}',[App\Http\Controllers\productController::class,'deleteProduct']);

});


Route::get('/', [App\Http\Controllers\productController::class,'displayProduct']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::get('category',function(){
//     return view('category');
// });









// Route::get('manageProducts',function(){
//     return view('manageProducts');
// });