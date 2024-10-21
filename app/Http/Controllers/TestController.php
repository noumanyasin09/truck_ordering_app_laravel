<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sendpusher(){
        event(new SendNotification('hello world','my-channel','my-event'));
    }
}
