<?php
/**
 * Created by PhpStorm.
 * User: 孔乙己
 * Date: 2019/3/16
 * Time: 22:57
 */

namespace App\Http\Controllers;
use App\Model\Todo;
use Illuminate\Http\Request;
use App\Utils\Conts;

class todoController extends Controller{

    // 获取todo
    public function getTodoList(){
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $todoList = Todo::getTodoList($currentUserInfo["userId"],Conts::$todo);
        return response()->json([
            'code' => '0000',
            'msg' => '获取待办列表成功',
            'data' => $todoList
        ]);
    }

    // 获取done
    public function getDoneList(){
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $doneList = Todo::getTodoList($currentUserInfo["userId"],Conts::$done);
        return response()->json([
            'code' => '0000',
            'msg' => '获取已办列表成功',
            'data' => $doneList
        ]);
    }

    // 完成todo
    public function finishTodo(Request $request){
        $todoId = $request->get('todo_id');
        $result = Todo::updateTodoToDone($todoId);
        if($result){
            return response()->json([
                'code' => '0000',
                'msg' => '已完成该项~',
            ]);
        }
        return response()->json([
            'code' => '0001',
            'msg' => '该条目完成出错~'
        ]);
    }

    // 添加待办
    public function addTodo(Request $request){
        $todoTitle = $request->get('todo_title');
        $todoContent = $request->get('todo_content');
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $result = Todo::addTodo($todoTitle,$todoContent,$currentUserInfo["userId"]);
        return response()->json([
            'code' => '0000',
            'msg' => '添加代办成功',
            'data' => $result
        ]);
    }

    // 修改待办
    public function modifyTodo(Request $request){
        $todoId = $request->get('todo_id');
        $todoTitle = $request->get('todo_title');
        $todoContent = $request->get('todo_content');
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $result = Todo::modifyTodo($todoId,$todoTitle,$todoContent,$currentUserInfo["userId"]);
        if(!$result){
            return response()->json([
                'code' => '0001',
                'msg' => '修改代办失败'
            ]);
        }
        return response()->json([
            'code' => '0000',
            'msg' => '修改代办成功'
        ]);
    }

    //获取单条todo信息
    public function getOnlyTodoItem(Request $request){
        $todoId = $request->get('todo_id');
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $result = Todo::getOneTodoList($currentUserInfo["userId"],$todoId);
        if(!$result){
            return response()->json([
                'code' => '0001',
                'msg' => '获取失败'
            ]);
        }
        return response()->json([
            'code' => '0000',
            'msg' => '获取成功',
            'data' => $result
        ]);
    }

    // 删除item
    public function deleteTodoOrDone(Request $request){
        $todoId = $request->get('todo_id');
        $currentUserInfo = app('auth')->getPayload()->getClaims()->toPlainArray();
        $result = Todo::deleteItem($currentUserInfo["userId"],$todoId);
        if(!$result){
            return response()->json([
                'code' => '0001',
                'msg' => '删除失败'
            ]);
        }
        return response()->json([
            'code' => '0000',
            'msg' => '删除成功'
        ]);
    }
}
