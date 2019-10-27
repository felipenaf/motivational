<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Quote;

// $router->get('/', function () use ($router) {
// 	return $router->app->version();
// });

/**
 * Display the today quote
 */
$router->get('/', function() use ($router) {

    /*
     * Picks a different quote every day
     * (for a maximum of 366 quotes)
     *
     *   - $count: the total number of available quotes
     *   - $day: the current day of the year (from 0 to 365)
     *   - $page: the page to look for to retrieve the
     *            correct record
     */
    $count = Quote::query()->get()->count();
    $day = (int) date('z');
    $page = $day % $count + 1;

    $quotes = Quote::query()->get()->forPage($page, 1)->first();

    if (empty($quotes)) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

    return view('quote', ['quote' => $quotes]);
});

/**
 * Display a specific quote
 */
$router->get('/{id}', function($id) use ($router) {
    $quote = Quote::query()->findOrFail($id);
    return view('quote', ['quote' => $quote]);
});

/**
 * Testes
*/

// $router->get('/', function () use ($router) {
// 	return $router->app->version();
// });

// $router->get('user/', function (){
// 	$users = DB::select("SELECT * FROM quotes");
// 	return $users;
// });

// $router->get('user/{id}', function ($id){
// 	$user = DB::select("SELECT * FROM quotes WHERE id = $id");
// 	return $user;
// });
