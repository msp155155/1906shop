<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegModel;

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
        $data['pass'] = password_hash($data['pass'],PASSWORD_BCRYPT);
        $info = $model -> all()->toArray();

        // 入库
        $res = $model->insert($data);
        echo "<script>alert('注册成功！');</script>";

        // 用户列表
        $info = $model -> all()->toArray();
        echo "<pre>";print_r($info);echo "</pre>";
    }
}
