@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">About</h1>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-primary">
                <ul>
                    {{ session()->get('success') }}
                </ul>
            </div>
        @endif

        <form action="{{ route("dashboard.about.update") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    Email
                    <input type="text" name="email" class="form-control" value="{{ $about->email }}">
                </div>
                <div class="form-group col-md-6">
                    Phone
                    <input type="text" name="phone" class="form-control" value="{{ $about->phone }}">
                </div>
            </div>
            <div class="form-group">
                Summary
                <textarea class="form-control" name="summary" rows="6">{{ $about->summary }}</textarea>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    Instagram <i class="fab fa-instagram"></i>
                    <input type="text" name="instagram" class="form-control" value="{{ $about->instagram }}">
                </div>
                <div class="form-group col-md-6">
                    Facebook <i class="fab fa-facebook"></i>
                    <input type="text" name="facebook" class="form-control" value="{{ $about->facebook }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    Linkedin <i class="fab fa-linkedin"></i>
                    <input type="text" name="linkedin" class="form-control" value="{{ $about->linkedin }}">
                </div>
                <div class="form-group col-md-6">
                    Github <i class="fab fa-github"></i>
                    <input type="text" name="github" class="form-control" value="{{ $about->github }}">
                </div>
            </div>

            <div class="form-group">
                Upload photo
                <input type="file" name="photo" class="form-control-file">
            </div>

            <img src="/{{ $about->photo }}" width="140px">

            <br> <br>

            <button type="submit" class="btn-block btn-primary btn-sm">Update</button>
        </form>
    </div>
@endsection
