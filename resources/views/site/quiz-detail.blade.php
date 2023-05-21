@extends("site.layout")

@section("content")
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Point
                            <span class="badge bg-info rounded-pill">89</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Result
                            <div class="float-right">
                                <span class="badge bg-success rounded-pill">15 Correct </span>
                                <span class="badge bg-danger rounded-pill">12 Wrong </span>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of questions
                            <span class="badge bg-primary rounded-pill">{{ $quiz->questions_count }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Finish date
                            <span title="" class="badge bg-primary rounded-pill">12.12.2023</span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of participants
                            <span class="badge bg-warning rounded-pill">19</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average of Score
                            <span class="badge bg-secondary rounded-pill">75</span>
                        </li>

                    </ul>

                    <div class="mt-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Your rank : <strong>#2</strong></li>
                            <h4 ></h4>
                        </ul>
                    </div>


                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">Top 10</h5>
                            <ul class="list-group">

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>1. </strong>
                                    <img src="" class="w-8 rounded-full">
                                    <span class="text-danger">Sahmarcik</span>
                                    <span class="badge bg-success rounded-pill">56</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>2. </strong>
                                    <img src="" class="w-8 rounded-full">
                                    <span class="text-danger">Ferman</span>
                                    <span class="badge bg-success rounded-pill">23</span>
                                </li>


                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <p class="card-text">
                        {{ $quiz->description }}
                    </p>

                    <a href="" class="btn btn-primary btn-block btn-sm">View Result</a>

                    <a href="{{route('quiz.join',$quiz->id)}}" class="btn btn-success btn-block btn-sm">Join quiz</a>
                </div>
            </div>


        </div>
    </div>
@endsection
