<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\SubscribeRequest;
use App\Email\EmailManager;
use Mail;
use DB;

class ApiController extends Controller
{
    public function contact(ContactRequest $request)
    {
        $data = $request->all();

        $emailManager = new EmailManager();
        $emailManager->storeEmail([
            'to' => $data['email'],
            'to_name' => $data['name'],
            'subject' => $data['subject'],
            'body' => $data['message']
        ]);

        return $this->api('OK', ['text' => trans('www.contact.email.success_text')]);
    }

    public function subscribe(SubscribeRequest $request)
    {
        $data = $request->all();
        $email = $data['email'];

        $emailData = DB::table('subscribes')->where('email', $email)->first();

        if ($emailData == null) {
            DB::table('subscribes')->insert(['email' => $email]);
            return $this->api('OK', trans('www.subscribe.success_text'));
        } else {
            return $this->api('OK', trans('www.subscribe.already_subscribed'));
        }
    }
}