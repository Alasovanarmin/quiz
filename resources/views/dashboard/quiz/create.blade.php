@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Quiz</h1>
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

        <form action="{{route('dashboard.quiz.store')}}" method="POST">
            @csrf
            <div class="form-group">
                Title
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                Description
                <textarea class="form-control" name="description" rows="6"></textarea>
            </div>
            <div class="form-group">
                Category
                <select name="category_id" id="" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                Status
                <select name="status" id="" class="form-control">
                    <option value="1">Aktiv</option>
                    <option value="0">Deaktiv</option>
                </select>
            </div>

            <br>

            <button type="submit" class="btn-block btn-primary btn-sm">Save</button>
        </form>
    </div>
@endsection
