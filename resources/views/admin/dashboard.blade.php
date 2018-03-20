@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <h3>Bentornato {{$user->first_name}}!</h3>
            <hr>
            <h4>Le tue case:</h4>
            <div class="houses-list">
                @foreach($user->houses as $house)
                <div class="card" style="width: 20rem;">
                    <img class="card-img-top" src="{{$house->preview_image_url}}" alt="{{$house->name}}">
                    <div class="card-block">
                        <h4 class="card-title">{{$house->name}}</h4>
                        <!--p class="card-text"></p-->
                        <a href="{{route('admin.house', $house->id)}}" class="btn btn-primary">Gestisci</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
