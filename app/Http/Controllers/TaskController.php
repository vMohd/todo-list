<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()

{
    $userEmail = auth()->user()->email;
    $tasks = Task::where('user_email', $userEmail)->get();

    return view('tasks.index', compact('tasks'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'priority' => 'required|in:high,medium,low', 
    ], [
        'title.required' => 'The Task Is Required.',
        'title.max' => 'The Task Should Not Exceed 255 Characters.',
        'priority.required' => 'The Task Priority Is Required.',
        'priority.in' => 'Invalid Task Priority.',
    ]);

    $task = new Task();
    $task->title = $validatedData['title'];
    $task->priority = $validatedData['priority']; 
    $task->status = 'In progress';
    $task->date = now()->format('Y-m-d H:i:s');
    $task->user_id = auth()->user()->id;
    $task->user_email = auth()->user()->email;
    $task->save();

    return redirect()->route('tasks.index')->with('success', 'Task Added Successfully!');
}
    

public function update(Request $request, Task $task)
{
    if ($task->user_email !== auth()->user()->email) {
        abort(403, 'Unauthorized action.');
    }

    if ($request->has('completed')) {
        $task->status = 'Completed';
    } elseif ($request->has('in_progress')) {
        $task->status = 'In progress';
    }

    $task->save();

    return redirect()->route('tasks.index')->with('success', 'Task Status Updated Successfully!');
}
    

    public function destroy(Task $task)
    {
        if ($task->user_email !== auth()->user()->email) {
            abort(403, 'Unauthorized action.');
        }
    
        $task->delete();
        
        return redirect()->back()->with('success', 'Task Deleted Successfully!');
    }

};