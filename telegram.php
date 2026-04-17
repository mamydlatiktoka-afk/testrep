<?php
    function sendMessage($chat_id, $text) {
        $url = "https://api.telegram.org/bot" . 8717098765:AAG0Wi0VSk3Fm1pi8xPz2018SXbx_hIH87M
 . "/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        return makeRequest($url, $data);
    }

    function makeRequest($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
