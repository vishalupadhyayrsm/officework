<?php

function callChatGPT($apiKey, $prompt)
{
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = [
        'model' => 'gpt-4', // or 'gpt-3.5-turbo'
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $prompt],
        ],
        'max_tokens' => 150,
    ];

    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return 'Error: ' . $error_msg;
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['choices'][0]['message']['content'];
}

// Usage
$apiKey = 'sk-proj-SFfcEheRhG5M92UDPAQdT3BlbkFJHs1rPv32VdzYax3GOw09';
$prompt = 'Tell me baout javascrip';
$response = callChatGPT($apiKey, $prompt);

echo $response;
