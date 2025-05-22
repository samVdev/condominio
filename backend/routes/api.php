<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\ElevatorsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StaticsController;
use App\Http\Controllers\FacturesController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProvisionsController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\TypeEarningController;

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/auth', AuthController::class);
        Route::get('/show', [AuthController::class, 'show']);
        Route::put('/update/{id}', [AuthController::class, 'edit']);
        Route::get('/auth-menu', AuthMenuController::class);
    });

    // only Admin or superAdmin
    Route::middleware(['admin'])->group(function () {

        Route::get('/counted', [StaticsController::class, 'index']);

        Route::prefix('users')->group(function () {
            Route::get('/{uuid}', [UserController::class, 'show']);
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::post('/{uuid}', [UserController::class, 'update']);
            Route::delete('/{uuid}', [UserController::class, 'destroy']);
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
            Route::delete('/{id}', [RoleController::class, 'destroy']);
        });

        Route::prefix('statics')->group(function () {
            Route::get('/admin/counted', [StaticsController::class, 'index']);
            Route::get('/admin/fundreserve', [StaticsController::class, 'fundReserve']);
        });

        Route::prefix('services')->group(function () {
            Route::get('/', [ServicesController::class, 'index']);
            Route::get('/minium', [ServicesController::class, 'getMinium']);
            Route::get('/show/{id}', [ServicesController::class, 'show']);
            Route::post('/', [ServicesController::class, 'store']);
            Route::put('/{id}', [ServicesController::class, 'edit']);
            Route::delete('/{id}', [ServicesController::class, 'destroy']);
        });


        Route::prefix('types')->group(function () {
            Route::get('/', [TypeEarningController::class, 'index']);
            Route::get('/minium', [TypeEarningController::class, 'getMinium']);
            Route::get('/show/{id}', [TypeEarningController::class, 'show']);
            Route::post('/', [TypeEarningController::class, 'store']);
            Route::put('/{id}', [TypeEarningController::class, 'edit']);
            Route::delete('/{id}', [TypeEarningController::class, 'destroy']);
        });

        Route::prefix('earnings')->group(function () {
            Route::get('/', [EarningsController::class, 'index']);
            Route::get('/show/{id}', [EarningsController::class, 'show']);
            Route::post('/', [EarningsController::class, 'store']);
            Route::put('/{id}', [EarningsController::class, 'edit']);
            Route::delete('/{id}', [EarningsController::class, 'destroy']);
        });

        Route::prefix('expenses')->group(function () {
            Route::get('/', [ExpensesController::class, 'index']);
            Route::get('/show/{id}', [ExpensesController::class, 'show']);
            Route::post('/', [ExpensesController::class, 'store']);
            Route::put('/{id}', [ExpensesController::class, 'edit']);
            Route::delete('/{id}', [ExpensesController::class, 'destroy']);
        });

        Route::prefix('provisions')->group(function () {
            Route::get('/', [ProvisionsController::class, 'index']);
            Route::get('/details', [ProvisionsController::class, 'showProvisionsDetails']);
            Route::get('/allprov', [ProvisionsController::class, 'showFund']);
            Route::get('/show/{id}', [ProvisionsController::class, 'show']);
            Route::get('/check/{service_id}/{expense_id}', [ProvisionsController::class, 'check']);
            Route::post('/', [ProvisionsController::class, 'store']);
            Route::put('/{id}', [ProvisionsController::class, 'edit']);
            Route::delete('/{id}', [ProvisionsController::class, 'destroy']);
        });

        Route::prefix('factures')->group(function () {
            Route::get('/', [FacturesController::class, 'index']);
            Route::post('/', [FacturesController::class, 'store']);
            Route::delete('/{id}', [FacturesController::class, 'destroy']);
        });

        Route::prefix('receipts')->group(function () {
            Route::get('/', [ReceiptsController::class, 'index']);
            Route::post('/', [ReceiptsController::class, 'actions']);
            Route::get('/users/pending', [ReceiptsController::class, 'receiptsUsers']);
        });

        Route::prefix('apt')->group(function () {
            Route::get('/', [CondominiumController::class, 'index']);
            Route::get('/resume', [CondominiumController::class, 'resume']);
            Route::get('/towers', [CondominiumController::class, 'towers']);
            Route::get('/apts/{id?}', [CondominiumController::class, 'apts']);
            Route::get('/show/{id}', [CondominiumController::class, 'show']);
            Route::post('/', [CondominiumController::class, 'store']);
            Route::put('/{id}', [CondominiumController::class, 'edit']);
            Route::delete('/{id}', [CondominiumController::class, 'destroy']);
        });

        Route::prefix('elevators')->group(function () {
            Route::get('/min', [ElevatorsController::class, 'getMin']);
            Route::get('/resume', [ElevatorsController::class, 'resume']);
            Route::get('/show/{id}', [ElevatorsController::class, 'show']);
            Route::post('/', [ElevatorsController::class, 'store']);
            Route::put('/{id}', [ElevatorsController::class, 'edit']);
            Route::put('/report/{id}', [ElevatorsController::class, 'reportService']);
            Route::delete('/{id}', [ElevatorsController::class, 'destroy']);
        });


        Route::prefix('config')->group(function () {
            Route::get('/', [ConfigController::class, 'index']);
            Route::put('/', [ConfigController::class, 'edit']);
            Route::get('/dolar', [ConfigController::class, 'getDolar']);
            Route::post('/update-dollar', [ConfigController::class, 'updateDollar']);
        });

        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('/{id}', [PostController::class, 'show']);
            Route::post('/', [PostController::class, 'store']);
            Route::post('/email/{id}', [PostController::class, 'email']);
            Route::put('/{id}', [PostController::class, 'edit']);
            Route::delete('/{id}', [PostController::class, 'destroy']);
        });
    });

    Route::prefix('elevators')->group(function () {
        Route::get('/', [ElevatorsController::class, 'index']);
        Route::get('/history', [ElevatorsController::class, 'historyService']);
    });

    Route::prefix('guest')->group(function () {
        Route::get('account', [GuestController::class, 'Account']);
        Route::get('factures/user/pending', [GuestController::class, 'FactureUserPending']);
        Route::get('factures/user/completed', [GuestController::class, 'FactureUserCompleted']);
        Route::get('expenses/facture', [GuestController::class, 'ExpensesFacture']);
        Route::get('earnings/facture', [GuestController::class, 'EarningsFacture']);
        Route::get('provisions/facture', [GuestController::class, 'ProvisionsFacture']);
        Route::get('count', [GuestController::class, 'DashboardCount']);
        Route::post('pay/facture/{id}', [ReceiptsController::class, 'storeReceipt']);
    });
});

Route::prefix('error')->group(function () {
    Route::get('/not-auth', function () {
        abort(403, 'This action is not authorized.');
    });

    Route::get('/not-found', function () {
        abort(404, 'Page not found.');
    });

    Route::get('/', function () {
        abort(500, 'Something went wrong');
    });
    Route::get('/custom', function () {
        throw new \App\Exceptions\CustomException('Error: Levi Strauss & CO.', 501);
    });
});
