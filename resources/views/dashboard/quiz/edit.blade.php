@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Quiz</h1>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-primary">
                <ul>
                    {{ session()->get('success') }}
                </ul>
            </div>
        @endif

        @if (session()->get('danger'))
            <div class="alert alert-danger">
                <ul>
                    {{ session()->get('danger') }}
                </ul>
            </div>
        @endif

        <form action="{{route('dashboard.quiz.update',$quiz->id)}}" method="POST">
            @csrf
            <div class="form-group">
                Title
                <input type="text" name="title" class="form-control" value="{{$quiz->title}}">
            </div>
            <div class="form-group">
                Description
                <textarea class="form-control" name="description" rows="6">{{$quiz->description}}</textarea>
            </div>
            <div class="form-group">
                Category
                <select name="category_id" id="" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($quiz->category_id == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                Status
                <select name="status" id="" class="form-control">
                    <option value="1" @if($quiz->status == 1) selected @endif>Aktiv</option>
                    <option value="0" @if($quiz->status == 0) selected @endif>Deaktiv</option>
                </select>
            </div>

            <br>

            <button type="submit" class="btn-block btn-primary btn-sm">Update</button>
        </form>
    </div>
@endsection
