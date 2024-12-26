<?php 

namespace App\Services;


class TextService {

    public function send($recipient, $message)
    {   
        $ch = curl_init();
        $parameters = array(
            'apikey' => config('app.sms_api_key'), 
            'number' => $recipient,
            'message' => $message,
            'sendername' => 'THESIS'
        );

        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        return $output;

    }
}