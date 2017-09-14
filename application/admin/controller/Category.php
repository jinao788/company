<?php

namespace app\admin\controller;

use app\admin\common\Base;

use think\Request;

use app\admin\model\Category as CategoryModel;

class Category extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //1、获取分类信息
        $cate = CategoryModel::getCate();

        //2.用模型获取分页数据
        $cate_list=CategoryModel::order(['id'])->  paginate(10);

        //3.获取记录数量
        $count = CategoryModel::count();

        //4.模板赋值
        $this -> view -> assign('cate', $cate);
        $this -> view -> assign('cate_list', $cate_list);
        $this -> view -> assign('count', $count);


        //3.模板渲染
        return $this -> view -> fetch('category_list');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        if(request()->isPost()){
            $data=input('post.');

        // $rule = [
        //     ['cate_name'  ,  'require|unique:category','栏目名称不能为空|栏目名称已经存在'],
        // ];

            //$data->validate($rule)
             $validate = \think\Loader::validate('category');
                if(!$validate->check($data)){
                return ['status'=> 0, 'message'=> $validate->getError()];
                die;
                }

            //2.添加数据到分类表中
            $res = CategoryModel::create([
                //'cate_name'=> $request->param('cate_name'),
                'cate_name'=>$data['cate_name'],
                //'pid'=> $request->param('pid')
                'pid'=>$data['pid'],
            ]);
             //1.设置返回的值
            $status = 1;
            $message = '添加成功';


            //3.添加失败的处理
            if (is_null($res)) {
                $status = 0;
                $message = '添加失败';
            }

        return ['status'=> $status, 'message'=> $message, 'res'=> $res];  //->toJson()
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        //1.获取一下分类id
        $cate_id = $request -> param('id');
//dump($cate_id);die;
        //2.查询要更新的数据
        $cate_now = CategoryModel::get($cate_id);

        //3.递归查询所有的分类信息(应该是除自己分类以外的)
        $cate_level = CategoryModel::getCate();

        

       
        //dump($cate_level);die;  //二维数组
        
        //4除去自己
       // $cate_level = unset($cate_level) 

        //4.模板赋值
        $this -> view -> assign(['cate_now'=> $cate_now,'cate_level'=>$cate_level]);
        


        //5.渲染模板
        return $this -> view -> fetch('category_edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        //1.获取一下提交的数据
        $data = $request -> param();

        //2.更新操作
        $res = CategoryModel::update([
            'cate_name' => $data['cate_name'],
            'cate_order' => $data['cate_order'],
            //'pid' => $data['pid'],
        ],['id'=> $data['id']]);  //三个字段:更新字段 更新条件  允许更新的字段

        //3.设置返回值
        $status = 1;
        $message = '更新成功';

        //4.设置更新失败的返回值
        if (is_null($res)) {
            $status = 0;
            $message = '更新失败';
        }

        //5.返回结果
       return ['status'=>$status, 'message'=> $message];
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */

    //无论有无子分类 一并都会删除
    public function delete(Request $request)
    {

        $cate_id = $request -> param('id');
        //dump($cate_id);die;
        //获取子id
        $category = new CategoryModel();
        $childrenids =  $category->getchildrenid($cate_id);
        
        $childrenids[]=$cate_id;
        //dump($childrenids);die;
        foreach ($childrenids as $k => $v) {
             CategoryModel::update(['delete_time'=>time()],['id'=> $v]);
        }

       
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function deleteAll(Request $request)
    {
    	

    }

    
}
