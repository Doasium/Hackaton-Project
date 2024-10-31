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
        $cache = new Cache("ai_");
        $cache_key = "chat"; // Anahtar ismi düzeltildi
        // Geçmişi almak için cache kontrolü
        if ($cache->has($cache_key)) {
            $history = $cache->get($cache_key);
        } else {
            // Eğer geçmiş yoksa, başlangıç mesajını ekle
            $history = [
                Content::text('Benim adım Arda ve 19 yaşındayım', Role::User),
            ];
        }

        // Gelen mesajın bir string olduğundan emin olalım
        if (!empty($message) && is_string($message)) {
            // Mesajı geçmişe ekliyoruz
            $history[] = Content::text($message, Role::User);
        }

        // API client'i tanımlıyoruz
        $client = new Client('AIzaSyDnOmMDXtyu4QjHjgCIma5SExLomyklrfE');
        $chat = $client->geminiPro15()->startChat()->withHistory($history);

        // Mesaj gönderiyoruz ve yanıtı alıyoruz
        $result = $this->sendMessage($message, $history, $chat);

        // Geçmişi cache'e kaydediyoruz
        $cache->set($cache_key, $history);

        return $result;
    }

    public function sendMessage($message, $history, $chat)
    {
        // Mesajı gönderiyoruz
        $response = $chat->withHistory($history)->sendMessage(new TextPart($message));

        // Yanıtı geçmişe ekliyoruz
        $history[] = Content::text($response->text(), Role::Model);

        return $response->text();
    }

    public function history() {}
}
