<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $headers;
    protected $client;
    protected $companyId;

    public function redirectFunction($function, $params = []){
        $query = DB::table('admin_member');
        if(null !== $this->companyId){
            $this->companyId = $this->request->session()->get('companyId');
            $query = $query->where('companyId', $this->companyId);
        }
        $data = $query->first();
        $accessToken = $data->accessToken;
        if(null === $this->companyId){
            $this->companyId = $data->companyId;
        }
        $this->headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $accessToken,
        ];
        $this->client = new \GuzzleHttp\Client();
        $this->$function($params);
    }
    
    private function sendNewProductInfomation($params){
        if(isset($this->post['data'])){
            extract($this->post['data']);
        }
        $templateData = [
            'messages' => [
                [
                    'type' => 'template', 
                    'altText' => '新商品通知',
                    'template' => [
                        'type' => 'buttons', 
                        'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', 
                        'title' => '新商品‼️強力推薦‼️', 
                        'text' => "名稱:".$name."\n價格:".$price."元", 
                        'actions' => [
                            [
                                'type' => 'uri', 
                                'label' => '前往', 
                                'uri' => 'https://groupbuy.learning365.tw/index/'.$this->companyId.'/'.$params['id'] //連結網址
                            ],

                        ]
                    ]
                ]
            ]
        ];
        // die(print_r($templateData));
        $this->client->post('https://api.line.me/v2/bot/message/broadcast', [
            'headers' => $this->headers,
            'json' => $templateData
        ]);
    }

    private function productDeliveryInformation($params){
        $payload = [
            'to' => $params['userIds'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $params['message'],
                ]
            ]
        ];

        $this->client->post('https://api.line.me/v2/bot/message/multicast', [
            'headers' => $this->headers,
            'json' => $payload
        ]);
    }

    //取得已寄送訊息數量
    private function getSendMessageCount(){
        $result = $this->client->get('https://api.line.me/v2/bot/message/quota/consumption', [
            'headers' => $this->headers,
        ]);
        $result = json_decode($result->getBody()->getContents(), true);
        print_r($result['totalUsage']);
    }
}
