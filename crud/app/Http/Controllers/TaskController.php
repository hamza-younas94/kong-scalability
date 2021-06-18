<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Namshi\JOSE\SimpleJWS;
use Firebase\JWT\JWT;
use Laravel\Passport\Token;

class TaskController extends Controller
{
    public function index()
    {

        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $tasks = Task::where('user_id', $apy['id'])->orderBy("id", "DESC")->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {

        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();

        $task = new Task();
        $task->title = request('title');
        $task->description = request('description');
        $task->is_completed = 0;
        $task->user_id = $apy['id'];
        $task->save();
        return response()->json($task);
    }

    public function complete($id)
    {
        $task = Task::find($id);
        $task->iscompleted = 1;
        $task->save();
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task Deleted']);
    }
}
