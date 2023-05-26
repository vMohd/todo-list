@extends('layouts.app')
@section('title', 'Todo List')


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('success'))
<div id="success-message" class="alert alert-success">
    <p>{{ session('success') }}</p>
</div>
@endif    

@section('content')
    <div class="container">
        <h3>Welcome, {{ Auth::user()->name }}! to Your Todo List</h3>
        <h5>Manage your tasks and stay organized!</h5>
        <br>
        @auth
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="row row-cols-lg-auto g-3 align-items-center mb-4 pb-2">
                <div class="col-12" >
                    <p class="h5 mb-3" for="title">Add new task:</p>
                    <div class="form-outline input-group-lg mb-3">
                        <input type="text" class="form-control" placeholder="Write your task here" name="title" id="title" maxlength="255" style="width: 600px" required> 
                    </div>            
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-lg btn-primary">Add</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label h5">Priority:</label>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priority" id="priority-high" value="high" checked>
                            <label class="form-check-label" for="priority-high">
                                High Priority
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priority" id="priority-medium" value="medium">
                            <label class="form-check-label" for="priority-medium">
                                Medium Priority
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priority" id="priority-low" value="low">
                            <label class="form-check-label" for="priority-low">
                                Low Priority
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endauth
        
        
  
      @if(!is_null($tasks))
      <table class="table">
        <thead>
            <tr>
                <th>Task</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                @if($task->user_email == auth()->user()->email)
                    <tr>
                        <td style="width: 50%; word-wrap: break-word;">
                            @if ($task->status === 'Completed')
                                <s>{{ $task->title }}</s>
                            @else
                                {{ $task->title }}
                            @endif
                        </td>
                        <td>
                            @if ($task->priority === 'high')
                                <span class="badge bg-danger">High Priority</span>
                            @elseif ($task->priority === 'medium')
                                <span class="badge bg-warning">Medium Priority</span>
                            @else
                                <span class="badge bg-success">Low Priority</span>
                            @endif
                        </td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->created_at->toFormattedDateString() }}</td>
                        <td>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-2">Delete</button>
                            </form>
                            @if ($task->status === 'Completed')
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="in_progress" value="0">
                                    <button type="submit" class="btn btn-warning">Unmark as completed</button>
                                </form>
                            @else
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="completed" value="1">
                                    <button type="submit" class="btn btn-success">Mark as completed</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="5">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
  @else
      <p>No tasks found.</p>
  @endif
  
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('#success-message').length) {
            $('#success-message').delay(3000).fadeOut('slow');
        }
    });
</script>
