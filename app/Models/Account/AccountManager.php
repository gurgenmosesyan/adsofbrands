<?php

namespace App\Models\Account;

use App\Email\EmailManager;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Creative\Creative;
use Auth;
use DB;

class AccountManager
{
    public function generateRandomUniqueHash($count = 40)
    {
        $hash = str_random($count);
        $creative = Creative::where('hash', $hash)->first();
        $brand = Brand::where('hash', $hash)->first();
        $agency = Agency::where('hash', $hash)->first();
        if ($creative == null && $brand == null && $agency == null) {
            return $hash;
        }
        return $this->generateRandomUniqueHash();
    }

    public function register($data)
    {
        if ($data['type'] == Account::TYPE_CREATIVE) {
            $user = new Creative();
            $user->type = Creative::TYPE_PERSONAL;
            $user->type_id = 0;
        } else if ($data['type'] == Account::TYPE_BRAND) {
            $user = new Brand();
        } else {
            $user = new Agency();
        }
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->hash = self::generateRandomUniqueHash();
        $user->reg_type = Account::REG_TYPE_REGISTERED;
        $user->status = Account::STATUS_PENDING;
        $user->active = Account::NOT_ACTIVE;
        $user->save();

        DB::transaction(function() use($user) {
            $user->save();

            $link = url_with_lng('/activation/'.$user->hash);
            $body = trans('www.account.email.confirm.text', ['link' => '<a href="'.$link.'">'.$link.'</a>']);
            $emailManager = new EmailManager();
            $emailManager->storeEmail([
                'to' => $user->email,
                'to_name' => '',
                'subject' => trans('www.account.email.confirm.subject'),
                'body' => $body
            ]);
        });
    }

    public function forgot($data, $brand, $agency, $creative)
    {
        if ($brand) {
            $user = Brand::where('email', $data['email'])->firstOrFail();
        } else if ($agency) {
            $user = Agency::where('email', $data['email'])->firstOrFail();
        } else {
            $user = Creative::where('email', $data['email'])->firstOrFail();
        }

        $link = url_with_lng('/reset/'.$user->hash);
        $body = trans('www.email.reset.text', ['link' => '<a href="'.$link.'">'.$link.'</a>']);

        $emailManager = new EmailManager();
        $emailManager->storeEmail([
            'to' => $user->email,
            'to_name' => '',
            'subject' => trans('www.email.reset.subject'),
            'body' => $body
        ]);
    }

    public function reset($data)
    {
        $user = Brand::where('hash', $data['hash'])->first();
        if ($user == null) {
            $user = Agency::where('hash', $data['hash'])->first();
            if ($user == null) {
                $user = Creative::where('hash', $data['hash'])->first();
                if ($user == null) {
                    abort(404);
                }
            }
        }
        $user->password = bcrypt($data['password']);
        $user->hash = $this->generateRandomUniqueHash();
        $user->save();
    }

    public function resetAfterDay()
    {
        $threeDay = date('Y-m-d H:i:s', time() - 86400*2);

        Brand::active()->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->where('created_at', '<', $threeDay)->delete();
        Agency::active()->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->where('created_at', '<', $threeDay)->delete();
        Creative::active()->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->where('created_at', '<', $threeDay)->delete();
    }
}