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
        for ($i = 0; $i < count($messageData['recipient']); $i++) {

            $numbers = $messageData['recipient'][$i];

            $add_urlsData = "?username=" . $getwayDetails->sg_user . "&password=" . $getwayDetails->sg_password . "&recipient=" . $numbers . "&from=" . $messageData['from'] . "&message=" . urlencode($messageData['message']);
            $url = $getwayDetails->sg_access_url . $add_urlsData;

            $response = Http::get($url);
            $response = json_decode($response->body(), true);

            if ($response['status'] == 'success') {
                $success_count += 1;
                $deliveryStatus['number'] = $numbers;
                $deliveryStatus['status'] = 'delivered';
                array_push($mainArray, $deliveryStatus);
            } elseif ($response['status'] == false) {
                $deliveryStatus['number'] = $numbers;
                $deliveryStatus['status'] = 'rejected';
                array_push($mainArray, $deliveryStatus);
            }
        }

        DB::table('message_log')->insert([
            'msgl_message' => $messageData['message'],
            'msgl_number' => json_encode($mainArray),
            'msgl_date_time' => date('Y-m-d H:i:s'),
            'user_id' =>$messageData['user_id'],
            'reseller_id' =>$messageData['reseller_id'],
            'sms_gateways'=>'psl',
        ]);


        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, TRUE);
        // curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // $response = curl_exec($ch);
        // $errors = curl_error($ch);
        // curl_close($ch);

        $responseArray = array();
        if ($success_count > 0) {
            $responseArray['status'] = true;
        } else {
            $responseArray['status'] = false;
        }

        return $responseArray;
    }
}
