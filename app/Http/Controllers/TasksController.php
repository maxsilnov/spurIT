<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function __construct()
    {
//        $this->service = $service;
//        $this->middleware('can:manage-banners');
    }

    public function index()
    {
        $tasksTodo = $tasksDoing = $tasksDone = 0;

        $tasksTodo = $this->tasksTodo();
        $tasksDoing = $this->tasksDoing();
        $tasksDone = $this->tasksDone();

        return view('home',  compact('tasksTodo', 'tasksDoing' , 'tasksDone'));
    }

    public function tasksTodo()
    {
        return Task::where('status' , 'TODO')->with('comments')->orderBy('created_at')->get();
    }
    public function tasksDoing()
    {
        return Task::where('status' , 'DOING')->with('comments')->orderBy('created_at')->get();
    }
    public function tasksDone()
    {
        return Task::where('status' , 'DONE')->with('comments')->orderBy('created_at')->get();
    }

    public function show(Banner $banner)
    {
        return view('layouts.app', compact('banner'));
    }

    public function taskData(Request $request) // ajax
    {

        $input = $request->all();
        $id = $input['id'];
        $task = Task::find($id);
        $comments = Task::find($id)->comments;

        return response()->json(['task' => $task, 'comments' => $comments]);
    }

    public function edit(Request $request)
    {
        $input = $request->all();

        $id = $input['data']['id'];
        $name = $input['data']['name'];
        $description = $input['data']['description'];
        $status = $input['data']['status'];

        $task = Task::findOrFail($id);
        $task->name = $name;
        $task->description = $description;
        $task->status = $status;
        $task->save();

        return response()->json(['success' => true]);
    }
}
