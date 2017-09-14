<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
      protected $rule = [
       ['cate_name'  ,  'require|unique:category','栏目名称不能为空|栏目名称已经存在'],
       
        
    ];

    //  protected $message  =   [
    //     'catename.require' => '栏目名称不能为空',
     
    //     'catename.unique' => '栏目名称已经存在',
       
        
        
    // ];

    //  protected $scene = [
    //    // 'edit' =>['catename'=>'require|max:25' //|unique:cate
    //    // ],
    // ];
    



        
    

 




}
