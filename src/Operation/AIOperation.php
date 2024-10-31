<?php

namespace App\Operation;

use App\Api\Cache\Cache;
use GeminiAPI\Client;
use GeminiAPI\Enums\Role;
use GeminiAPI\Resources\Content;
use GeminiAPI\Resources\Parts\TextPart;

class AIOperation
{
    public function chatBot($message)
    {
        $history = [
            Content::text(text: 'Benim adım Arda ve 19 yaşındayım', Role::User),
        ];

        $client = new Client('AIzaSyDnOmMDXtyu4QjHjgCIma5SExLomyklrfE');
        $chat = $client->geminiPro()->startChat()->withHistory($history);
        $result = $this->sendMessage($message, $history, $chat);
        return $result;
    }

    public function sendMessage($message, $history, $chat)
    {
        $history[] = Content::text($message["message"], role: Role::User);

        $response = $chat->withHistory($history)->sendMessage(new TextPart($message["message"]));

        $history[] = Content::text($response->text(), Role::Model);

        return $response->text();
    }

    public function history() {}
}
