<?php
    function askDeepSeek($prompt) {
        $url = "https://api.deepseek.com/v1/chat/completions";

        $data = [
            'model' => 'deepseek-chat',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => 500,
            'temperature' => 0.7
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . DEEPSEEK_KEY
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $result = json_decode($response, true);
            return $result['choices'][0]['message']['content'] ?? null;
        }

        error_log("DeepSeek API ошибка: HTTP {$http_code} - {$response}");
        return null;
    }
