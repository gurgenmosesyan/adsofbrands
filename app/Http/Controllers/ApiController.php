<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\SubscribeRequest;
use App\Models\Commercial\Commercial;
use Illuminate\Http\Request;
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
            'to' => trans('www.contacts.email.to.email'),
            'to_name' => trans('www.contacts.email.to.name'),
            'from' => $data['email'],
            'from_name' => $data['name'],
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

    public function rate(Request $request)
    {
        $adId = $request->input('ad_id');
        $val = $request->input('val');

        $ratedData = [];
        if (isset($_COOKIE['rate'])) {
            $ratedData = json_decode($_COOKIE['rate'], true);
            if (isset($ratedData[$adId])) {
                return null;
            }
        }

        $ad = Commercial::where('id', $adId)->firstOrFail();
        $value = ($ad->rating * $ad->qt) + $val;
        $ad->qt++;
        $ad->rating = $value / $ad->qt;
        $ad->save();

        $ratedData += [$adId => $val];
        $ratedData = json_encode($ratedData);
        setcookie('rate', $ratedData, time()+(60*60*24*365), '/');
        $_COOKIE['rate'] = $ratedData;

        $rating = number_format($ad->rating, 1);
        return $this->api('OK', ['rating' => $rating, 'percent' => $rating*10]);
    }
}