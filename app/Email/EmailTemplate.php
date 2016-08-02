<?php

namespace App\Email;

use Helix\Core\Model;

class EmailTemplate extends Model
{
	const MEMBER_CONFIRM = 'member_confirm';
	const ADMIN_NOTIFICATION = 'admin_notification';
	const MEMBER_DEACTIVATE = 'member_deactivate';
	const ADMIN_DEACTIVATE = 'admin_deactivate';
	const MEMBER_RESET = 'member_reset';

	protected $table = 'email_templates';
}