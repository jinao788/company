<?php
namespace app\index\controller;

use app\admin\common\Base;
use think\Request;

class Index extends Base
{
    public function index()
    {
        return '请访问后台';
    }
}
