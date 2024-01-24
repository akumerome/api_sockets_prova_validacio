<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QRCode;

class MailController extends Controller
{
    public function sendMail($receiver) {
        Mail::to($receiver)->send(new QRCode());
    }
}
