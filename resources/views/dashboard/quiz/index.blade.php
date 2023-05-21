@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quizzes</h1>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-primary">
                <ul>
                    {{ session()->get('success') }}
                </ul>
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Body</th>
                <th>Category</th>
                <th>Status</th>
                <th>Question Count</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->description }}</td>
                    <td>{{ $quiz?->category_name }}</td>
                    <td>{{ $quiz->status ? "Aktiv" : "Deaktiv" }}</td>
                    <td>{{ $quiz?->questions_count}}</td>
                    <td>
                        <a href="{{route('dashboard.quiz.questions',$quiz->id)}}" class="btn btn-sm btn-warning">
                            <i class="fa fa-question"></i>
                        </a>
                        <a href="{{route('dashboard.quiz.edit', $quiz->id)}}" class="btn btn-sm btn-primary">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="{{route('dashboard.quiz.delete', $quiz->id)}}" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
