@extends('frame')

@section('sadrzaj')
<body style="background-color:#fff;">
<div class="overflow-auto">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6"> 
                    <div class="card">
                        <div class = "row" style="margin:20px">
                        <div class="col-md-1"> </div>
                        <div class="coll-md-5">
                            <h1 class="text-center"> 
                                <u> {{$a->name}} </u>
                            </h1>
                        </div>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class = "row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <u>URL:</u> <br> {{$a->url}} <br><hr>
                                    <u> Status:</u> <br> {{$a->status}}<br><hr>
                                    <u> Vrijeme:</u> <br> {{$vrijeme}}<br><hr>
                                    <u> Administrator:</u> <br> {{$a->email}}<br><hr>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
            </div>
        </div>
    <div class="col-md-6">
        <div class="card" style="height: 433px;">
        <br><br>
            <div class="row justify-content-center" style="margin: 20px">
                <div class="col-md-9"><h5 > <u>Povijest</u></h5></div>
                <div class="col-md-1"> </div>
            </div><br>
            @if($apps->isNotEmpty())
            <div class ="row justify-content-center" style="margin-right: 20px; margin-left: 20px; margin-bottom: 10px;">
                <div class="col-md-1"> </div>
                <div class="col-md-10"  >
                    <table class="table table-responsive table-hover" style="overflow-y: scroll; height: 200px;">
                        <tr>
                            <th>Datum</th>  
                            <th>Status</th>
                        </tr>
                        @foreach($apps as $app)
                        <tr>
                            <td>{{$app->date}}</td>
                            <td>{{$app->status}}</td>                                        
                        </tr>
                        @endforeach
                    </table> 
                </div>
                <div class="col-md-1"> </div>
            </div> <br>
            @endif
        </div>
    </div>
</div></div></div>
</div>
</body>
@endsection
