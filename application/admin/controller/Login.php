<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use app\admin\model\Admin;
use think\Session;

class Login extends Base
{
    //渲染登录界面
    public function index()
    {

        $this -> alreadyLogin();
        return $this -> view -> fetch('login');
    }

    //验证用户身份
    public function check(Request $request)
    {
        //设置status
        $status = 0;

        //获取一下表单提交的数据,并保存在变量中
        $data = $request -> param();
        $userName = $data['username'];
        $password = md5($data['password']);
//dump($data);die;

        //在admin表中进行查询:以用户为条件
        $map = ['username'=> $userName];
        $admin = Admin::get($map);  //此处不能传$userName 得是数组
//dump($admin);die;
        //将用户名与密码分开验证

        //如果没有查询到该用户
        if (is_null($admin)){

            //设置返回信息
            $message = '用户名不正确';
        } elseif ($admin -> password != $password) {

            //设置一下密码不正确的提示信息
            $message = '密码不正确';
        } else {

            //如果用户名和密码都通过了验证,表明是合法用户
            //修改一下返回的信息
            $status = 1;
            $message = '验证通过,请点击确定进入后台';

            //更新表中登录次数与最后登录时间
            $admin -> setInc('login_count');
            $admin -> save(['lastlogin_time'=> time()]);

            //将用户登录的信息保存到session中,供其它控制器进行登录判断
            Session::set('user_id', $admin->id);
            Session::set('user_name', $admin->username);
            Session::set('lastlogin_time', $admin->lastlogin_time);
            Session::set('login_count', $admin->login_count);
            //这条语句只能存储username和password,其它字段不能存储
//            Session::set('user_info',$data);

//            应该修改成:
            //Session::set('user_info',$admin->toArray()); 存这个的意义不大

        }

        return ['status'=> $status, 'message'=> $message];


    }


    //退出登录
    public function logout()
    {   
        //dump(Session::get('user_info'));die;
        Admin::update(['id'=>Session::get('user_id'),'lastlogout_time'=> time()]);
        //dump(Session::get('user_id'));
        //dump(Session::get('user_info.id'));
        //dump(Session::get());die;
        //删除当前用户session值
        Session::delete('user_id');
        //Session::delete('user_info');

        

        //执行成功,并返回登录界面
        $this -> success('注销成功,正在返回...','login/index');
    }


}
