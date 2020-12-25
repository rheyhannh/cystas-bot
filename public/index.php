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
                    if($event['message']['text'] == 'yansFitur1'){
                        // Fitur 1
                        $textMessageBuilder1 = new TextMessageBuilder('Tungguin yaa masih proses :p #fitur1'); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 2); // pesan sticker

                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if($event['message']['text'] == 'yansFitur2'){
                        // Fitur 2
                        $textMessageBuilder1 = new TextMessageBuilder('Tungguin yaa masih proses :p #fitur2'); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 2); // pesan sticker

                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if($event['message']['text'] == 'yansFitur3'){
                        // Fitur 3
                        $textMessageBuilder1 = new TextMessageBuilder('Tungguin yaa masih proses :p #fitur3'); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 2); // pesan sticker

                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if($event['message']['text'] == 'yansFitur4'){
                        // Fitur 4
                        $textMessageBuilder1 = new TextMessageBuilder('Tungguin yaa masih proses :p #fitur4'); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 2); // pesan sticker

                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if($event['message']['text'] == 'yansFitur5'){
                        // Fitur 5
                        $textMessageBuilder1 = new TextMessageBuilder('Tungguin yaa masih proses :p #fitur5'); // pesan 1
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 2); // pesan sticker

                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);
                    }
                    else if (strtolower($event['message']['text']) == 'user id') {
                        // Fitur Untuk Mendapatkan userId
                        // $result = $bot->replyText($event['replyToken'], $event['source']['userId']);
                        $result = $bot->replyText($event['replyToken'], $event['source']['displayName']);
 
                    } 
                    else if (strtolower($event['message']['text']) == 'flex message') {
                        $flexTemplate = file_get_contents("../flex_message.json"); // template flex message
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Test Flex Message',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
                    else{
                        // Fitur yang Tidak Ada
                        $textMessageBuilder1 = new TextMessageBuilder('Kamu mengirim perintah : '.$event['message']['text']); // pesan 1
                        $textMessageBuilder2 = new TextMessageBuilder('Sayang banget perintah itu gaada...'); // pesan 2
                        $stickerMessageBuilder = new StickerMessageBuilder(1, 107); // pesan sticker
    
                        $multiMessageBuilder = new MultiMessageBuilder();
                        $multiMessageBuilder->add($textMessageBuilder1);
                        $multiMessageBuilder->add($textMessageBuilder2);
                        $multiMessageBuilder->add($stickerMessageBuilder);
                        $result = $bot->replyMessage($event['replyToken'], $multiMessageBuilder);

                    }
                    // Membalas dengan replyText
                    // $result = $bot->replyText($event['replyToken'], $event['message']['text']);
                    
                    // Membalas dengan replyMessage
                    // $textMessageBuilder = new TextMessageBuilder($event['message']['text']);
                    // $result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
 
                    $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->getHTTPStatus());
                }
                // API untuk Content Upload
                elseif (
                    $event['message']['type'] == 'image' or
                    $event['message']['type'] == 'video' or
                    $event['message']['type'] == 'audio' or
                    $event['message']['type'] == 'file'
                ) {
                    $contentURL = " https://hayyans-fans.herokuapp.com/public/content/" . $event['message']['id'];
                    $contentType = ucfirst($event['message']['type']);
                    $result = $bot->replyText($event['replyToken'],
                        $contentType . " yang Anda kirim bisa diakses dari link:\n " . $contentURL);
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

$app->get('/pushmessage', function ($req, $response) use ($bot) {
    // Mengirim pesan push ke User
    $userId = 'Ue39d0d7eba0ebf6b4115da5f0b2b1ed6';
    // Inisialisasi Objek untuk Pesan atau Sticker
    $textMessageBuilder = new TextMessageBuilder('Halo, ini pesan push');
    $stickerMessageBuilder = new StickerMessageBuilder(1, 106);
    $multiMessageBuilder = new MultiMessageBuilder();
    $multiMessageBuilder->add($textMessageBuilder);
    $multiMessageBuilder->add($stickerMessageBuilder);
    $result = $bot->pushMessage($userId, $multiMessageBuilder);
 
    $response->getBody()->write("Pesan push berhasil dikirim!");
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($result->getHTTPStatus());
});

$app->get('/multicast', function($req, $response) use ($bot)
{
    // List Users
    $userList = [
        'Ue39d0d7eba0ebf6b4115da5f0b2b1ed6'];
 
    // Mengirimkan pesan multicas ke user yang didaftarkan
    $textMessageBuilder = new TextMessageBuilder('Halo, ini pesan multicast');
    $result = $bot->multicast($userList, $textMessageBuilder);
 
    $response->getBody()->write("Pesan multicast berhasil dikirim");
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($result->getHTTPStatus());
});

$app->get('/profile', function ($req, $response) use ($bot)
{
    // Mendapatkan Profile User
    $userId = 'Ue39d0d7eba0ebf6b4115da5f0b2b1ed6';
    $result = $bot->getProfile($userId);
 
    $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($result->getHTTPStatus());
});

$app->get('/content/{messageId}', function ($req, $response, $args) use ($bot) {
    // Mendapatkan Konten Pesan
    $messageId = $args['messageId'];
    $result = $bot->getMessageContent($messageId);
    // Set response
    $response->getBody()->write($result->getRawBody());
    return $response
        ->withHeader('Content-Type', $result->getHeader('Content-Type'))
        ->withStatus($result->getHTTPStatus());
});

$app->run();