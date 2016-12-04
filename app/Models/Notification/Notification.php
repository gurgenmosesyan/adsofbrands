<?php

namespace App\Models\Notification;

use App\Email\EmailManager;

class Notification
{
    public function send($url, $typeTitle)
    {
        $emails = trans('admin.notification.emails');
        $emails = explode(',', $emails);

        $emailManager = new EmailManager();

        foreach ($emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                $emailManager->storeEmail([
                    'to' => $email,
                    'subject' => trans('admin.notification.email.subject', ['type_title' => $typeTitle]),
                    'body' => '<a href="'.$url.'">'.$url.'</a>'
                ]);
            }
        }
    }
}