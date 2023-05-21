@extends("site.layout")

@section("content")
    <h1>Suallar</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{route('quiz.finish',$id)}}" method="post">
                @csrf
                @foreach($questions as $question)
                    <strong> {{ $question->title }}</strong>
                    <h7>{{ $question->description }}</h7>
                    <div style="color: red">*
                        @if ($question->type == 1)
                            Single answer
                        @elseif($question->type == 2)
                            Multiple answer
                        @elseif($question->type == 3)
                            Free
                        @endif
                    </div>
                    <img src="" class="img-responsive" style="width: 50%;"><br>

                    @if (in_array($question->type, [1,2]))
                        @foreach($question->answers_for_join_page as $answer)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="{{ $answer->question_id . ($question->type == 2 ? "[]" : "") }}"
                                       id="" value="{{ $answer->id }}">
                                <label class="form-check-label" for="">
                                    {{ $answer->answer }}
                                </label>
                            </div>
                        @endforeach
                    @elseif($question->type == 3)
                        <input type="text" name="{{ $question->id }}">
                    @endif
                    <hr>
                @endforeach


                <br>
                <button type="submit" class="btn btn-success btn-sm btn-block">End quiz </button>
            </form>


        </div>
    </div>
@endsection
