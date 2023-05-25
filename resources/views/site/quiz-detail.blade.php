@extends("site.layout")

@section("content")
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        @if($isJoined)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Result
                                <div class="float-right">
                                    <span class="badge bg-success rounded-pill">{{$result[0]['correct_count']}} Correct </span>
                                    <span class="badge bg-danger rounded-pill">{{$result[0]['wrong_count']}} Wrong </span>
                                </div>
                            </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of questions
                            <span class="badge bg-primary rounded-pill">{{ $quiz->questions_count }}</span>
                        </li>
                        @if($isJoined)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Finish date
                                <span title="" class="badge bg-primary rounded-pill">{{date('d.m.Y'),strtotime($finishedDate)}}</span>
                            </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of participants
                            <span class="badge bg-warning rounded-pill">{{$numberOfParticipants}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average of Score
                            <span class="badge bg-secondary rounded-pill">75</span>
                        </li>

                    </ul>
                    @if($isJoined && $myRank != null)
                    <div class="mt-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Your rank : <strong>#{{$myRank}}</strong></li>
                            <h4 ></h4>
                        </ul>
                    </div>
                    @endif

                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Top 10</h5>
                            <ul class="list-group">
                                @foreach($topTen as $participant)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ $loop->index+1 }} </strong>
                                    <img src="" class="w-8 rounded-full">
                                    <span class="text-danger">{{$participant->fullName}}</span>
                                    <span class="badge bg-success rounded-pill">{{$participant->correct_count}}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <p class="card-text">
                        {{ $quiz->description }}
                    </p>

                    @if($isJoined)
                        <a href="" class="btn btn-primary btn-block btn-sm">View Result</a>
                    @else
                        <a href="{{route('quiz.join',$quiz->id)}}" class="btn btn-success btn-block btn-sm">Join quiz</a>
                    @endif
                </div>
            </div>


        </div>
    </div>
@endsection
