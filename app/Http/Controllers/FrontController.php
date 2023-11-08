<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    protected $post;
    protected $get;
    protected $request;
    protected $client;

    public function __construct(request $request){
        date_default_timezone_set("Asia/Taipei");
        $this->post = $request->input();
        $this->get = $request->query();
        $this->request = $request;
        $this->client = new \GuzzleHttp\Client();
    }

    private function getAccessToken(){
        $result = $this->client->post('https://api.line.me/oauth2/v2.1/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $this->request->code,
                'redirect_uri' => 'https://groupbuy.learning365.tw/front/login',
                'client_id' => '2000777378',
                'client_secret' => 'c877c03f48134d2daf5121a99e48fa76'
            ]
        ]);
        $result = json_decode($result->getBody()->getContents(), true);
        return $result;
    }

    private function getUserData($result){
        $response = $this->client->get('https://api.line.me/v2/profile', [
            'headers' => [
                'Authorization' => 'Bearer '.$result['access_token']
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }

    private function checkUserInfo($response){
        $isMember = DB::table('member')->where('userId', $response->userId)->count();
        if($isMember){
            DB::table('member')->where('userId', $response->userId)->update(['name' => $response->displayName]);
        }else{
            DB::table('member')->insert(['name' => $response->displayName, 'userId' => $response->userId, 'companyId' => $this->request->session()->get('liffId')]);
        }
    }

    protected function setToken(){
        extract($this->post);
        if(isset($token)){
            $this->request->session()->put('access_token', $token);
        }
        $this->request->session()->put('liffId', $liffId);
    }

    protected function setProductId(){
        extract($this->post);
        $this->request->session()->put('productId', $productId);
    }

    protected function login(){
        if(!$this->request->session()->has('access_token')){
            $result = $this->getAccessToken();
        }else{
            $result['access_token'] = $this->request->session()->get('access_token');
            $this->request->session()->forget('access_token');
        }
        
        $response = $this->getUserData($result);
        $this->checkUserInfo($response);
        return redirect('/goToIndex/'.$response->userId);
    }

    protected function goToIndex($userId){
        $data = DB::table('member')->where('userId', $userId)->get();
        $this->request->session()->put('userData', $data);
        $this->request->session()->put('userId', $userId);
        return redirect('/productList');
    }

    protected function getProductTotal(){
        extract($this->post);
        return DB::table('product')->where('status', 1)->where('companyId', $this->request->session()->get('userData')[0]->companyId)->count();
    }

    protected function getProductList(){
        extract($this->post);
        return DB::table('product')->where('status', 1)->where('companyId',$this->request->session()->get('userData')[0]->companyId)->offset($offset-1)->limit(1)->get();
    }

    protected function userBuyProduct(){
        
        if($this->request->session()->get('userId') == ''){
            return 'undefined';
        }
        $userId = $this->request->session()->get('userId');
        $sku_str = '';
        foreach($sku as $k => $v){
            $sku_str .= $v['name'].':'.$v['value']."\n";
        }

        $orderData = [
            'buyer' => $userId,
            'product_name' => $product_name,
            'buy_date' => date("Y/m/d"),
            'remark' => $remark,
            'buy_quantity' => $buy_quantity,
            'sku' => $sku_str,
            'total_price' => $totalPrice,
        ];
        DB::table('order_list')->insert($orderData);
        DB::table('product')->where('id', $productId)->update(['quantity' => $quantity-$buy_quantity]);
        $memberConsumption = DB::table('member')->select('consumption')->where('userId', $userId)->get()[0]->consumption;
        DB::table('member')->where('userId', $userId)->update(['consumption' => $memberConsumption+$totalPrice]);
        return 'success';
    }

    protected function getProductId(){
        $offset = '';
        if(null !== $this->request->session()->get('productId')){
            $data = DB::table('product')->where('status', 1)->where('companyId',$this->request->session()->get('userData')[0]->companyId)->get();
            foreach($data as $k => $v){
                if($this->request->session()->get('productId') == $v->id){
                    $offset = $k+1;
                }
            }
        }
        $this->request->session()->forget('productId');
        return $offset;
    }
    
}
