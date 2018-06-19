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
                <div class="col-md-4">
                    <div class="card">
                        <div class="house-card-img card-img-top" style="background-image: url({{$house->preview_image_url}})"></div>
                        <div class="card-block">
                            <h5 class="card-title text-truncate">{{$house->name}}</h5>
                            <!--p class="card-text"></p-->
                            <div class="row">
                                <div class="col-md-6">
                                    @if($house->last_step != 4)
                                        <span class="badge badge-warning">Da completare</span>
                                    @else
                                        <span class="badge badge-success">Pubblicato</span>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">
                                    @switch($house->last_step)
                                        @case(1)
                                            <a href="{{route('admin.house.wizard.two', ['id' => $house->id])}}" class="btn btn-outline-primary btn-sm">Completa annuncio</a>
                                            @break

                                        @case(2)
                                            <a href="{{route('admin.house.wizard.three', ['id' => $house->id])}}" class="btn btn-outline-primary btn-sm">Completa annuncio</a>
                                            @break

                                        @case(3)
                                            <a href="{{route('admin.house.wizard.four', ['id' => $house->id])}}" class="btn btn-outline-primary btn-sm">Completa annuncio</a>
                                            @break

                                        @case(4)
                                            <a href="{{route('admin.house', $house->id)}}" class="btn btn-primary btn-sm">Gestisci</a>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
