@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container margin-top-20">
    <div class="panel panel-default">
        <a class="btn btn-success float-sm-right" href="{{route('admin.house.wizard.one')}}"><i class="fa fa-plus"></i> Inserisci un nuovo immobile</a>
        <div class="panel-body">
            <h3 class="page-title margin-top-10">Gestisci i tuoi immobili</h3>
            <hr>
            <div class="row houses-list">
                @foreach($houses as $house)
                <div class="col-md-3">


                    <!-- Card -->
                    <div class="card">

                        <!-- Card image -->
                        <div class="view overlay">
                            <img class="card-img-top" src="{{url('/images/houses/'.$house->id.'/'.$house->photos[0]->file_name."-1920.jpg")}}" alt="{{$house->name}}" height="auto">
                            <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>

                        <!-- Card content -->
                        <div class="card-body">

                            <!-- Title -->
                            <h4 class="card-title">{{$house->name}}</h4>

                            <div>
                                @if($house->last_step != 4)
                                    <span class="badge badge-warning">Da completare</span>
                                @else
                                    <span class="badge badge-success">Pubblicato</span>
                                @endif
                            </div>

                            <div class="text-right">
                            <!-- Button -->
                            @switch($house->last_step)
                                @case(1)
                                    <a href="{{route('admin.house.wizard.two', ['id' => $house->id])}}" class="btn btn-outline-primary">Completa annuncio</a>
                                    @break

                                @case(2)
                                    <a href="{{route('admin.house.wizard.three', ['id' => $house->id])}}" class="btn btn-outline-primary">Completa annuncio</a>
                                    @break

                                @case(3)
                                    <a href="{{route('admin.house.wizard.four', ['id' => $house->id])}}" class="btn btn-outline-primary">Completa annuncio</a>
                                    @break

                                @case(4)

                                    <!-- Split button -->
                                    <div class="btn-group">
                                        <a href="{{route('admin.house', $house->id)}}" class="btn btn-primary">Gestisci</a>
                                        <button type="button" class="btn btn-primary dropdown-toggle px-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-caret-down"></i>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    @break
                            @endswitch
                            </div>

                        </div>

                    </div>
                    <!-- Card -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
