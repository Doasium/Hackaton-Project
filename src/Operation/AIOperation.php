<?php

namespace App\Operation;

use App\Api\Cache\Cache;
use App\Controllers\UserController;
use App\Models\LeassonModel;
use App\Models\UserModel;
use GeminiAPI\Client;
use GeminiAPI\Enums\Role;
use GeminiAPI\Resources\Content;
use GeminiAPI\Resources\Parts\TextPart;
use RuntimeException;

class AIOperation
{
    public function chatBot($message)
    {
        $userController = new UserController();

        if ($userController->getLogged()) {


            $cache = new Cache("ai_");
            $cache_key = "chat";

            if ($cache->has($cache_key)) {
                $history = $cache->get($cache_key);
            } else {
                $history = [
                    Content::text('Benim adım Arda ve 19 yaşındayım', Role::User),
                ];
            }

            if (!empty($message) && is_string($message)) {
                $history[] = Content::text($message, Role::User);
            }

            $client = new Client('AIzaSyDnOmMDXtyu4QjHjgCIma5SExLomyklrfE');
            $chat = $client->geminiPro15()->startChat()->withHistory($history);

            $result = $this->sendMessage($message, $history, $chat);

            $cache->set($cache_key, $history);
            return $result;
        } else {
            return ["message" => "Giriş yapınız."];
        }
    }

    public function sendMessage($message, $history, $chat)
    {
        try {
            $response = $chat->withHistory($history)->sendMessage(new TextPart($message));
            $history[] = Content::text($response->text(), Role::Model);
            return $response->text() ?: "Bir hata oluştu.";
        } catch (RuntimeException $e) {
            if ($e->getCode() === 429) {
                return $this->sendMessage($message, $history, $chat); // Yeniden dene
            }
            return "Bir hata oluştu biraz sonra tekrar deneyiniz.";
        }
    }

    public function codeAnaliz($code, $quest_id)
    {
        $userController = new UserController();
        $leassonModel = new LeassonModel();
        if ($userController->getLogged()) {
            if ($quest = $leassonModel->getQuest($quest_id)) {
                $client = new Client('AIzaSyDJwdS9G-dlzrtASyDnZpxRAAQXnlTM4Nc');
                $chat = $client->geminiPro15()->startChat();

                $goal = $quest["q_quest"];
                $response = $chat->sendMessage(
                    new TextPart("Aşağıdaki " . $quest["q_language"] . " kodunu analiz et ve başarı oranını % olarak belirt: \n\n" . $code . "\n kodun amacı şu:" . $goal . "\n çok kısa bir şekilde geri dönütler sağla sadece başarı oranı ve şunu yapsaydın daha iyi olabilirdi gibi. ve asla kod örneği verme. eğer ki çok düşük bir yüzdelik başarısı varsa yorum yapma sadece yüzdeliğini söyle. Eğer " . $code . " bu kod istenileni karşılamıyorsa yalnızca %lik olarak başarısını ver istenilen ise şu: " . $goal . "Biraz dostani cevaplar ver emoji kullan eğer başardıysa sevinçli bir şekilde cevap ver. Kodun sonucu " . $goal . " la aynı olması gerekli yüzdeliği buna göre ver bir birinden farklı bir kod verdiğimde saçma bir yüzdelik verme.")
                );

                $analysisResult = $response->text();

                if ($analysisResult) {
                    return [
                        'analysis' => $analysisResult,
                    ];
                } else {
                    return [
                        'analysis' => "Bir hata oluştu tekrardan deneyiniz."
                    ];
                }
            } else {
                return [
                    'analysis' => "Böyle bir soru yok"
                ];
            }
        } else {
            return ['analysis' => 'Giriş yapmanız gerekli.'];
        }
    }

    public function history() {}
}
