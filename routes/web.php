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

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/

$router->get('/test', ['uses' => 'loginController@test']);
//登录
$router->post('/login', ['uses' => 'loginController@login']);

$router->group(['middleware' => ['auth']],function () use ($router){
    //获取todo
    $router->get('/get-todo-list', 'TodoController@getTodoList');
    //获取done
    $router->get('/get-done-list', 'TodoController@getDoneList');
    //todo变成done
    $router->post('/finish-todo', 'TodoController@finishTodo');
    // 添加todo
    $router->post('/add-todo', 'TodoController@addTodo');
    // 获取单条todo
    $router->post('/get-one-todo-item', 'TodoController@getOnlyTodoItem');
    // 删除todo
    $router->post('/delete-item', 'TodoController@deleteTodoOrDone');
    // 修改待办
    $router->post('/modify-todo', 'TodoController@modifyTodo');

});
