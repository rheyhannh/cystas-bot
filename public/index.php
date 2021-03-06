<?php
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
 
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use \LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use \LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use \LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use \LINE\LINEBot\SignatureValidator as SignatureValidator;
 
$pass_signature = true;
 
// Konfigurasi channel_secret dan channel_access_token LINE Bot
$channel_access_token = "Wt4cuAWFeOO1oFPN4sZh1iXzqbwHRNOhrBP+fPoy6Bgwi7Nc3xP/MlS7s1qtVPt5NnUr0Qu3jB2oLkRy3fTRfcI80Dlc0IvSkIad3UrymH7REJUzVAqh1VGpBeGIwHvk62FrHb7/DoQtI7g9t4aGnAdB04t89/1O/w1cDnyilFU=";
$channel_secret = "045e3bcfb30722e5f8b03800cbe4f589";
 
// Inisialisasi Objek Bot
$httpClient = new CurlHTTPClient($channel_access_token);
$bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
 
$app = AppFactory::create();
$app->setBasePath("/public");
 
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello World!");
    return $response;
});
 
// Route untuk Webhook
$app->post('/webhook', function (Request $request, Response $response) use ($channel_secret, $bot, $httpClient, $pass_signature) {
    // get request body dan line signature header
    $body = $request->getBody();
    $signature = $request->getHeaderLine('HTTP_X_LINE_SIGNATURE');

    // log body and signature
    file_put_contents('php://stderr', 'Body: ' . $body);
  
    if ($pass_signature === false) {
        // is LINE_SIGNATURE exists in request header?
        if (empty($signature)) {
            return $response->withStatus(400, 'Signature not set');
        }
        // is this request comes from LINE?
        if (!SignatureValidator::validateSignature($body, $channel_secret, $signature)) {
            return $response->withStatus(400, 'Invalid signature');
        }
    }
 
    $data = json_decode($body, true);
    if(is_array($data['events'])){
        foreach ($data['events'] as $event)
        {
            if ($event['type'] == 'message')
            {
                if($event['message']['type'] == 'text')
                {
                    if(strstr($event['message']['text'], '!md5')){
                        // Fitur Enkripsi md5
                        $katamd5 = $event['message']['text'];
                        $pisahmd5 = substr($katamd5, strpos($katamd5, "_") + 1);
                        $fixmd5 = md5($pisahmd5);
                        $textMessageBuilder1 = new TextMessageBuilder('[MD5 Encryptor]' . PHP_EOL . "String : {$pisahmd5}" . PHP_EOL . "MD5 : {$fixmd5}"); // pesan hasil
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strstr($event['message']['text'], '!sha1')){
                        // Fitur Enkripsi sha1
                        $katasha1 = $event['message']['text'];
                        $pisahsha1 = substr($katasha1, strpos($katasha1, "_") + 1);
                        $fixsha1 = sha1($pisahsha1);
                        $textMessageBuilder1 = new TextMessageBuilder('[SHA1 Encryptor]' . PHP_EOL . "String : {$pisahsha1}" . PHP_EOL . "SHA1 : {$fixsha1}"); // pesan hasil
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strstr($event['message']['text'], '!ripemd128')){
                        // Fitur Enkripsi ripemd128
                        $kataripemd128 = $event['message']['text'];
                        $pisahripemd128 = substr($kataripemd128, strpos($kataripemd128, "_") + 1);
                        $fixripemd128 = hash('ripemd128', $pisahripemd128);
                        $textMessageBuilder1 = new TextMessageBuilder('[RIPEMD128 Encryptor]' . PHP_EOL . "String : {$pisahripemd128}" . PHP_EOL . "RIPEMD128 : {$fixripemd128}"); // pesan hasil
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strstr($event['message']['text'], '!gost')){
                        // Fitur Enkripsi gost
                        $katagost = $event['message']['text'];
                        $pisahgost = substr($katagost, strpos($katagost, "_") + 1);
                        $fixgost = hash('gost', $pisahgost);
                        $textMessageBuilder1 = new TextMessageBuilder('[GOST Encryptor]' . PHP_EOL . "String : {$pisahgost}" . PHP_EOL . "GOST : {$fixgost}"); // pesan hasil
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strstr($event['message']['text'], '!fnv132')){
                        // Fitur Enkripsi fnv132
                        $katafnv132 = $event['message']['text'];
                        $pisahfnv132 = substr($katafnv132, strpos($katafnv132, "_") + 1);
                        $fixfnv132 = hash('fnv132', $pisahfnv132);
                        $textMessageBuilder1 = new TextMessageBuilder('[FNV132 Encryptor]' . PHP_EOL . "String : {$pisahfnv132}" . PHP_EOL . "FNV132 : {$fixfnv132}"); // pesan hasil
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }  
                    else if(strtolower($event['message']['text']) == '!perintah'){
                        // Penjelasan Perintah
                        $textMessageBuilder1 = new TextMessageBuilder("Berikut ini adalah perintah beserta fungsinya yang dapat aku mengerti : " . PHP_EOL . PHP_EOL . "!info : Menampilkan Info Bot" . PHP_EOL . "!perintah : Menampilkan Perintah" . PHP_EOL . "!md5_Teks : Fitur Enkripsi MD5" . PHP_EOL . "!sha1_Teks : Fitur Enkripsi SHA1" . PHP_EOL . "!ripemd128_Teks : Fitur Enkripsi RIPEMD128" . PHP_EOL . "!gost_Teks : Fitur Enkripsi GOST" . PHP_EOL . "!fnv132_Teks : Fitur Enkripsi FNV132" . PHP_EOL . "!contoh : Menampilkan Contoh Detail" . PHP_EOL . "!card : Menampilkan Pesan dari Kreator" . PHP_EOL . PHP_EOL . "Perlu diingat perintah dimasukkan dengan huruf kecil ya !. Semoga kamu terbantu dengan adanya aku."); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 106); // pesan sticker
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strtolower($event['message']['text']) == '!contoh'){
                        // Contoh Fitur
                        $textMessageBuilder1 = new TextMessageBuilder("Kamu hanya perlu memilih Enkripsi yang ingin digunakan dan memasukkan Kata atau Kalimat yang ingin diEnkripsi. Misalnya, kamu ingin menggunakan Enkripsi MD5. Kamu bisa menggunakan perintah !md5_Teks dimana Teks dapat diganti dengan Kata atau Kalimat yang ingin diEnkripsi. Pastikan kamu memasukkan perintah terlebih dahulu dan diikuti Kata atau Kalimat yang ingin diEnkripsi setelah simbol garis bawah ya !" . PHP_EOL . PHP_EOL . "Contoh : !md5_Enkripsi Aku"); // pesan 1
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if(strtolower($event['message']['text']) == '!info'){
                        // Info Bot
                        $stickerMessageBuilder = new StickerMessageBuilder(2, 34); // pesan sticker
                        $textMessageBuilder1 = new TextMessageBuilder("Halo ! Perkenalkan, aku Cystas. " . PHP_EOL . PHP_EOL . "Aku adalah Bot yang berfungsi untuk melakukan Enkripsi pada suatu Teks. Enkripsi yang aku lakukan adalah dengan Hashing. Ada beberapa teknik Hashing yang aku gunakan antara lain MD5, SHA1, GOST dan lainnya." . PHP_EOL . PHP_EOL . "Kamu dapat langsung menggunakan fitur yang aku sediakan dengan mengetik '!perintah' untuk melihat fitur yang aku sediakan. Semoga aku dapat membantu kamu hihihi."); // pesan 1
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }               
                    else if(strtolower($event['message']['text']) == '!card') {
                        $flexTemplate = file_get_contents("../flex_message.json"); // template flex message
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Pesan dari Kreator',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
                    else{
                        // Fitur yang Tidak Ada
                        $textMessageBuilder1 = new TextMessageBuilder("Aduh maaf aku belum bisa mengerti perintah yang kamu kirimkan " . "'" . $event['message']['text'] . "'." . PHP_EOL . PHP_EOL . "Tapi kamu bisa mengetik '!perintah' untuk melihat perintah yang aku mengerti."); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 10); // pesan sticker
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);

                    }

                    $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->getHTTPStatus());
                }
                // API untuk Chat Group atau Room
                elseif (
                    $event['source']['type'] == 'group' or
                    $event['source']['type'] == 'room'
                ) {
                    // Pesan dari Group atau Room
                    if ($event['source']['userId']) {
                        $userId = $event['source']['userId'];
                        $getprofile = $bot->getProfile($userId);
                        $profile = $getprofile->getJSONDecodedBody();
                        $greetings = new TextMessageBuilder("Halo, " . $profile['displayName']);
                 
                        $result = $bot->replyMessage($event['replyToken'], $greetings);
                        $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
                        return $response
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus($result->getHTTPStatus());
                    }
                } else {
                    // Pesan dari Single User
                    $result = $bot->replyText($event['replyToken'], $event['message']['text']);
                    $response->getBody()->write((string)$result->getJSONDecodedBody());
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->getHTTPStatus());
                }
            }
        }
        return $response->withStatus(200, 'for Webhook!'); // Memberikan response 200 ke pas verify Webhook
    }
    return $response->withStatus(400, 'No event sent!');
});

$app->run();