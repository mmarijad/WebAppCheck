@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addAppModal">
                             &#10133;
                        </button></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class = "row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                            <tr>
                                <th>Naziv</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Administrator</th>
                            </tr>

                                @foreach($results as $app)
                                    <tr>
                                        <td>{{$app->name}}</td>
                                        <td>{{$app->url}}</td>
                                        <td>{{$app->status}}</td>
                                        <td>{{$app->email}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
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
            <form action="{{ action('HomeController@store') }}" method="POST">
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
                <br>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Spremi</button>      
            </div>
            </form>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
                            
@endsection
