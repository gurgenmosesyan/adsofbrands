<?php

namespace App\Http\Controllers;

use App\Models\Booking\Manager;
use App\Models\Country\Country;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Background\Background;
use App\Models\Accommodation\Accommodation;
use App\Models\Reserved\Reserved;
use DateTime;
use SoapClient;
use Session;

class BookingController extends Controller
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    protected function background()
    {
        $background = Background::first();
        if (empty($background->booking)) {
            return $background->getImage('homepage');
        } else {
            return $background->getImage('booking');
        }
    }

    public function booking1()
    {
        Session::forget('booking2');
        Session::forget('booking3');
        Session::forget('booking4');
        $background = $this->background();

        $startDate = Session::get('start_date');
        $endDate = Session::get('end_date');
        if ($startDate == null || $endDate == null) {
            $startDate = date('Y-m-d', time()+86400);
            $endDate = date('Y-m-d', time()+172800);
        }

        return view('booking.booking1')->with([
            'background' => $background,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function booking2(Request $request)
    {
        Session::forget('booking3');
        Session::forget('booking4');
        Session::forget('booking_info');
        $background = $this->background();

        if ($request->isMethod('post')) {
            Session::put(['booking2' => true]);
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            Session::put(['start_date' => $startDate]);
            Session::put(['end_date' => $endDate]);
        }

        if (Session::get('booking2') == null) {
            return redirect()->route('booking1', cLng('code'));
        }

        $startDate = Session::get('start_date');
        $endDate = Session::get('end_date');
        $interval = 0;

        if (is_string($startDate) && is_string($endDate)) {
            $checkStart = DateTime::createFromFormat('Y-m-d', $startDate);
            $checkEnd = DateTime::createFromFormat('Y-m-d', $endDate);
            if ($checkStart && $checkStart->format('Y-m-d') === $startDate && $checkEnd && $checkEnd->format('Y-m-d') === $endDate) {
                if ($startDate > date('Y-m-d') && $endDate > $startDate) {
                    $interval = (strtotime($endDate) - strtotime($startDate)) / 86400;
                    $accommodations = Accommodation::joinMl()->with('images')->with(['facilities' => function($query) {
                        $query->current();
                    }])->with(['details' => function($query) {
                        $query->current();
                    }])->get()->keyBy('id');
                    $reserves = Reserved::where('date_from', '<', $endDate)->where('date_to', '>', $startDate)->orderBy('room_quantity', 'asc')->get();
                    foreach ($reserves as $reserve) {
                        if (isset($accommodations[$reserve->accommodation_id])) {
                            $accommodations[$reserve->accommodation_id]->room_quantity -= $reserve->room_quantity;
                        }
                    }
                    foreach ($accommodations as $acc) {
                        $acc->price = $acc->price * $interval;
                        foreach ($acc->details as $key => $detail) {
                            $acc->details[$key]->price = $detail->price * $interval;
                        }
                    }
                } else {
                    $accommodations = collect();
                }
            } else {
                $accommodations = collect();
            }
        } else {
            $accommodations = collect();
        }

        return view('booking.booking2')->with([
            'background' => $background,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'accommodations' => $accommodations,
            'interval' => $interval
        ]);
    }

    public function booking3(Request $request)
    {
        Session::forget('booking4');
        Session::forget('booking_info');
        $background = $this->background();

        if ($request->isMethod('post')) {
            Session::put(['booking3' => true]);
            $reqData = $request->all();
            $data = [];
            $accIds = [];
            if (isset($reqData['accommodations']) && is_array($reqData['accommodations'])) {
                foreach ($reqData['accommodations'] as $accId => $value) {
                    if (!empty($value['quantity'])) {
                        $accIds[] = $accId;
                        $data[$accId]['quantity'] = $value['quantity'];
                        if (isset($value['details']) && is_array($value['details'])) {
                            foreach ($value['details'] as $index => $detail) {
                                if ($detail == '1') {
                                    $data[$accId]['details'][$index] = 1;
                                }
                            }
                        }
                    }
                }
            }
            Session::put(['booking_acc' => $data]);
        }

        if (Session::get('booking3') == null) {
            if (Session::get('booking2') == null) {
                return redirect()->route('booking1', cLng('code'));
            } else {
                return redirect()->route('booking2', cLng('code'));
            }
        }

        $data = Session::get('booking_acc');
        $accIds = [];
        foreach ($data as $key => $value) {
            $accIds[] = $key;
        }

        $accommodations = Accommodation::joinMl()->whereIn('accommodations.id', $accIds)->with(['details' => function($query) {
            $query->current();
        }])->get();

        $countries = Country::all();

        return view('booking.booking3')->with([
            'background' => $background,
            'accommodations' => $accommodations,
            'countries' => $countries
        ]);
    }

    public function booking4()
    {
        if (Session::get('booking4') == null) {
            if (Session::get('booking3') != null) {
                return redirect()->route('booking3', cLng('code'));
            } else if (Session::get('booking2') != null) {
                return redirect()->route('booking2', cLng('code'));
            } else {
                return redirect()->route('booking1', cLng('code'));
            }
        }
        $background = $this->background();

        return view('booking.booking4')->with([
            'background' => $background
        ]);
    }

    public function cash(Request $request)
    {
        if (!$request->isMethod('post') || Session::get('booking4') == null) {
            if (Session::get('booking4') != null) {
                return redirect()->route('booking4', cLng('code'));
            } else if (Session::get('booking3') != null) {
                return redirect()->route('booking3', cLng('code'));
            } else if (Session::get('booking2') != null) {
                return redirect()->route('booking2', cLng('code'));
            } else {
                return redirect()->route('booking1', cLng('code'));
            }
        }
        Session::forget('booking4');
        Session::forget('booking3');

        $background = $this->background();

        $startData = Session::get('start_date');
        $endDate = Session::get('end_date');
        $accommodations = Session::get('booking_acc');
        $info = Session::get('booking_info');

        if (($data = $this->manager->check($startData, $endDate, $accommodations)) !== false) {
            Session::forget('booking2');
            $success = true;
            $message = trans('www.booking.cash.success');
            $price = $data['price'];
            $accommodations = $data['accommodations'];
            $this->manager->finishCash($startData, $endDate, $accommodations, $price, $info);
        } else {
            $success = false;
            $message = trans('www.booking.error.rooms');
        }

        return view('booking.booking5')->with([
            'background' => $background,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function ameria(Request $request)
    {
        if (!$request->isMethod('post') || Session::get('booking4') == null) {
            if (Session::get('booking4') != null) {
                return redirect()->route('booking4', cLng('code'));
            } else if (Session::get('booking3') != null) {
                return redirect()->route('booking3', cLng('code'));
            } else if (Session::get('booking2') != null) {
                return redirect()->route('booking2', cLng('code'));
            } else {
                return redirect()->route('booking1', cLng('code'));
            }
        }

        $startData = Session::get('start_date');
        $endDate = Session::get('end_date');
        $accommodations = Session::get('booking_acc');
        $info = Session::get('booking_info');

        if (($data = $this->manager->check($startData, $endDate, $accommodations)) === false) {
            return view('booking.booking5')->with([
                'background' => $this->background(),
                'success' => false,
                'message' => trans('www.booking.error.rooms')
            ]);
        }
        $price = $data['price'];
        $accommodations = $data['accommodations'];
        $order = $this->manager->ameriaOrder($startData, $endDate, $accommodations, $price, $info);

        $conf = config('ameria');
        $cLng = cLng();

        $client = new SoapClient($conf['soap_url_1'], $conf['soap_options']);

        $params = [];
        $params['paymentfields']['ClientID'] = $conf['client_id'];
        $params['paymentfields']['Username'] = $conf['username'];
        $params['paymentfields']['Password'] = $conf['password'];
        $params['paymentfields']['OrderID'] = $order->order_id;
        $params['paymentfields']['PaymentAmount'] = 10; // TODO change to $price
        $params['paymentfields']['Description'] = 'Reserve accommodations';
        $params['paymentfields']['backURL'] = route('booking_ameria_back', $cLng->code);
        $params['paymentfields']['Opaque '] = '';

        $webService = $client->GetPaymentID($params);

        if ($webService->GetPaymentIDResult->Respcode == '1' && $webService->GetPaymentIDResult->Respmessage == 'OK') {

            $paymentId = $webService->GetPaymentIDResult->PaymentID;

            $order->payment_id = $paymentId;
            $order->save();

            $clientUrl = $request->url();
            $cLngCode = $cLng->code == 'hy' ? 'am' : $cLng->code;
            $url = $conf['form_url'].'?clientid='.$conf['client_id'].'&clienturl='.$clientUrl.'&lang='.$cLngCode.'&paymentid='.$paymentId;

            header('Location: '.$url);
            exit();

        } else {
            return $this->error('01');
        }
    }

    public function ameriaBack(Request $request)
    {
        if (!$request->isMethod('post') || Session::get('booking4') == null) {
            if (Session::get('booking4') != null) {
                return redirect()->route('booking4', cLng('code'));
            } else if (Session::get('booking3') != null) {
                return redirect()->route('booking3', cLng('code'));
            } else if (Session::get('booking2') != null) {
                return redirect()->route('booking2', cLng('code'));
            } else {
                return redirect()->route('booking1', cLng('code'));
            }
        }
        Session::forget('booking4');
        Session::forget('booking3');

        $conf = config('ameria');

        $orderId = $request->input('orderID');
        $paymentId = $request->input('paymentid');

        $order = Order::where('order_id', $orderId)->where('payment_id', $paymentId)->firstOrFail();

        $client = new SoapClient($conf['soap_url_2'], $conf['soap_options']);

        $params['paymentfields']['ClientID'] = $conf['client_id'];
        $params['paymentfields']['Description'] = 'Reserve accommodations';
        $params['paymentfields'] ['OrderID'] = $orderId;
        $params['paymentfields'] ['Password'] = $conf['password'];
        $params['paymentfields'] ['PaymentAmount'] = 10; // TODO change to $order->price
        $params['paymentfields'] ['Username'] = $conf['username'];

        $webService = $client->GetPaymentFields($params);

        if ($webService->GetPaymentFieldsResult->respcode != '00') {
            return $this->error($webService->GetPaymentFieldsResult->respcode);
        }
        if ($webService->GetPaymentFieldsResult ->paymenttype == '1') {
            $webService1 = $client->Confirmation($params);
            if ($webService1->ConfirmationResult->Respcode != '00') {
                return $this->error($webService1->ConfirmationResult->Respcode);
            }
        }
        $order->status = Order::STATUS_PAYED;
        $order->save();
        $this->manager->reserve(Reserved::TYPE_AMERIA, $order->date_from, $order->date_to, json_decode($order->accommodations, true));
        return view('booking.booking5')->with([
            'background' => $this->background(),
            'success' => true,
            'ameria' => true,
            'paymentId' => $paymentId,
            'message' => trans('www.booking.ameria.success')
        ]);
    }

    protected function error($statusCode)
    {
        $message = trans('www.booking.error.01');
        if ($statusCode == '02') {
            $message = trans('www.booking.error.02');
        } else if ($statusCode == '03') {
            $message = trans('www.booking.error.03');
        } else if ($statusCode == '04') {
            $message = trans('www.booking.error.04');
        } else if ($statusCode == '05') {
            $message = trans('www.booking.error.05');
        } else if ($statusCode == '06') {
            $message = trans('www.booking.error.06');
        } else if ($statusCode == '07') {
            $message = trans('www.booking.error.07');
        } else if ($statusCode == '08') {
            $message = trans('www.booking.error.08');
        } else if ($statusCode == '10') {
            $message = trans('www.booking.error.10');
        } else if ($statusCode == '11') {
            $message = trans('www.booking.error.11');
        } else if ($statusCode == '12' || $statusCode == '13') {
            $message = trans('www.booking.error.12');
        }
        return view('booking.booking5')->with([
            'background' => $this->background(),
            'success' => false,
            'message' => $message
        ]);
    }
}