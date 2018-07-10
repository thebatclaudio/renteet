@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('styles')
<link rel="stylesheet" href="/css/tagsinput.css">
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('.tagsinput').tagsinput({
        confirmKeys: [13,32,188]
    });
});
</script>
<script src="/js/tagsinput.js"></script>
@endsection

@section('content')
    <div class="container margin-top-20">
        <h1 class="page-title">{{'L\'ultimo Passo'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form class="form-horizontal" method="POST" action="{{ route('save-interests') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" placeholder="I tuoi interessi" name="interests" class="tagsinput">
                            </div>
                        </div>
                        <div class="row margin-top-20">
                            <div class="col-md-12">
                                <input type="text" placeholder="Che lingue conosci ?" name="languages" class="tagsinput">
                            </div>
                        </div>

                        <div class="row margin-top-20">
                            <div class="col-md-12">                    
                                <button type="submit" class="btn btn-success">Salva</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection