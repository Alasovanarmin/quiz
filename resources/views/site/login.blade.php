@extends("site.layout")

@section("content")
    <h2>Login</h2>

    <form action="{{route('login')}}" method="POST">
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
                <br>
                <button class="btn btn-sm btn-primary">Login</button>
                <a href="{{ route("registerPage") }}">Go to register</a>
            </div>
        </div>
    </form>

@endsection
