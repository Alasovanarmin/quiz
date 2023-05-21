@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category Edit</h1>
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

        <form action="{{route('dashboard.category.update',$category->id)}}" method="POST">
            @csrf
            <div class="form-group">
                Please Update Category

                <input type="text" name="name" class="form-control" value="{{$category->name}}">
            </div>
            <br>
            <button type="submit" class="btn-block btn-primary btn-sm">Save</button>
        </form>
    </div>
@endsection

