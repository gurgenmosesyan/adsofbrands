<?php

namespace App\Email;

use App\Core\Model;

class Email extends Model
{
	const STATUS_PENDING = 'pending';
	const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';

	protected $table = 'emails';

	protected $fillable = [
		'to',
		'to_name',
		'from',
		'from_name',
		'reply_to',
		'subject',
		'body',
		'status'
	];
}