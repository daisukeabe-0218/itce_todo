<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ユーザーがページを表示するときは基本的にgetの方
Route::get('/', function () {
    return view('tasks', [
        'tasks' => App\Models\Task::latest()->get()
    ]);
});
Route::post('/task', function (Request $request) {
    request()->validate(
        [
            'name' => 'required|unique:tasks|min:3|max:255'
        ],
        [
            'name.required' => 'タスク内容を入力してください。',
            'name.unique' => 'そのタスクは既に追加されています。',
            'name.min' => '3文字以上で入力してください。',
            'name.max' => '255文字以内で入力してください。'
        ]
    );
    // インスタンス作成
    $task = new Task();

    //Inputタグのname属性がnameの場合 $requestでnameの値を受け取る
    //モデルインスタンスのname属性に代入
    $task->name = request('name');
    $task->deadline_at = request('deadline_at');
    $task->save();
    return redirect('/');
});
Route::delete('/task/{task}', function (Task $task) {
    $task->delete();
    return redirect('/');
});
