<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $channelAccessToken = 'iq8N9ij+VNtbuHaAEByCJAbaynlLVC4f+Ch2gv8lGqzawsMxAz6s+feblUG5CBhCC8R8iaoFLxk62jRgtitWEntQFurS4Nr2C0jBWRFUUEX6pbIYKsP5wcNEDN0RPM3z2k+iiRXNFSzj7f+mDJW5rgdB04t89/1O/w1cDnyilFU=';
    
    public function sendNewProductInfomation(){
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $this->channelAccessToken,
        ];
        $textData = [
            'messages' => [
                [
                    'type' => 'text',
                    'text' => "新商品\n名稱:".$this->post['data']['name']."\n價格:".$this->post['data']['price']."元",
                ]
            ]
        ];
        $templateData = [
            'messages' => [
                [
                    'type' => 'template', //訊息類型 (模板)
                    'altText' => '新商品通知',
                    'template' => [
                        'type' => 'buttons', //類型 (按鈕)
                        'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', //圖片網址 <不一定需要>
                        'title' => '新商品', //標題 <不一定需要>
                        'text' => "名稱:".$this->post['data']['name']."\n價格:".$this->post['data']['price']."元", //文字
                        'actions' => [
                            [
                                'type' => 'uri', //類型 (連結)
                                'label' => '前往', //標籤 3
                                'uri' => 'http://localhost:8000/' //連結網址
                            ],

                        ]
                    ]
                ]
            ]
        ];
        $client->post('https://api.line.me/v2/bot/message/broadcast', [
            'headers' => $headers,
            'json' => $templateData
        ]);
    }

    public function TestMessage(){
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $this->channelAccessToken,
        ];
        $data = [
            'messages' => [
                [
                    'type' => 'template', //訊息類型 (模板)
                    'altText' => 'Example buttons template',
                    'template' => [
                        'type' => 'buttons', //類型 (按鈕)
                        'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', //圖片網址 <不一定需要>
                        'title' => '新商品', //標題 <不一定需要>
                        'text' => "新商品\n名稱:".$this->post['data']['name']."\n價格:".$this->post['data']['price']."元", //文字
                        'actions' => [
                            // [
                            //     'type' => 'postback', //類型 (回傳)
                            //     'label' => 'Postback example', //標籤 1
                            //     'data' => 'action=buy&itemid=123'
                            // ],
                            // [
                            //     'type' => 'message', //類型 (訊息)
                            //     'label' => 'Message example', //標籤 2
                            //     'text' => 'Message example' 
                            // ],
                            [
                                'type' => 'uri', //類型 (連結)
                                'label' => 'Uri example', //標籤 3
                                'uri' => 'http://localhost:8000/' //連結網址
                            ],

                        ]
                    ]
                ]
            ]
        ];
        $client->post('https://api.line.me/v2/bot/message/broadcast', [
            'headers' => $headers,
            'json' => $data
        ]);
    }

    public function productDeliveryInformation($userIds = [], $message){
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $this->channelAccessToken,
        ];

        $payload = [
            'to' => $userIds,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message
                ]
            ]
        ];

        $client->post('https://api.line.me/v2/bot/message/multicast', [
            'headers' => $headers,
            'json' => $payload
        ]);
    }
}
