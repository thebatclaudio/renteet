@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
@parent
<style>
div.btn.btn-primary.btn-file {
    margin: 0px;
}

button.close.fileinput-remove {
    font-size: 32px;
    padding: 5px;
}

.bg-success {
    background-color: #128d52!important;
}

.text-success {
    color: #128d52!important;
}

.btn.kv-file-zoom, .btn.kv-file-download {
    display: none;
}

.btn.kv-file-remove {
    padding: 1px!important;
    border-color: #212121!important;
    color: #212121!important;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container margin-top-20">
    <h6 class="step-number">{{$house->name}}</h6>
    <h3 class="step-title">Modifica le foto</h3>

    <hr>

    <div id="step-one-container">
        <div class="row margin-top-20">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="file-loading">
                        <input id="files" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
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
            <a href="{{route('admin.dashboard')}}" class="btn btn-primary btn-lg">Completato</a>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/it.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/themes/fa/theme.min.js" type="text/javascript"></script>
<script type="text/javascript">

    var photos = {!!json_encode($house->photos->pluck('id'))!!};

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
        deleteExtraData: function(key) {
            return {
                _token: $("input[name='_token']").val()
            };
        },
        allowedFileExtensions: ['jpg', 'jpeg', 'png'],
        //overwriteInitial: false,
        maxFilesNum: 10,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        },
        language: 'it',
        uploadAsync: true,
        showUpload: false,
        showRemove: true,
        deleteUrl: "{{route('admin.house.edit.photos.delete', $house->id)}}",
        minFileCount: 1,
        initialPreview: {!!json_encode($house->photos->pluck('image_url'))!!},
        initialPreviewAsData: true,
        initialPreviewConfig: [
            @foreach($house->photos as $photo)
            {caption: "{{$photo->file_name}}", downloadUrl: "{{$photo->image_url}}", size: 930321, width: "120px", key: {{$photo->id}}},
            @endforeach
        ],
    }).on("filebatchselected", function(event, files) {
        $files.fileinput("upload");

        $("#next-btn").attr('disabled', false);
    });
</script>
@endsection