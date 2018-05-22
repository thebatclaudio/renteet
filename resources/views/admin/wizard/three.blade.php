@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
@parent
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Terzo passo</h6>
    <h3 class="step-title">Rendi unico il tuo immobile <small>Aggiungi le tue foto</small></h3>

    <div class="row margin-top-20">
        <div class="col-md-8">
            <div class="form-group">
                <div class="file-loading">
                    <input id="files" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                </div>
            </div>
        </div>
        <div class="col-md-4 hints-container">
            <h6 class="step-number">Alcuni suggerimenti</h6>
            <ul>
                <li>Scatta delle foto luminose che esaltino le caratteristiche migliori del tuo immobile.</li>
                <li>Fai in modo che l’immobile sia in ordine (letti rifatti, bagno pulito, tavola apparecchiata) in modo da far risultare l’immobile più accogliente.</li>
            </ul>
        </div>
    </div>

    <hr>

    <h4 class="margin-top-20">Descrivi il tuo immobile</h4>

    <div class="row margin-top-20">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/locales/it.js" type="text/javascript"></script>
<script type="text/javascript">
    var $files = $("#files");
    $files.fileinput({
        theme: 'fa',
        uploadUrl: "{{route('admin.house.wizard.three.save')}}",
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
                id: {{$id}}
            };
        },
        allowedFileExtensions: ['jpg', 'jpeg', 'png'],
        overwriteInitial: false,
        maxFilesNum: 10,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        },
        language: 'it',
        uploadAsync: false,
        showUpload: false,
        showRemove: false,
        minFileCount: 1,
        initialPreviewAsData: true
    }).on("filebatchselected", function(event, files) {
        $files.fileinput("upload");

        $("#next")
    });
</script>
@endsection