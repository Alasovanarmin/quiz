@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Project photos</h1>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-primary">
                <ul>
                    {{ session()->get('success') }}
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($photos as $photo)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <img src="/{{ $photo->photo }}" alt="" width="160">
                            </td>
                            <td>
                                <a href="{{ route("dashboard.project.photo.delete", $photo->id) }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <form action="{{ route("dashboard.project.photo.store", $project_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2>Add new photos</h2>
                    <div class="form-group">
                        <input type="file" name="photos[]" class="form-control-file" multiple>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Add</button>
                </form>
            </div>
        </div>


    </div>
@endsection
