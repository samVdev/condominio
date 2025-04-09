<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StaticsController;
use App\Http\Controllers\FacturesController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReceiptsController;



Route::get('/counted', [StaticsController::class, 'index']);


Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    //Route::prefix('users')->middleware(['role:admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/auth', AuthController::class);
        Route::get('/auth-menu', AuthMenuController::class);
        Route::get('/{uuid}', [UserController::class, 'show']);        
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/{uuid}', [UserController::class, 'update']);
        Route::delete('/{uuid}', [UserController::class,'destroy']);
        Route::post('/auth/avatar', [AvatarController::class, 'store']);
    });
       
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::get('/children/{menuId}', [MenuController::class, 'children']);
        Route::post('/', [MenuController::class, 'store']);  
        Route::put('/{menu}', [MenuController::class, 'update']);
        //Route::delete('/{id}', [MenuController::class,'destroy']);
    });

    Route::prefix('roles')->group(function () {
        Route::get('/helperTables', fn() => response()->json([
            "roles" => \App\Models\Role::select('id', 'name')->get()
        ], 200));
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::get('/', [RoleController::class, 'index']);       
        Route::post('/', [RoleController::class, 'store']);        
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class,'destroy']);        
    });   

    Route::prefix('statics')->group(function () {
        Route::get('/admin/counted', [StaticsController::class, 'index']);
    });   
    
    Route::prefix('services')->group(function () {
        Route::get('/', [ServicesController::class, 'index']);
        Route::get('/minium', [ServicesController::class, 'getMinium']);
        Route::get('/show/{id}', [ServicesController::class, 'show']);
        Route::post('/', [ServicesController::class, 'store']);
        Route::put('/{id}', [ServicesController::class, 'edit']);
        Route::delete('/{id}', [ServicesController::class, 'destroy']);
    });  


    Route::prefix('expenses')->group(function () {
        Route::get('/', [ExpensesController::class, 'index']);
        Route::get('/show/{id}', [ExpensesController::class, 'show']);
        Route::post('/', [ExpensesController::class, 'store']);
        Route::post('/{id}', [ExpensesController::class, 'edit']);
        Route::delete('/{id}', [ExpensesController::class, 'destroy']);
    }); 
    
    Route::prefix('factures')->group(function () {
        Route::get('/', [FacturesController::class, 'index']);
        Route::post('/', [FacturesController::class, 'store']);
        Route::delete('/{id}', [FacturesController::class, 'destroy']);
    }); 

    Route::prefix('receipts')->group(function () {
        Route::get('/users/pending', [ReceiptsController::class, 'receiptsUsers']);
    }); 

    Route::prefix('apt')->group(function () {
        Route::get('/', [CondominiumController::class, 'index']);
        Route::get('/towers', [CondominiumController::class, 'towers']);
        Route::get('/show/{id}', [CondominiumController::class, 'show']);
        Route::post('/', [CondominiumController::class, 'store']);
        Route::put('/{id}', [CondominiumController::class, 'edit']);
        Route::delete('/{id}', [CondominiumController::class, 'destroy']);
    }); 
    
    Route::prefix('guest')->group(function () {
        Route::get('factures/user/pending', [GuestController::class, 'FactureUserPending']);
        Route::get('factures/user/completed', [GuestController::class, 'FactureUserCompleted']);
        Route::get('expenses/facture', [GuestController::class, 'ExpensesFacture']);
        Route::get('count', [GuestController::class, 'DashboardCount']);
        Route::post('pay/facture/{id}', [ReceiptsController::class, 'storeReceipt']);
    }); 
    
});

Route::prefix('error')->group(function () {
    Route::get('/not-auth', function(){        
        abort(403, 'This action is not authorized.');        
    });

    Route::get('/not-found', function(){        
        abort(404, 'Page not found.');        
    });

    Route::get('/', function(){        
        abort(500, 'Something went wrong');        
    });
    Route::get('/custom', function(){
        throw new \App\Exceptions\CustomException('Error: Levi Strauss & CO.', 501);
    });
});
