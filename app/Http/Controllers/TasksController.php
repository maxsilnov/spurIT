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
        return Task::where('status' , 'TODO')->orderBy('created_at')->get();
    }
    public function tasksDoing()
    {
        return Task::where('status' , 'DOING')->orderBy('created_at')->get();
    }
    public function tasksDone()
    {
        return Task::where('status' , 'DONE')->orderBy('created_at')->get();
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

    public function edit()
    {

//        return redirect()->route('admin.banners.show', $banner);
    }
}
