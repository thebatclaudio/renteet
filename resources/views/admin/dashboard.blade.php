@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container margin-top-20">
    <div class="panel panel-default">
        <a class="btn btn-success float-sm-right" href="{{route('admin.house.wizard.one')}}"><i class="fa fa-plus"></i> Inserisci un nuovo immobile</a>
        <div class="panel-body">
            <h3 class="page-title margin-top-10">Gestisci i tuoi immobili</h3>
            <hr>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{session('success')}}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                </div>
            @endif

            <div class="row houses-list">
                @foreach($houses as $house)
                <div class="col-sm-6 col-md-4">


                    <!-- Card -->
                    <div class="card">

                        <!-- Card image -->
                        <div class="view overlay">
                            <img class="card-img-top" src="{{$house->getPreviewImageUrlAttribute()}}" alt="{{$house->name}}" height="auto">
                            <a href="{{route('admin.house', $house->id)}}">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>

                        <!-- Card content -->
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title">{{$house->name}}</h4>
                                </div>
                                <div class="col-auto">
                                    <div class="text-right">
                                        <!-- Button -->
                                        @switch($house->last_step)
                                            @case(1)
                                                <a href="{{route('admin.house.wizard.two', ['id' => $house->id])}}" class="btn btn-sm btn-outline-primary">Completa annuncio</a>
                                                @break

                                            @case(2)
                                                <a href="{{route('admin.house.wizard.three', ['id' => $house->id])}}" class="btn btn-sm btn-outline-primary">Completa annuncio</a>
                                                @break

                                            @case(3)
                                                <a href="{{route('admin.house.wizard.four', ['id' => $house->id])}}" class="btn btn-sm btn-outline-primary">Completa annuncio</a>
                                                @break

                                            @case(4)

                                                <!-- Split button -->
                                                <div class="btn-group">
                                                    <a href="{{route('admin.house', $house->id)}}" class="btn btn-sm btn-elegant">Gestisci</a>
                                                    <button type="button" class="btn btn-sm btn-elegant dropdown-toggle px-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-caret-down"></i>
                                                        <span class="sr-only">Apri Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{route('admin.house.edit.info', $house->id)}}">Modifica le informazioni</a>
                                                        <a class="dropdown-item" href="{{route('admin.house.edit.services', $house->id)}}">Modifica i servizi</a>
                                                        <a class="dropdown-item" href="{{route('admin.house.edit.photos', $house->id)}}">Modifica le foto</a>
                                                    </div>
                                                </div>
                                                @break
                                        @endswitch
                                        </div>
                                </div>
                            </div>

                            <div>
                                @if($house->last_step != 4)
                                    <span class="badge badge-warning">Da completare</span>
                                @else
                                    <span class="badge badge-success">Pubblicato</span>
                                @endif
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
