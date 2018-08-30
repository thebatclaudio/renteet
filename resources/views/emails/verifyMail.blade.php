@extends('layouts.email')

@section('title', 'Conferma il tuo account')'

@section('content')
<h2>Benvenuto su renteet, {{$user->first_name}}</h2>
<p>Per confermare il tuo account associato all'indirizzo e-mail <strong>{{$user['email']}}</strong> clicca sul pulsante sottostante:</p>
<br/>
<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{url('user/verify', $user->verifyUser->token)}}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#04673b" fillcolor="#099154">
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;">Verifica il tuo account</center>
  </v:roundrect>
<![endif]--><a href="{{url('user/verify', $user->verifyUser->token)}}"
style="background-color:#099154;border:1px solid #04673b;border-radius:4px;color:#ffffff;display:inline-block;font-family:Ubuntu, sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Verifica il tuo account</a></div>
@stop