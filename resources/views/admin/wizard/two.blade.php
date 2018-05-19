@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Secondo passo</h6>
    <h3 class="step-title">Descrivi meglio il tuo immobile</h3>

    <form>
        <div class="row">
            <div class="col-md-6">
                @foreach($services as $service)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="services[{{$service->id}}]" value="">
                        {{$service->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@endsection