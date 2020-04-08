<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    //指定模型关联表
    protected $table = 'user';
    //指定数据库主键
    protected $primaryKey = 'user_id';
    //定义时间戳
    public $timestamps = false;
    //定义时间戳格式
    //protected $dateFormat = 'U';
    //指定允许批量赋值的字段
    protected $fillable = ['user_email','user_phone','user_password','user_name'];
}
