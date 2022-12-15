<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function addTodo(Request $request){
        $newTodo = Todos::insert([
            'userId' => $request->userId,
            'todo' => $request->text,
            'date' => $request->date,
            'completed' => false,
        ]);

        $todos = Todos::where('userId', $request->userId)->get();
        if ($newTodo) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Todo added',
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function getTodos($id){
        $todos = Todos::where('userId', $id)->get();
        if ($todos) {
            return response()->json([
                'status' => 'ok',
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function clearCompleted($id){
        $clearedTodos = Todos::where('userId', $id)->where('completed', true)->delete();
        $todos = Todos::where('userId', $id)->get();

        if ($clearedTodos) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Completed todos cleared',
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function changeTodoStatus(Request $request){
        $updatedTodo = Todos::where('id', $request->id)->update(['completed' => $request->value]);

        $todos = Todos::where('userId', $request->userId)->get();

        if ($updatedTodo) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Todo status changed',
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function deleteTodo(Request $request){
        $deletedTodo = Todos::where('id', $request->id)->delete();

        $todos = Todos::where('userId', $request->userId)->get();

        if ($deletedTodo) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Todo deleted',
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
