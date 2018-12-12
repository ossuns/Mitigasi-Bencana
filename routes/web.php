<?php

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

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

$router->group(
    ['prefix'=>'api'], function() use ($router) {
        //say hello
        $router->get('', function() {
            return 'you got response!';
        });

        //create
        $router->post('', ['uses'=>'CollecterController@add']);
        //read
        $router->get('{tag}', ['uses'=>'CollecterController@show']);
        //delete
        $router->delete('{tag}', ['uses'=>'CollecterController@delete']);
        $router->delete('', ['uses'=>'CollecterController@deleteAll']);
        //backup
        $router->get('action/backup', ['uses'=>'CollecterController@backup']);
    }
);
