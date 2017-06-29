<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/*
 * Author : Viran
 * 
 * */

class Sms_handler {

    public function __construct() {
        // Do something with $params
    }

    public function sendSMS($mob, $msg) {

        $msg = str_replace("\n", "%0A", $msg); //this is to add line breaks
        $msg = str_replace(" ", "%20", $msg); //this is to add spaces



        $ch = curl_init();

        // set URL and other appropriate options
        //  curl_setopt($ch, CURLOPT_URL, "http://smsgw.lankacom.net/send.php?to=0716388833&msg=test");

        curl_setopt($ch, CURLOPT_URL, "http://smsgw.lankacom.net/send.php?to=0717153716" . $mob . "&msg=test" . $msg);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // grab URL and pass it to the browser
        curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
        //echo 1;
    }

}

?>