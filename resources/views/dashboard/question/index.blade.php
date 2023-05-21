@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{$quiz->title}} Questions</h1>
            <a href="{{route('dashboard.question.create',$quiz_id)}}" class="btn btn-sm btn-info">Add</a>
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
                <th>Description</th>
                <th>Type</th>
                <th>Level</th>
                <th>Answers</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$question->title}}</td>
                    <td>{{$question->description}}</td>
                    <td>
                        @switch($question->type)
                            @case(1)
                                Single right answer
                                @break
                            @case(2)
                                Multiple right answer
                                @break
                            @case(3)
                                Free answer
                                @break
                        @endswitch
                    </td>
                    <td>{{$question?->level}}</td>
                    <td>
                        <ul>
                            @foreach($question->answers as $answer)
                                <li>
                                    <b>{{$answer->answer}}</b>
                                    @if($answer->is_true)
                                        <b style="color: green">
                                             True
                                        </b>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td> <img src="{{asset($question->photo)}}" width="100"></td>
                    <td>
                        <a href="{{route('dashboard.question.edit', $question->id)}}" class="btn btn-sm btn-primary">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="{{route('dashboard.question.delete', $question->id)}}" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
