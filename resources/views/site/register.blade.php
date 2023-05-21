@extends("site.layout")

@section("content")

    @if (session()->get('success'))
        <div class="alert alert-primary">
            <ul>
                {{ session()->get('success') }}
            </ul>
        </div>
    @endif
    @if (session()->get('danger'))
        <div class="alert alert-primary">
            <ul>
                {{ session()->get('danger') }}
            </ul>
        </div>
    @endif
    <h2>Register</h2>

    <form action="{{route('register')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Surname</label>
                    <input type="text" name="surname" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="">Photo</label>
                    <input type="file" name="photo" class="form-control-file">
                </div>

                <br>
                <button class="btn btn-sm btn-primary">Register</button>
                <a href="{{ route("loginPage") }}">Go to login</a>
            </div>
        </div>
    </form>

@endsection
