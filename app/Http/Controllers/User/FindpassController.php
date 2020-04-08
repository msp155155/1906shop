<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\RegModel;
use App\Models\FindpassModel;

class FindpassController extends Controller
{
    public function getFind()
    {
        return view('user.findpass');
    }

    public function postFind(Request $request)
    {
        $user_name = $request->input('u');
        $u = RegModel::where(['name' => $user_name])
            ->orwhere(['email' => $user_name])
            ->first();

        // 找到用户发送重置密码邮件
        if ($u)
        {
            $token = Str::random(32);
            $data = [
                'uid'   => $u->id,
                'token' => $token,
                'status'=> 0,
                'expire'=> time() + 900     // 15分钟之内修改
            ];

            FindpassModel::insertGetId($data);

            // 生成密码重置链接
            $url = [
                'url' => env('APP_URL') . '/resetpass?token=' . $token
            ];
            Mail::send('user.email',$url, function ($message) {
                // $to = Request()->get('email');
                $to = '799877860@qq.com';
                // dd($to);
                $message ->to($to)->subject('找回密码');
            });
            echo '重置密码链接已发送至您的邮箱' . $u->email . '，请注意查收';
            // 返回的一个错误数组，利用此可以判断是否发送成功
            // dd(Mail::failures());
        }
    }

    public function getReset(Request $request)
    {
        $token = $request->input('token');
        if (empty($token))
        {
            die('未授权，缺少token');
        }

        $data = [
            'token' => $token
        ];

        return view('user.resetpass',$data);
    }

    public function postReset(Request $request)
    {
        $pass1 = $request->input('pass1');
        $pass2 = $request->input('pass2');
        $token = $request->input('reset_token');

        if ($pass1 != $pass2)
        {
            die('两次密码输入不一致！！！');
        }

        // 验证token是否使用与是否过期
        $u = FindpassModel::where(['token' => $token])->orderBy('id','DESC')->first();
        if (empty($u))
        {
            die('未授权，token无效');
        }

        // token是否过期，过期则终止
        if ($u->expire < time())
        {
            die('token已过期');
        }

        if ($u->status==1)
        {
            die('token已失效');
        }

        // 新密码使用hash加密
        $newPass = password_hash($pass1,PASSWORD_BCRYPT);
        echo $newPass;

        // 更新密码
        $uid = $u->uid;
        RegModel::where(['id' => $uid])->update(['pass' => $newPass]);

        // 设置token为已使用
        FindPassModel::where(['token' => $token])->update(['status' => 1]);
        echo "</br>";
        echo '密码更新成功';
    }
}


