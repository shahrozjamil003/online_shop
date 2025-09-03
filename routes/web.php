<?php

use App\Http\Controllers\Admin\AdminloginController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\TemImagesConteroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminloginController::class, 'index'])->name('admin.login');

Route::group(['prifix' => 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('/login', [AdminloginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminloginController::class, 'authenticate'])->name('admin.authenticate');

    });

    Route::group(['middleware' => 'admin.auth'], function(){
        
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //Categories Route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

        //tem-images route
        Route::post('/upload-tem-images', [TemImagesConteroller::class, 'create'])->name('tem-images.create');

        // sub category routes
        Route::get('/sub-categories', [SubcategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create', [SubcategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-categories', [SubcategoryController::class, 'store'])->name('sub-categories.store');
        Route::get('/sub-categories/{id}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{id}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/categories/{id}', [SubCategoryController::class, 'destroy'])->name('sub-categories.delete');


        //Brands routes
        Route::get('/brand/index', [BrandsController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandsController::class, 'create'])->name('brand.create');
        Route::post('/brand', [BrandsController::class, 'store'])->name('brand.store');
        Route::get('/brand/edit/{id}', [BrandsController::class, 'edit'])->name('brand.edit');
        Route::put('/brand/{id}', [BrandsController::class, 'update'])->name('brand.update');
        Route::delete('/brand/{id}', [BrandsController::class, 'destroy'])->name('brand.delete');


        //Products Routes
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');

        Route::get('/product/subcategories', [ProductController::class, 'getsubcategory'])->name('getsubcategory');


        //creating a slug
        Route::get('/gettitle', function(Request $request){

            
            
            $slug = '';
            if(!empty($request->title)){
                $slug = str::slug($request->title);
            
            }

            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        })->name('getslug');
    });
});