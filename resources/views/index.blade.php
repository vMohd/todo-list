@extends('layouts.app')
@section('title', 'Todo List')

@section('content')

<div class="jumbotron py-5">
<div class="container text-center">
        <h1>Welcome to Todo List</h1>
        <h5>Manage your tasks efficiently with our simple todo list application.</h5>
        <h5>Stay organized, prioritize your tasks, and boost your productivity.</h5>
        
        <h5>To start managing your tasks, please login or register.</h5>

        <div class="actions mb-3 my-3">
            <a href="{{ route('login') }}" class="btn btn-primary mx-5">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        </div>

        <hr>
            <h3>Key Features:</h3>
            <ul class="list-unstyled">
                <li class="my-3 h5">Create and delete tasks</li>
                <li class="my-3 h5">Mark tasks as completed or uncompleted</li>
                <li class="my-3 h5">Prioritize tasks with custom priority levels (High, Medium, Low)</li>
            </ul>
        </div>
    </div>

@endsection
