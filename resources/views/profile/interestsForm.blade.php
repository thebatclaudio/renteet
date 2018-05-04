@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('styles')
<link rel="stylesheet" href="/css/tagsinput.css">
@endsection

@section('scripts')
<script>
{{-- var citynames = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: 'assets/citynames.json',
    filter: function(list) {
      return $.map(list, function(cityname) {
        return { name: cityname }; });
    }
  }
});
citynames.initialize();

$('input').tagsinput({
  typeaheadjs: {
    name: 'citynames',
    displayKey: 'name',
    valueKey: 'name',
    source: citynames.ttAdapter()
  }
}); --}}
</script>
<script src="/js/tagsinput.js"></script>
@endsection

@section('content')
    <div class="container margin-top-20">
        <h1 class="page-title">{{'Inserisci i tuoi interessi'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" data-role="tagsinput">
                        </div>
                    </div>

                    <div class="row margin-top-20">
                        <div class="col-md-12">                    
                            <button type="submit" class="btn btn-success">Salva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection