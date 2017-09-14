<?php

namespace app\admin\controller;

use app\admin\common\Base;

use think\Request;

use app\admin\model\Banner as BannerModel;
class Banner extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $banner = BannerModel::all();
        $count  = BannerModel::count();

        $this->view->assign([
            'banner'=>$banner,
            'count'=>$count
            ]);

        return $this -> view -> fetch('banner_list');
    }

    /**
     * 显示创建资源表单页.添加
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return $this -> view -> fetch('banner_add');
    }

    /**
     * 保存新建的资源,进行上传
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        if($this->request->isPost()){
            //获取提交数据,含上传文件
            $data = $this->request->param(true);
            //获取上传文件的对象
            $file = $this->request->file('image');
            //dump($file);die;
            if(is_null($file)){

                //$this->error($file->getError());
                $status = 0;
                $message = '图片不能为空';
               
            }
            
            //上传
            $map =[
                    'ext'=>'jpg,png',
                    'size'=>3000000,
                 ];
            $info= $file->validate($map)->move(ROOT_PATH.'public/uploads/');
            if(is_null($info)){
                $this->error($file->getError());
            }


            $data['image'] = $info->getSaveName();
            $res = BannerModel::create($data);
            if(is_null($res)){
                $status = 0;
                $message = '更新失败';
            }
                $status = 1;
                $message = '更新成功';
        }else{
                $status = 0;
                $message = '请求类型错误';
            
        }

        return ['status'=>$status, 'message'=>$message];
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
    public function edit($id)
    {
        $data = BannerModel::get($id);
        $this->view ->assign('data',$data);
        return $this->view->fetch('banner_edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->request->param(true);
        $file = $this->request->file('image');

        if(is_null($file)){
               // $this->error($file->getError());
            $res= BannerModel::update([
           
            'link' => $data['link'],
            'desc' => $data['desc']
            ],['id'=>$data['id']]) ;

        }else{

            $info = $file->validate(['ext'=>'jpg,png','size'=>3000000])->move(ROOT_PATH.'public/uploads/');
            
            $res= BannerModel::update([
                'image' => $info->getSaveName(),
                'link' => $data['link'],
                'desc' => $data['desc']
                ],['id'=>$data['id']]) ;
        }
        if (is_null($res)) {
            $this -> error('更新失败');
        }
            $this -> success('更新成功');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        BannerModel::destroy($id);
    }
}
