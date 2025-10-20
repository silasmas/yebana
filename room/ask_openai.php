<?php
// ask_openai.php

$data = json_decode(file_get_contents("php://input"), true);
$prompt = $data['prompt'];

$api_key = "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";

$postData = [
    "model" => "gpt-4.1-mini",
    "messages" => [
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.5
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);

$response = curl_exec($ch);
curl_close($ch);

$res = json_decode($response, true);
$answer = $res['choices'][0]['message']['content'] ?? "Pas de réponse";

echo json_encode(["answer" => $answer]);
?>
