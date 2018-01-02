<?php

namespace App\Http\Controllers;

use CodeBot\CallSendApi;
use CodeBot\Message\Text;
use CodeBot\SenderRequest;
use CodeBot\WebHook;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function subscribe(){
        $webhook = new WebHook;
        $subscribe = $webhook->check(config('botfb.validationToken'));
        if(!$subscribe){
            abort(403, 'Unathorized action.');
        }

        return $subscribe;
    }

    public function  receiveMessage(Request $request){
        $sender = new SenderRequest;
        $senderId = $sender->getSenderId();
        $message = $sender->getMessage();

        $text = new Text($senderId);
        $callSenderApi = new CallSendApi(config('botfb.pageAccessToken'));
        $callSenderApi->make($text->message('Oii, eu sou um bot...'));
        $callSenderApi->make($text->message('Você digitou: '.$message));

        return '';
    }

}
