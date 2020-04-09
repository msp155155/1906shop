<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegModel;
use phpDocumentor\Reflection\Location;

class RegController extends Controller
{
    public function reg()
    {
        return view('user.register');
    }

    public function doreg(Request $request)
    {
        $model = new RegModel;

        // 接收表单传来的数据
        $data = $request->except('_token');
        // echo "<pre>";print_r($data);echo "</pre>";die;
        $data['user_password'] = password_hash($data['user_password'],PASSWORD_BCRYPT);
        $info = $model -> all()->toArray();

        // 入库
        $res = $model->insert($data);
        echo "<script>alert('注册成功！');</script>";

        // 用户列表
        $info = $model -> all()->toArray();
        echo "<pre>";print_r($info);echo "</pre>";
    }


    public function login()
    {
        return view('user.login');
    }

    
    public function loginDo(Request $request)
    {

        $user = $request->input('user');
        $pwd = $request->input('pwd');
        $res = RegModel::where('user_name',$user)->orwhere('user_email',$user)->orwhere('user_phone',$user)->first();
        if (!$res){
            echo "<script>alert('该用户不存在'),location='login'</script>";die;
        }
        if (!password_verify($pwd,$res['user_password'])){
            echo "<script>alert('密码错误'),location='login'</script>";die;
        }
        if ($res){
            session(['user'=>$user]);
            echo "<script>alert('登陆成功'),location=''</script>";
        }else{
            echo "<script>alert('登陆失败'),location='login'</script>";
        }

    }
}
