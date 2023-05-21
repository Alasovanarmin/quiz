@extends('dashboard.layout.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Question</h1>
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

        <form action="{{route('dashboard.question.update',$question->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                Title
                <input type="text" name="title" class="form-control" value="{{$question->title}}">
            </div>
            <div class="form-group">
                Description
                <textarea class="form-control" name="description" rows="6">{{$question->description}}</textarea>
            </div>
            <div class="form-group">
                Question type
                <select name="type" class="form-control">
                    <option value="1" @if($question->type == 1) selected @endif >Single right answer</option>
                    <option value="2" @if($question->type == 2) selected @endif>Multiple right answer</option>
                    <option value="3" @if($question->type == 3) selected @endif>Free answer</option>
                </select>
            </div>

            <div class="form-group">
                Level
                <select name="level" id="" class="form-control">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @if($question->level == $i) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="answers">
                    @foreach($question->answers as $answer)
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" value="{{$answer->answer}}" class="form-control" name="answers[]" placeholder="Answer">
                        </div>
                        <div class="col-sm-1">
                            <button type="button"
                                    class="@if($loop->index == 0) add-answer-input btn btn-success @else remove-answer-input btn btn-primary @endif">
                                @if($loop->index == 0)
                                +
                                @else
                                -
                                @endif
                            </button>
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control" name="is_true[]">
                                <option value="0" @if($answer->is_true == 0) selected @endif>False</option>
                                <option value="1" @if($answer->is_true == 1) selected @endif >True</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <div class="form-group">
                Upload photo
                <input type="file" name="photo" class="form-control-file">
            </div>
            <br>
            <img src="/{{$question->photo}}" alt="" width="140px">
            <br>
            <br>
            <button type="submit" class="btn-block btn-primary btn-sm">Save</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        $('.add-answer-input').on('click',() => {
            $('.answers').append(`
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="answers[]" placeholder="Answer">
                    </div>
                    <div class="col-sm-1">
                        <div class="remove-answer-input btn btn-primary">-</div>
                    </div>
                    <div class="col-sm-1">
                        <select class="form-control" name="is_true[]">
                            <option value="0">False</option>
                            <option value="1">True</option>
                        </select>
                    </div>
                </div>
            `)
        })

        $(document).on('click','.remove-answer-input',(e) => {
            $(e.target).parent().parent().remove()
        })
    </script>
@endsection
