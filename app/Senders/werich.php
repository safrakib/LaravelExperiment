<?php

namespace App\Senders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class werich
{

    public static function sendMessage($messageData)
    {
        $getwayDetails = DB::table('sms_gateways')->where(['sg_name' => 'werich', 'sg_status' => 1])->first();
        if (empty($getwayDetails)) {
            return 'Gateway Not Available';
        }

        $numbers = "";
        $success_count = 0;
        for ($i = 0; $i < count($messageData['recipient']); $i++) {
            
            if ($i == 0) {
                if (preg_match("/^8801(6|5|7|9|1)\d{8}$/", $messageData['recipient'][$i])) {
                    $numbers = $messageData['recipient'][$i];
                }else{
                    $numbers = '88'.$messageData['recipient'][$i];
                }
                
            } else {
                if (preg_match("/^8801(6|5|7|9|1)\d{8}$/", $messageData['recipient'][$i])) {
                    $numbers .= $messageData['recipient'][$i];
                }else{
                    $numbers .= '+' .'88'. $messageData['recipient'][$i];
                }
                
            }
        }

        $response = Http::post($getwayDetails->sg_access_url, [
            "api_key" => $getwayDetails->sg_apikey,
            "type" => "text",
            "contacts" => $numbers,
            "senderid" => $messageData['from'],
            "msg" => $messageData['message'],
        ]);

        $errorArray=array(1002=>1002,1003=>1003,1004=>1004,1005=>1005,1006=>1006,1007=>1007,1008=>1008,1009=>1009,1010=>1010,1011=>1011,1012=>1012,1013=>1013,1014=>1014,2001=>2001);

        $responseArray = array();
        if ($response->body()== @$errorArray[$response->body()]) {
            $responseArray['status'] = false;
        } else {
            $responseArray['status'] = true;
            DB::table('message_log')->insert([
                'msgl_message' => $messageData['message'],
                'msgl_number' => json_encode($numbers),
                'msgl_date_time' => date('Y-m-d H:i:s'),
                'user_id' => $messageData['user_id'],
                'reseller_id' => $messageData['reseller_id'],
                'sms_gateways' => 'psl',
            ]);
        }

        return $responseArray;
    }
}
