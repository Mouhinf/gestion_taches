<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ActivityLogController;


/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');



/*
|--------------------------------------------------------------------------
| Dashboards
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function(){


    /*
    |--------------------------------------------------------------------------
    | Dashboard Administrateur
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:1'])->group(function(){

        Route::get('/admin/dashboard', 
            [AdminController::class, 'index']
        );


        /*
        |--------------------------------------------------------------------------
        | Gestion utilisateurs
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/users',
            [UserManagementController::class,'index']
        );

        Route::get('/admin/users/create',
            [UserManagementController::class,'create']
        );

        Route::post('/admin/users/store',
            [UserManagementController::class,'store']
        );

        Route::get('/admin/users/edit/{id}',
            [UserManagementController::class,'edit']
        );

        Route::post('/admin/users/update/{id}',
            [UserManagementController::class,'update']
        );

        Route::get('/admin/users/delete/{id}',
            [UserManagementController::class,'destroy']
        );



        /*
        |--------------------------------------------------------------------------
        | Gestion projets
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/projects',
            [ProjectController::class,'index']
        );

        Route::get('/admin/projects/create',
            [ProjectController::class,'create']
        );

        Route::post('/admin/projects/store',
            [ProjectController::class,'store']
        );

        Route::get('/admin/projects/edit/{id}',
            [ProjectController::class,'edit']
        );

        Route::post('/admin/projects/update/{id}',
            [ProjectController::class,'update']
        );

        Route::get('/admin/projects/delete/{id}',
            [ProjectController::class,'destroy']
        );



        /*
        |--------------------------------------------------------------------------
        | Gestion tâches administrateur
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/tasks',
            [TaskController::class,'index']
        );

        Route::get('/admin/tasks/create',
            [TaskController::class,'create']
        );

        Route::post('/admin/tasks/store',
            [TaskController::class,'store']
        );

        Route::get('/admin/tasks/edit/{id}',
            [TaskController::class,'edit']
        );

        Route::post('/admin/tasks/update/{id}',
            [TaskController::class,'update']
        );

        Route::get('/admin/tasks/delete/{id}',
            [TaskController::class,'destroy']
        );


        Route::get('/admin/tasks/export-pdf',
            [TaskController::class,'exportPdf']
        );

        Route::get('/admin/tasks/export-excel',
            [TaskController::class,'exportExcel']
        );


        Route::get('/admin/activity-logs',
            [ActivityLogController::class,'index']
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Dashboard Manager
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:2'])->group(function(){


        Route::get('/manager/dashboard',
            [ManagerController::class, 'index']
        );


        // Modification du statut des tâches

        Route::post('/manager/tasks/update-status/{id}',
            [TaskController::class, 'updateStatus']
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Kanban - Accessible par Admin (1) ET Manager (2)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:1,2'])->group(function(){

        Route::get('/admin/tasks/kanban',
            [TaskController::class, 'kanban']
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Dashboard Utilisateur
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:3'])->group(function(){


        Route::get('/user/dashboard',
            [UserController::class, 'index']
        );


    });


});