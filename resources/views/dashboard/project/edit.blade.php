@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Project edit</h1>
            <a href="{{ route("dashboard.project.photo", $project->id) }}" class="btn btn-sm btn-info">Edit photos</a>
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

        <form action="{{ route("dashboard.project.update", $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    Title
                    <input type="text" name="title" value="{{ $project->title }}" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    Url
                    <input type="text" name="url" value="{{ $project->url }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                Body
                <textarea class="form-control" name="body" rows="6">{{ $project->body }}</textarea>
            </div>

            <div class="form-group">
                Date
                <input type="datetime-local" name="date" value="{{ $project->date }}" class="form-control">
            </div>

            <div class="row">
                @foreach ($project->tags as $tag)
                    <div class="form-group col-md-3">
                        Tag {{ $loop->index + 1}}
                        <input type="text" name="tags[]" value="{{ $tag->tag }}" class="form-control">
                    </div>
                @endforeach
            </div>

            <br>

            <button type="submit" class="btn-block btn-primary btn-sm">Save</button>
        </form>
    </div>
@endsection
