<?php

namespace App\Jobs;

use App\Email\Email;
use App\Email\EmailManager;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $email;
    private $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Email $email, $template)
    {
        $this->email = $email;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailManager $emailSender)
    {
        $emailSender->sendEmail($this->email, $this->template);
    }
}
