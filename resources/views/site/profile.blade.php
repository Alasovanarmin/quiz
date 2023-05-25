@extends("site.layout")

@section("content")
    <form action="{{route('profileUpdate')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Update profile</h3>
        <div class="row">
            <div class="form-group col-md-3">
                Name
                <input type="text" class="form-control" name="name" value="{{$user->name}}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                Surname
                <input type="text" class="form-control" name="surname" value="{{$user->surname}}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                Photo
                <input type="file" class="form-control" name="photo">
            </div>
            <br>
            <img src="{{asset($user->photo)}}" style="width: 140px">
            <br>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>

        </div>
    </form>
    <hr>
    <form action="{{route('changePassword')}}" method="POST">
        @csrf
        <h3>Change password</h3>
        <div class="row">
            <div class="form-group col-md-3">
                Current password
                <input type="text" class="form-control" name="current_password">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                New password
                <input type="text" class="form-control" name="new_password">
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </form>
@endsection
