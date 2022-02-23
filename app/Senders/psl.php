<?php

namespace App\Senders;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class psl
{

    public static function sendMessage($messageData)
    {
        $getwayDetails = DB::table('sms_gateways')->where(['sg_name' => 'psl', 'sg_status' => 1])->first();
        if (empty($getwayDetails)) {
            return 'Gateway Not Available';
        }
        $mainArray = array();
        $numbers = "";
        $success_count = 0;

        $numbers = $messageData['recipient'];

        $add_urlsData = "?username=" . $getwayDetails->sg_user . "&password=" . $getwayDetails->sg_password . "&recipient=" . $numbers . "&from=" . $messageData['from'] . "&message=" . urlencode($messageData['message']);
        $url = $getwayDetails->sg_access_url . $add_urlsData;

        DB::table('url_test')->insert([
            'url'=>$url
        ]);

        $response = Http::withoutVerifying()->get($url);
        $response = json_decode($response->body(), true);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, TRUE);
        // curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // $response = curl_exec($ch);
        // $errors = curl_error($ch);
        // curl_close($ch);

        
    }
}
