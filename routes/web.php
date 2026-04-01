<?php
use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add('GET', '/search', [Controller\Search::class, 'search'])
    ->middleware('auth');


Route::add('GET', '/dissertations', [Controller\DissertationsController::class, 'dissertations'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/addDissertation', [Controller\DissertationsController::class, 'addDissertation'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/updateDissertationStatus', [Controller\DissertationsController::class, 'updateDissertationStatus'])
    ->middleware('auth');


Route::add(['GET', 'POST'], '/scientificPublications', [Controller\ScientificPublicationsController::class, 'ScientificPublications'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/addScientificPublication', [Controller\ScientificPublicationsController::class, 'addScientificPublication'])
    ->middleware('auth');

Route::add('GET', '/', [Controller\Site::class, 'redirectToHello'])
    ->middleware('auth');
Route::add('GET', '/go', [Controller\Site::class, 'go']) ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/admin', [Controller\Site::class, 'adminPanel'])
    ->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/addScientificSupervisor', [Controller\AdminController::class, 'addScientificSupervisor'])
    ->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/addStudent', [Controller\AdminController::class, 'addStudent'])
    ->middleware('auth', 'admin');
