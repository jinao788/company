<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use think\Session;
use app\admin\model\Admin as AdminModel;

class Admin extends Base
{

    //显示管理员首页
    public function index()
    {
        //1.读取admin管理员表的信息
        
        if (Session::get('user_name') == 'admin') {
         	$admin = AdminModel::all();
         	//
        }else{
        	$admin = AdminModel::all([ 'username'=>Session::get('user_name')]);  //这里用all是因为模板中volist的缘故,用get去掉模板volist也可以
        	//dump($admin);die;
        }
        //dump($admin);die;
        //$admin = AdminModel::get(['username'=> 'admin']);

        //2.将当前管理员的信息赋值给模板
        $this -> view -> assign('admin', $admin);

        //3.渲染模板
        return $this -> view -> fetch('admin_list');

    }

  



   
    public function edit(Request $request)
    {

        //1.读取admin管理员表的信息
        $admin = AdminModel::get($request->param('id'));

        //2.将当前管理员的信息赋值给模板
        $this -> view -> assign('admin', $admin);
        //3.渲染模板
        return $this -> view -> fetch('admin_edit');
    }

    //执行更新操作
    public function update(Request $request)
    {
    	
        if ($request -> isAjax(true)){
        	

            //获取提交的数据,自动过滤一下空值
            $data = array_filter($request->param());
//dump($data);die;
            if(empty($data['password'])){

	            // unset($data['repass']);
	            // unset($data['opassword']);
	            
	            if(empty($data['email'])){
	            	return ['status'=>0, 'message'=>'邮箱不能置空'];
		            
				}elseif($data['email'] !=AdminModel::get($data['id'])->email){
					//设置更新条件
		            //$map = ['is_update' => $data['is_update']];

		            //更新用户表
		           
		            $res = AdminModel::update(['email'=>$data['email'],'update_time'=> time()], ['id'=> $data['id']]);  //如果repass字段没有剔除成功 就使用alowField的save方法
		            if (is_null($res)) {
			                $status = 0;
			                $message = '邮箱修改失败';

			            }

		            //更新成功的提示信息
		            $status = 1;
		            $message = '邮箱修改成功';
		            //AdminModel::update(['id'=>'1','update_time'=> time()]);

			            //如果更新失败
			           
				
					return ['status'=>$status, 'message'=>$message];
				}else{
					return ['status'=>0, 'message'=>'邮箱未做修改'];
				}

            
			}elseif(empty($data['opassword'])){
		            return ['status'=>0, 'message'=>'改密必填原密码'];

			}elseif(md5($data['opassword']) == AdminModel::get($data['id'])->password){
					// unset($data['repass']);
					// unset($data['opassword']);

					if(strlen($data['password']) > 5 && strlen($data['password']) < 13 ){
						
							 //设置更新条件
			          

			            //更新用户表
			            if(empty($data['email'])){
			            	return ['status'=>0, 'message'=>'邮箱不能置空'];
			            }
			           
			            $res = AdminModel::update(['password'=>md5($data['password']),'email'=>$data['email'],'update_time'=> time()], ['id'=> $data['id']]);  //如果repass字段没有剔除成功 就使用alowField的save方法
			            

			            //更新成功的提示信息
			            $status = 1;
			            $message = '密码和邮箱均修改成功';
			           

				            //如果更新失败
				            if (is_null($res)) {
				                $status = 0;
				                $message = '密码或邮箱修改失败';
				            }
					
						return ['status'=>$status, 'message'=>$message];
							
					}else{
            			return ['status'=>0, 'message'=>'新密码必须6-12位'];
					}

			}else{
				
		   return ['status'=>0, 'message'=>'原密码不正确'];
			}
            //}
        }
        //


    }




}
