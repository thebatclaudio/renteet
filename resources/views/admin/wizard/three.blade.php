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
    <h3 class="step-title">Rendi unico il tuo immobile <small id="step-small-title">Aggiungi le tue foto</small></h3>

    <div id="step-one-container">
        <div class="row margin-top-20">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="file-loading">
                        <input id="files" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                    </div>
                </div>
            </div>
            <div class="col-md-4 hints-container">
                <h6 class="hints-title">Alcuni suggerimenti</h6>
                <ul>
                    <li>Scatta delle foto luminose che esaltino le caratteristiche migliori del tuo immobile</li>
                    <li>Fai in modo che l’immobile sia in ordine (letti rifatti, bagno pulito, tavola apparecchiata) in modo da far risultare l’immobile più accogliente</li>
                </ul>
            </div>
        </div>

        <div class="actions margin-top-20 text-right">
            <button type="button" id="next-btn" class="btn btn-primary btn-lg" disabled>Avanti</button>
        </div>
    </div>

    <div id="step-two-container" style="display: none">
        <form method="post" action="{{route('admin.house.wizard.three.save')}}">
            {{ csrf_field() }}
            <input type="hidden" value="{{$id}}" name="id" />

            <div class="row margin-top-20">
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control w-100" type="text" name="name" placeholder="Dai un nome al tuo immobile" required>
                        <p class="name-hints">Prova <strong>La casa di {{\Auth::user()->first_name}}</strong> o <strong>La casa di {{$streetName}}</strong></p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control w-100" rows="6" placeholder="Aggiungi una descrizione del tuo immobile" name="description" required></textarea>
                    </div>
                </div>
                <div class="col-md-4 hints-container">
                    <h6 class="hints-title">Alcuni suggerimenti</h6>
                    <ul>
                        <li>Aggiungi valore con una descrizione attraente</li>
                        <li>Menziona locali, università, monumenti, bar o supermercati vicini</li>
                    </ul>
                </div>
            </div>

            <div class="actions margin-top-20 text-right">
                <button type="submit" id="submit-btn" class="btn btn-primary btn-lg">Avanti</button>
            </div>
        </form>
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
        uploadUrl: "{{route('admin.house.wizard.three.upload')}}",
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

        $("#next-btn").attr('disabled', false);
    });

    $("#next-btn").on('click', function () {
        $("#step-one-container").hide();
        $("#step-two-container").show();
        $("#step-small-title").text("Aggiungi una descrizione");
        $(".progress-bar").width("83%");
    });
</script>
@endsection