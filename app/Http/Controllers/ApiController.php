<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\SubscribeRequest;
use Mail;
use DB;

class ApiController extends Controller
{
    public function contact(ContactRequest $request)
    {
        $data = $request->all();
        Mail::send(['emails.default_html', 'emails.default'], ['data' => $data], function($message) use($data) {
            $message->from($data['email']);
            $message->to(trans('www.contact.admin_email'), trans('www.contact.admin_name'));
            $message->subject(trans('www.contact.email_subject'));
        });
        return $this->api('OK', trans('www.contact.email.success_text'));
    }

    public function subscribe(SubscribeRequest $request)
    {
        $data = $request->all();
        $email = $data['email'];

        $emailData = DB::table('subscribe')->where('email', $email)->first();

        if ($emailData == null) {
            DB::table('subscribe')->insert(['email' => $email]);
            return $this->api('OK', trans('www.subscribe.success_text'));
        } else {
            return $this->api('EXIST', trans('www.subscribe.already_subscribed'));
        }
    }
}