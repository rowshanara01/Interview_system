<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;

class MailController extends Controller
{
    public function sendEmail()
    {
        $to = "imalbab4@gmail.com";
        $subject = "Test Email";
        $body = "This is a test email";
        $massage = "This is a test email";

        SendMailJob::dispatch($to, $massage, $subject, $body);

       return "Email sent successfully";

    }
}
