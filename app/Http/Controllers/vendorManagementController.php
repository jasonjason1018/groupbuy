<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vendorManagementController extends Controller
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

    protected function login(){
        extract($this->post);
        $data = DB::table($table)
        ->where('username', $username)
        ->where('password', $password)
        ->get();
        $loginStatus = false;
        if(count($data)){
           $this->request->session()->put('vendorUsername', $data[0]->username);
           $loginStatus = true;
        }
        return $loginStatus;
    }

    protected function logout(){
        $this->request->session()->flush();
        return redirect('vendorLogin');
    }

    protected function getAdminData(){
        extract($this->post);
        // DB::table('admin_member')->get();
        $query = DB::table('admin_member');
        if(isset($id) && $id != ''){
            $query = $query->where('id', $id);
        }
        return $query->get();
    }

    protected function insertEditData(){
        extract($this->post);
        $form['status'] = $form['status']?'1':'0';
        $query = DB::table('admin_member');
        foreach($form as $k => $v){
            if($v == ''){
                return '請確認所有欄位是否都有填寫';
            }
        }
        if($id == ''){
            $query->insert($form);
            return true;
        }
        $query->where('id', $id)->update($form);
        return true;
    }

    protected function deleteData(){
        extract($this->post);
        DB::table('admin_member')->where('id', $id)->delete();
        return true;
    }
}
