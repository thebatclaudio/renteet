@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="page-title">Case nei dintorni di: {{$searchInput}}</h3>
    @forelse($houses as $house)
    {{$house->name}}
    @empty
    <h4 class="text-muted text-center">Nessuna casa trovata</h4>
    @endforelse
</div>
@endsection
