@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Secondo passo</h6>
    <h3 class="step-title">Descrivi meglio il tuo immobile</h3>

    <hr>

    <form class="margin-top-20" method="post" action="{{route('admin.house.wizard.two.save')}}">
        {{ csrf_field() }}

        <input type="hidden" value="{{$id}}" name="id" />

        <div class="row">
            <div class="col-md-6">
                <div class="list-group">
                    @foreach($servicesQuantity as $service)
                    <div class="list-group-item flex-column align-items-start">
                        <div class="row">
                            <div class="col-md-9 checkbox-column">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input data-id="{{$service->id}}" class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}">
                                        {{$service->name}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input id="service_quantity_{{$service->id}}" class="form-control pull-right" type="number" name="servicesQuantity[{{$service->id}}]" min="0" default="0" value="0" disabled>
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
                                <input class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="">
                                {{$service->name}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="margin-top-20">
                    Altri servizi (specificare sotto):
                    <textarea class="form-control w-100 margin-top-10" rows="4" name="other_services"></textarea>
                </div>
            </div>
        </div>

        <div class="actions margin-top-20 text-right">
            <button type="submit" class="btn btn-primary btn-lg">Avanti</button>
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
</script>
@endsection