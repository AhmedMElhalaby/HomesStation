<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    private $username;
    private $password;
    private $sender_name;

    public function __construct()
    {
        // $this->username = '20092157';
        // $this->sender_name = 'HStation';
        // $this->password = 'gpkxk4';

        $this->username = '20093502';
        $this->sender_name = 'Hstation';
        $this->password = '@Naif0503103307';
    }

    public function send_sms($numbers, $message)
    {
        $date = date('Y-m-d');
        $time = date("H:i");
        $url = "http://mshastra.com/sendurlcomma.aspx?user=" . $this->username . "&pwd=" . $this->password . "&senderid=" . $this->sender_name . "&mobileno=" . $numbers . "&msgtext=" . $message . "&priority=High&CountryCode=966";
        // dd($url);
        // $request_code = (integer)file_get_contents($url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
    }
}
