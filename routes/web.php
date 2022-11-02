<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
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

Route::get('products', function () {
    $products = Product::orderBy('created_at','desc')->get();
    return view('products.index',compact('products'));
})->name('products.index');

Route::get('products/create', function(){
    return view('products.create');
})->name('products.create');

Route::post('products', function(Request $request){
    $newProduct = new Product;
    $newProduct->descripcion = $request->input('descripcion');
    $newProduct->price = $request->input('price');
    $newProduct->save();

    return redirect()->route('products.index')->with('info','Producto creado exitosamente!!');
})->name('products.store');

Route::delete('products/delete/{id}',function($id){
    $productSelected = Product::findOrFail($id);
    $productSelected->delete();
    return redirect()->route('products.index')->with('info','Producto eliminado exitosamente!!');
})->name('products.delete');

Route::get('products/edit/{id}', function($id){
    $product = Product::findOrFail($id);
    return view('products.edit',compact('product'));
})->name('products.edit');

Route::put('products/update/{id}', function(Request $request, $id){
    $productSelected = Product::findOrFail($id);
    $productSelected->descripcion  = $request->input('descripcion');
    $productSelected->price = $request->input('price');
    $productSelected->save();
    return redirect()->route('products.index')->with('info','Producto actualizado exitosamente!!');
})->name('products.update');

