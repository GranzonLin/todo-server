<?php
/**
 * Created by PhpStorm.
 * User: 孔乙己
 * Date: 2019/3/16
 * Time: 23:24
 */

namespace App\Model;

use App\Utils\Conts;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model {
    protected $table = 'todo_tb';
    protected $primaryKey = 'todo_id';
    public $timestamps=false;

    // 获取todo 或者 done列表
    public static function getTodoList($userId,$todoStatus){
        try {
            $todoList = Todo::query()->where(['user_id'=>$userId,'todo_status'=>$todoStatus])->get()->toArray();
            return $todoList;
        }catch (\Exception $e){
            return false;
        }
    }

    // 获取单条todo列表
    public static function getOneTodoList($userId,$todoId){
        try {
            $todoList = Todo::query()->where(['user_id'=>$userId,'todo_id'=>$todoId])->first();
            return $todoList;
        }catch (\Exception $e){
            return false;
        }
    }

    // todo变成done
    public static function updateTodoToDone($todoId){
        try {
            $result = Todo::query()->where(['todo_id'=>$todoId])->update(['todo_status'=>1,'todo_finish_time'=>time()]);
            return $result;
        }catch (\Exception $e){
            return false;
        }
    }

    // 添加todo
    public static function addTodo($todoTitle,$todoContent,$userId){
        try {
            $result = Todo::query()->insert(
                [
                    'todo_title'=>$todoTitle,
                    'todo_content'=>$todoContent,
                    'todo_create_time'=>time(),
                    'todo_update_time'=>time(),
                    'todo_status'=>Conts::$todo,
                    'user_id'=>$userId,
                ]
            );
            return $result;
        }catch (\Exception $e){
            return false;
        }
    }

    // 修改todo
    public static function modifyTodo($todoId,$todoTitle,$todoContent,$userId){
        try {
            $result = Todo::query()->where(['todo_id'=>$todoId,'user_id'=>$userId])->update(["todo_title"=>$todoTitle,"todo_content"=>$todoContent]);
            return $result;
        }catch (\Exception $e){
            return false;
        }
    }
    // 删除item
    public static function deleteItem($userId,$todoId){
        try {
            $result = Todo::query()->where(['todo_id'=>$todoId,'user_id'=>$userId])->delete();
            return $result;
        }catch (\Exception $e){
            return false;
        }
    }
}
