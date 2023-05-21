@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Projects</h1>
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
                <th>Url</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->url }}</td>
                    <td>
                        @foreach($project->tags as $tag)
                            {{ $tag->tag }},
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route("dashboard.project.edit", $project->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
