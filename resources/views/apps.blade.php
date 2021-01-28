@extends('layouts.app')
@section('content')
<div class="container" style=" overflow-y: scroll; height: 700px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <div class ="row">
                        <div class="col-md-2"> 
                            <button type="button" class="btn" style="background-color:  #00cc99; color:white;" data-toggle="modal" data-target="#addAppModal">
                                &#10133;
                            </button>
                        </div>
                        <div class="col-md-10">
                            <h1 style="font-size: 28px; font-weight: 600; letter-spacing: .1rem; text-transform: uppercase;"> 
                                Web aplikacije 
                            </h1>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="card-body" style="margin-right: 20px; margin-left: 20px; margin-bottom: 120px;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($apps ?? ''->isNotEmpty())
                    <div class = "row">
                        <div class="col-md-1"> </div>
                        <div class="col-md-10">
                            <table class="table table-hover">
                            <tr>
                                <th>Naziv</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Administrator</th>
                                <th>Akcije</th>
                            </tr>

                                @foreach($apps ?? '' as $app)
                                    <tr>
                                        <td><b>{{$app->name}}</b></td>
                                        <td style="width=15%">{{$app->url}}</td>
                                        <td>{{$app->current_state}}</td>
                                        <td>{{$app->email}}</td>
                                        <td style="white-space: word-wrap;">                
                                            <a href = "{{ action('AppController@check', $app->app_id)}}" class="btn  btn-link " style="color:#00cc99;"><i class="fa fa-check"></i></a>  
                                            <a href = "{{ action('AppController@details', $app->app_id)}}"  class="btn  btn-link" style="color:#00cc99;"> <i class="fa fa-info-circle"></i></a>  
                                            <a href ="{{ action('AppController@delete', $app->app_id)}}"  class="btn btn-link" style="color:#00cc99;"><i class="fa fa-trash"></i></a> 
                                        </td>
                                    </tr>
                                @endforeach
                            </table> <br><br>
                        </div>
                        <div class="col-md-1"> </div>
                    </div>
                    @else 
                        <div>
                            <div class = "row">
                                <div class="col-md-10">
                                    <h5>U bazi još nema web aplikacija.</h5>
                                </div>
                            </div> 
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addAppModal" tabindex="-1" role="dialog" aria-labelledby="addAppModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAppModalTitle">Dodajte Web aplikaciju</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ action('AppController@store') }}" method="POST">
            <div class="modal-body">
                 @csrf <!-- Svaka forma mora imati CSRF token! -->
                 <div class="form-group">
                    <label for="name">Naziv *</label>
                    <input name="name" type="text" class="form-control" placeholder="Unesite naziv...*" required>
                </div>
                <div class="form-group">
                    <label for="url">Url*</label>
                    <input name="url" type="text" class="form-control" placeholder="Unesite url...*" required>
                </div>
                <div class="form-group">
                    <label for="namelastname">Ime administratora *</label>
                    <input name="namelastname" type="text" class="form-control" placeholder="Unesite ime administratora...*" required>
                </div>
                <div class="form-group">
                    <label for="email">Email administratora*</label>
                    <input name="email" type="text" class="form-control" placeholder="Unesite email administratora...*" required>
                </div>
                @error('url')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <button type="submit" class="btn btn-lg btn-block" style="background-color: #00cc99; color:white;">Spremi</button>      
            </div>
            </form>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
                            
@endsection