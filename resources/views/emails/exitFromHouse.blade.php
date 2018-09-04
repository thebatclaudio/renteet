@extends('layouts.email')

@section('title', $user->complete_name.' ha abbandonato il tuo immobile')

@section('content')

<h1>Ciao {{$house->owner->first_name}}<h1>

<p>L'utente <strong>{{$user->complete_name}}</strong> ha abbandonato il tuo immobile <strong>{{$house->name}}</strong>.</p>

<br/>
<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{url('/admin/house/'.$house->id)}}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#04673b" fillcolor="#099154">
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;">Gestisci il tuo immobile</center>
  </v:roundrect>
<![endif]--><a href="{{url('/admin/house/'.$house->id)}}"
style="background-color:#099154;border:1px solid #04673b;border-radius:4px;color:#ffffff;display:inline-block;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Gestisci il tuo immobile</a></div>


@stop
