@extends('layouts.email')

@section('title', 'Nuova richiesta di adesione')'

@section('content')

<h1>Ciao {{$user->first_name}}<h1>

<p><strong>{{$house->owner->complete_name}}</strong> ha accettato la tua richiesta di adesione per l'immobile <strong>{{$house->name}}</strong>.</p>

<br/>
<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{url('/house')}}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#04673b" fillcolor="#099154">
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;">Visualizza la tua casa</center>
  </v:roundrect>
<![endif]--><a href="{{url('/house')}}"
style="background-color:#099154;border:1px solid #04673b;border-radius:4px;color:#ffffff;display:inline-block;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Visualizza la tua casa</a></div>


@stop
