@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Messages</h1>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route("dashboard.messages") }}" class="btn btn-secondary btn-sm font-weight-bold text-light"> <i class="fa fa-arrow-left"></i> Geri </a>
                    </div>

                    <div class="card-body">
                        <table class="table">

                            <tbody>
                            <tr>

                                <th scope="row">Subject</th>
                                <td>{{$message->subject}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Name</th>
                                <td>{{$message->name}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Email</th>
                                <td>{{$message->email}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Tarix</th>
                                <td>{{$message->created_at}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Messsage</th>
                                <td>{{$message->message}}</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Mesaja cavab:
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route("dashboard.message.send", $message->id) }}">
                            @csrf
                            <div class="form-group">
                                Email:
                                <input type="email" name="email" class="form-control" value="{{$message->email}}" required>
                            </div>
                            <div class="form-group">
                                Başlıq:
                                <input type="text" name="subject" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                Mesaj:
                                <textarea name="message" class="form-control" rows="7" placeholder="Cavab..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success btn-block" >Göndər</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
