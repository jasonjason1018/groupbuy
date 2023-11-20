<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class managreController extends Controller
{

    protected $post;
    protected $get;
    protected $request;

    public function __construct(request $request){
        date_default_timezone_set("Asia/Taipei");
        $this->post = $request->input();
        $this->get = $request->query();
        $this->request = $request;
    }

    protected function Test(){
        die('untested task');
        // $data = DB::table('order_list')->select('product_name', DB::raw('GROUP_CONCAT(DISTINCT buyer) as buyers'))->groupBy('product_name')->get();
        // print_r($data);
        /*
            #取得已寄送訊息數量(測試成功)#
            $this->redirectFunction('getSendMessageCount');
        */
        /*
            #新商品上架通知(測試成功)#
            $insertId = 6;
            $params = [
                'id' => $insertId
            ];
            $this->post['data'] = [
                'name' => '測試用商品',
                'price' => '200',
            ];
            $this->redirectFunction('sendNewProductInfomation', $params);
        */
        /*
            #商品到貨通知(測試成功)#
            $userIds = ['Ubfb07bac4310d7ff80d6a243715960e8'];
            $productName = '測試用商品';
            $params = [
                'userIds' => $userIds,
                'message' => "商品".$productName."已到貨~",
            ];
            $this->redirectFunction('productDeliveryInformation', $params);
        */
    }

    //登入
    protected function login(){
        extract($this->post);
        $data = DB::table($table)
        ->where('username', $username)
        ->where('password', $password)
        ->get();
        $loginStatus = false;
        if(count($data)){
           $this->request->session()->put('user_data', $data);
           $this->request->session()->put('username', $data[0]->username);
           $this->request->session()->put('companyId', $data[0]->companyId);
           $loginStatus = true;
        }
        return $loginStatus;
    }

    //登出
    protected function logout(){
        $this->request->session()->flush();
        return redirect('admin/login');
    }

    private function getSession($sessionName){
        return $this->request->session()->get($sessionName);
    }

    //共用判斷條件
    private function queryGlobalCondition($query){
        $query = $query->where('companyId', $this->getSession('companyId'));
        return $query;
    }

    //取得後台首頁資料
    protected function getIndexData(){
        extract($this->post);
        foreach($table as $k => $v){
            $query = $this->queryGlobalCondition(DB::table($v));
            $data[$k] = $query->count();
        }
        return $data;
    }

    //取得商品列表資料
    protected function getProductList(){
        extract($this->post);
        $query = $this->queryGlobalCondition(DB::table($table)->select());
        $data = $query->get();
        foreach($data as $k => $v){
            $data[$k]->totalOrders = $this->countTotalOrders($data[$k]->id);
            // if($v->delivery_date != null){
            $data[$k]->totalDelivery = $v->delivery_date != null?$this->countTotalOrders($data[$k]->id, true):"-";
            // }
            
        }
        return $data;
    }

    //計算各商品訂單數量
    private function countTotalOrders($id, $delivery = false){
        $query = $this->queryGlobalCondition(DB::table('order_list'));
        $query = $query->where('product_name', $id);
        if($delivery){
            $query = $query->where('delivery_date', '!=', 'null');
        }
        return $query->count();
    }

    //商品到貨
    protected function productDelivery(){
        extract($this->post);
        //商品下架
        $this->ProductDeactivation($id);
        
        $query = $this->queryGlobalCondition(DB::table('order_list'));
        $data = $query->where('product_name', $id)->get();
        // $message = "商品".$productName."已到貨~";
        $userIds = array();
        foreach($data as $k => $v){
            if(!in_array($v->buyer, $userIds)){
                $userIds[] = $v->buyer;
            }
        }
        $params = [
            'userIds' => $userIds,
            'message' => "商品".$productName."已到貨~",
        ];
        $this->redirectFunction('productDeliveryInformation', $params);
    }

    //訂單到貨狀態更改
    private function ProductDeactivation($id){
        DB::table('product')->where('id', $id)->update([
            'status' => 0,
            'delivery_date' => date("Y/m/d")
        ]);
    }

    //刪除資料
    protected function deleteData(){
        extract($this->post);
        DB::table($table)->where('id', $id)->delete();
    }

    //取得編緝資料
    protected function getEditData(){
        extract($this->post);
        $data = DB::table($table)->where('id', $id)->get();
        return $data;
    }

    //新增or編輯資料
    protected function insertEdit(){
        extract($this->post);
        if(!$this->checkRequireColumn()){
            return '請確認所有欄位是否都有填寫!';
        }
        $data['status'] = $data['status']?'1':'0';
        if($this->post['id'] == ''){
            $this->post['data']['launch_date'] = date("Y/m/d");
            $this->post['data']['sku'] = json_encode($this->post['data']['sku']);
            $this->post['data']['companyId'] = $this->request->session()->get('companyId');
            $insertId = DB::table($this->post['table'])->insertGetId($this->post['data']);
            if($this->post['data']['status'] == 1){
                $params = [
                    'id' => $insertId,
                ];
                $this->redirectFunction('sendNewProductInfomation', $params);
            }
            return $insertId;
        }
        DB::table($this->post['table'])->where('id', $this->post['id'])->update($this->post['data']);
    }

    //確認資料是否都有填寫
    protected function checkRequireColumn(){
        extract($this->post);
        $column = ['delivery_date', 'status'];
        foreach($data as $k => $v){
            $msg = true;
            if($v == '' && !in_array($k, $column)){
                $msg = false;
                break;    
            }
            
        }
        return $msg;
    }

    //取得訂單列表
    protected function getOrderList(){
        $orderList = DB::table('order_list')->where('companyId',$this->request->session()->get('companyId'))->get();
        foreach($orderList as $k => $v){
            $orderList[$k]->buyer = $this->idToName('member', $v->buyer);
            $orderList[$k]->product_name = $this->idToName('product', $v->product_name);
        }
        return $orderList;
    }

    //取得商品、會員名稱
    private function idToName($table, $id){
        $condition = $table == 'product'?'id':'userId';
        return DB::table($table)->select('name')->where($condition, $id)->get()[0]->name??"商品已不存在";
    }

    protected function getProductOderCount(){
        extract($this->post);
        return DB::table('order_list')->where('product_name', $id)->where('companyId',$this->request->session()->get('companyId'))->count();
    }

    protected function getMemberData(){
        $data = DB::table('member')->get();
        foreach($data as $k => $v){
            $data[$k]->orderCount = DB::table('order_list')->where('buyer', $v->userId)->where('delivery_date', NULL)->where('companyId',$this->request->session()->get('companyId'))->count();
        }
        return $data;
    }

}