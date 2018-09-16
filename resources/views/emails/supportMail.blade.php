@extends('layouts.email')

@section('title', 'Nuova richiesta di supporto')

@section('content')
<ul>
    <li>Da: <strong>{{$user->complete_name}} - {{$user->email}}</strong></li>
    <li>Tipo: <strong>{{$support->type->name}}</strong></li>
    <li>{{$support->message}}</li>
</ul>
@stop