<?php
/**
 * Created by PhpStorm.
 * User: 孔乙己
 * Date: 2019/3/12
 * Time: 21:24
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class loginController extends Controller
{
    public function login(Request $request){
        $account = $request -> get('account');
        $password = $request -> get('password');
        $token = app('auth')->attempt(['account' => $account, 'password' => $password]);
        if($token){
            return response()->json([
                'code' => '0000',
                'msg' => '登录成功',
                'data' => [
                    'token' => $token
                ]
            ]);
        }else{
            return response()->json([
                'code' => '0001',
                'msg' => '登录失败，用户名或者密码错误，请重新尝试'
            ]);
        }
    }


    public function test(){
        $aa = "123456";
        return password_hash($aa,1);
    }
}