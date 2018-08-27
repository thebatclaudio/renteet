<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Mail\SupportMail;
use App\Support;
use Mail;

class SupportController extends Controller
{
    public function showForm(){
        return view('support', [
            'supportTypes' => \App\SupportType::all()
        ]);
    }

    public function sendSupport (Request $request){
    
        $this->validate($request, [
            'type' => 'required',
            'message' => 'required'
        ], [
            'type.required' => 'seleziona il tipo di segnalazione',
            'message.required' => 'scrivi un messaggio ed aiutaci a capire come possiamo aiutarti',
        ]);

        
       if(\Auth::user()){

            $newSupport = Support::create([
                'user_id'=> \Auth::user()->id,
                'type_id'=>$request->type,
                'message'=>$request->message
            ]);

            if($newSupport){
                Mail::to('labarbera.claudio@gmail.com')->send(new SupportMail(\Auth::user()->email, $request->type, $request->message));
                return back()->with('success', 'Grazie per averci contattato');
            } 
        }
        return back()->with('success', 'Non è stato possibile consegnare il tuo messaggio, per favore prova più tardi.');
    }

}
