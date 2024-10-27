<?php

namespace App\Operation;

use App\Api\Cache\Cache;

class AIOperation
{
    private $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyDJwdS9G-dlzrtASyDnZpxRAAQXnlTM4Nc';
    private $cache;
    private $conversationHistory = []; // Konuşma geçmişi

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function ai_request($dataArray)
    {
        $data = json_encode($dataArray);
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return ['error' => curl_error($ch)];
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    public function chatBot($message)
    {
        // Önceki konuşmaları ekle
        $this->addToConversationHistory($message["message"]);

        // Önbellek anahtarını oluştur
        $cacheKey = md5($message["message"]);

        // Önbellekten veriyi kontrol et
        if ($this->cache->has($cacheKey)) {
            return htmlspecialchars($this->cache->get($cacheKey));
        }

        // Konuşma geçmişini kullanarak API'ye bağlan
        $prompt = $this->promptQuery();

        if (isset($prompt['candidates'][0]['content']['parts'][0]['text'])) {
            $responseText = htmlspecialchars($prompt['candidates'][0]['content']['parts'][0]['text']);
            // Cevabı önbelleğe kaydet
            $this->cache->set($cacheKey, $responseText);
            return $responseText;
        }

        return "Yanıt bulunamadı.";
    }

    public function promptQuery()
    {
        // API isteği için bağlamı oluştur
        $context = $this->getConversationContext();

        // API isteği için veriyi hazırla
        $dataArray = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array(
                            'text' => $context // Tüm geçmişi buraya ekle
                        )
                    )
                )
            )
        );

        return $this->ai_request($dataArray);
    }

    private function addToConversationHistory($message)
    {
        // Mesajı konuşma geçmişine ekle
        $this->conversationHistory[] = $message;

        // Geçmiş 10 mesajdan fazlaysa en eskisini sil
        if (count($this->conversationHistory) > 10) {
            array_shift($this->conversationHistory);
        }
    }

    private function getConversationContext()
    {
        // Geçmişi bağlam olarak döndür
        return implode(" ", $this->conversationHistory);
    }
}
