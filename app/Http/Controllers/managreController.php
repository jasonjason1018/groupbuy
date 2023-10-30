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
        $this->TestMessage();
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

    protected function getData(){
        $table = $this->post['table'];
        foreach($table as $k => $v){
            $data[$k] = DB::table($v)->where('companyId',$this->request->session()->get('companyId'))->get();
        }
        return $data;
    }

    protected function getEditData(){
        $table = $this->post['table'];
        $id = $this->post['id'];
        $data = DB::table($table)->where('id', $id)->get();
        return $data;
    }

    protected function deleteData(){
        $table = $this->post['table'];
        $id = $this->post['id'];
        $data = DB::table($table)->where('id', $id)->delete();
        return $data;
    }

    protected function insertEdit(){
        if(!$this->checkRequireColumn()){
            return '請確認所有欄位是否都有填寫!';
        }
        if($this->post['id'] == ''){
            $this->post['data']['launch_date'] = date("Y/m/d");
            $this->post['data']['sku'] = json_encode($this->post['data']['sku']);
            $this->post['data']['companyId'] = $this->request->session()->get('companyId');
            $insertId = DB::table($this->post['table'])->insertGetId($this->post['data']);
            if($this->post['data']['status'] == 1){
                $this->sendNewProductInfomation($insertId);
            }
            return $insertId;
        }
        DB::table($this->post['table'])->where('id', $this->post['id'])->update($this->post['data']);
    }

    protected function checkRequireColumn(){
        $data = $this->post['data'];
        foreach($data as $k => $v){
            $msg = true;
            if($v == '' && $k != 'delivery_date'){
                $msg = false;
                break;    
            }
            
        }
        return $msg;
    }

    protected function getOrderList(){
        $orderList = DB::table('order_list')->where('companyId',$this->request->session()->get('companyId'))->get();
        foreach($orderList as $k => $v){
            $orderList[$k]->buyer = $this->getBuyerName($v->buyer);
            $orderList[$k]->product_name = $this->getProductName($v->product_name);
        }
        return $orderList;
    }

    protected function getBuyerName($userId){
        $userName = DB::table('member')->select('name')->where('userId', $userId)->get()[0]->name;
        return $userName;
    }

    protected function getProductName($id){
        $userName = DB::table('product')->select('name')->where('id', $id)->get()[0]->name;
        return $userName;
    }

    protected function getProductOderCount(){
        extract($this->post);
        return DB::table('order_list')->where('product_name', $id)->where('companyId',$this->request->session()->get('companyId'))->count();
    }

    protected function productDelivery(){
        extract($this->post);
        DB::table('product')->where('id', $id)->update([
            'status' => 0,
            'delivery_date' => date("Y/m/d")
        ]);
        $product = DB::table('product')->where('id', $id)->where('companyId',$this->request->session()->get('companyId'))->get();
        $data = DB::table('order_list')->where('product_name', $id)->where('companyId',$this->request->session()->get('companyId'))->get();
        $productName = $product[0]->name;
        $message = "商品".$productName."已到貨~";
        $userIds = array();
        foreach($data as $k => $v){
            if(!in_array($v->buyer, $userIds)){
                $userIds[] = $v->buyer;
            }
        }
        $this->productDeliveryInformation($userIds, $message);
    }

    protected function getMemberData(){
        $data = DB::table('member')->get();
        foreach($data as $k => $v){
            $data[$k]->orderCount = DB::table('order_list')->where('buyer', $v->userId)->where('delivery_date', NULL)->where('companyId',$this->request->session()->get('companyId'))->count();
        }
        return $data;
    }

}