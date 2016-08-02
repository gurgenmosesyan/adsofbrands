<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\InfoRequest;
use Session;

class BookingApiController extends Controller
{
    public function booking3(InfoRequest $request)
    {
        $reqData = $request->all();

        $data = [];
        $data['info'] = $reqData['info'];
        $data['phone'] = $reqData['phone'];
        $data['email'] = $reqData['email'];
        $data['text'] = $reqData['text'];

        Session::put(['booking4' => true]);
        Session::put(['booking_info' => $data]);

        return $this->api('OK', ['link' => route('booking4', cLng('code'))]);
    }
}