@extends("site.layout")

@section("content")
    <div class="row">
        <div class="col-md-8">
            @foreach($quizzes as $quiz)
                <div class="list-group">
                    <a href="{{route('quiz.detail',$quiz->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$quiz->title}}</h5>

                            <small class="text-muted">{{ date("d.m.Y", strtotime($quiz->updated_at)) }}</small>
                        </div>
                        <p class="mb-1">
                            {{$quiz->description}}
                        </p>
                        <small class="text-muted">{{$quiz->questions_count}} questions</small>
                    </a>
                </div>
            @endforeach

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Quizzes you join
                </div>
                @foreach($quizzesYouJoin as $quizzesYoujoin)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        {{$loop->index+1}} -<a href="{{route('quiz.detail',$quizzesYoujoin->quiz_id)}}">{{$quizzesYoujoin->title}}}</a>
                    </li>
                 @endforeach
                </ul>
            </div>
        </div>


    </div>
@endsection
