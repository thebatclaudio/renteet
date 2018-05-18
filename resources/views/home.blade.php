@extends('layouts.app')

@section('title', 'Be friendly')

@section('content')
<div class="container margin-top-20">
    <h3>Immobili condivisi nei dintorni di <strong>{{Auth::user()->livingCity->text}}</strong></h3>

    {{print_r(Auth::user()->livingCity, true)}}
</div>
@endsection
