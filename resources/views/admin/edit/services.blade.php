@extends('layouts.admin')

@section('title', 'Modifica i servizi del tuo immobile '.$house->name)

@section('content')
<div class="container margin-top-20">
    <h6 class="step-number">{{$house->name}}</h6>
    <h3 class="step-title">Modifica i servizi</h3>

    <hr>

    <form class="margin-top-20" method="post" action="{{route('admin.house.edit.services.save', $house->id)}}">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6">
                <div class="list-group">
                    @foreach($servicesQuantity as $service)
                    <div class="list-group-item flex-column align-items-start">
                        <div class="row">
                            <div class="col-7 checkbox-column">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @if($house->hasService($service->id))
                                            <input data-id="{{$service->id}}" class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" checked="checked">
                                        @else
                                            <input data-id="{{$service->id}}" class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}">
                                        @endif
                                        
                                        {{$service->name}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-5">
                                @if(!$house->hasService($service->id))
                                    <input id="service_quantity_{{$service->id}}" class="form-control pull-right" type="number" name="servicesQuantity[{{$service->id}}]" min="0" default="0" value="0" disabled>
                                @else
                                    <input id="service_quantity_{{$service->id}}" class="form-control pull-right" type="number" name="servicesQuantity[{{$service->id}}]" min="0" default="0" value="{{$house->services()->where(['services.id' => $service->id])->first()->pivot->quantity}}">
                                @endif
                            </div>                            
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <div class="list-group">
                    @foreach($servicesWithoutQuantity as $service)
                    <div class="list-group-item flex-column align-items-start">
                        <div class="form-check">
                            <label class="form-check-label">
                                @if($house->hasService($service->id))
                                <input class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" checked="checked">
                                @else
                                <input class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}">
                                @endif
                                {{$service->name}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="margin-top-20">
                    Altri servizi (specificare sotto):
                    <textarea class="form-control w-100 margin-top-10" rows="4" name="other_services">{{$house->other_services}}</textarea>
                </div>
            </div>
        </div>

        <div class="actions margin-top-20 text-right">
            <button type="submit" class="btn btn-primary btn-lg">Salva</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(".form-check-input").on('change', function() {
    if($(this).is(':checked')) {
        $("#service_quantity_"+$(this).data('id')).attr('disabled', false).attr('value', 1);
    } else {
        $("#service_quantity_"+$(this).data('id')).attr('disabled', true).attr('value', 0);
    }
});

$(document).ready(function(){
    $(".form-check-input").each(function(){
        if($(this).is(':checked')) {
            console.log('eccolo');
            $("#service_quantity_"+$(this).data("id")).attr('disabled', false);
            if($("#service_quantity_"+$(this).data("id")).val() == 0) {
                $("#service_quantity_"+$(this).data("id")).val(1);
            }
        }
    });
});
</script>
@endsection