<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//redirect to tasks.index
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

//dispaly all tasks
Route::get('/tasks', function ()  {
    return view('index', ['tasks' => Task::latest()->paginate()]);
})->name('tasks.index');

//create new task
Route::view(('tasks/create'), 'create')->name('tasks.create');


//display a single task
Route::get('/tasks/{task}', function (Task $task)  {
    return view('show', ['task' => $task]);
})->name('tasks.show');

//edit a task
Route::get('/tasks/{task}/edit', action: function (Task $task)  {
    return view('edit', ['task' => $task]);
})->name('tasks.edit');


//store a task
Route::post('/tasks', function (TaskRequest $request) {
    $task = Task::create($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task created successfully!');
})->name('tasks.store');


//update a task
Route::put('/tasks/{task}', function (TaskRequest $request, Task  $task) {
    $task->update($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task updated successfully!');
})->name('tasks.update');

//delete a task
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

// update task status
Route::put('/tasks/{task}/status', function (Task $task) {
    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task status updated successfully!');
})->name('tasks.status');

// Route::fallback(function(){
//     return View('index');
// });

