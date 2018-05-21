@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container margin-top-20">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <h3 class="page-title">Bentornato {{$user->first_name}}!</h3>
            <a class="btn btn-primary pull-right" href="{{route('admin.house.wizard.one')}}"><i class="fa fa-plus"></i> Inserisci un nuovo immobile</a>
            
            <hr>
            <h4>Le tue case:</h4>
            <div class="row houses-list">
                @foreach($user->houses as $house)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="{{$house->preview_image_url}}" alt="{{$house->name}}">
                        <div class="card-block">
                            <h5 class="card-title">{{$house->name}}</h5>
                            <!--p class="card-text"></p-->
                            <a href="{{route('admin.house', $house->id)}}" class="btn btn-primary">Gestisci</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
