<?php
namespace Admin\Controller;
use Think\Controller;
class JobtypeController extends Controller {
  
    //获取手机类型列表
    public function typelist(){
    	$type=D('Jobtype');
    	$list=$type->getList(10);
	    $page=$type->getPage();
	    $this->assign('list',$list);
	    $this->assign("page",$page);
    	$this->display();
    } 
    //类型添加
     public function typeadd(){
     	if(IS_POST){
     		$type=D('Jobtype');
	        $data=I('post.');
	        $jobtype_name=trim($data['jobtype_name']);
	        if(!empty($jobtype_name)){
	        	//判断是否存在过此手机号码类型
     			$c=$type->where(array('jobtype_name'=>array('like',$jobtype_name)))->count();
     			if($c >= 1){echo 'has';die;}
	        	$data['jobtype_name']=$jobtype_name;
	        	$data['addtime']=time();
	        	if($type->data($data)->add()){
		          //$this->success("添加角色成功！");
		        echo 'ok';die;
		        }else{
		         // $this->error("添加失败!");
		        	echo "err";die;
		        }
	        }else{
	        	echo "no";die;
	        }
	    }

     	$this->display();
     }

     //类型修改
     public function typeupdate(){
     	$type=D('Jobtype');
     	if(IS_POST){
	        $post=I('post.');
	        $data=array();
	        $data['jobtype_name']=trim($post['jobtype_name']);
	        $jobtype_name=$data['jobtype_name'];
	        if(!empty($jobtype_name)){
	        	//判断是否存在过此手机号码类型
     			$c=$type->where(array('jobtype_name'=>array('like',$jobtype_name)))->count();
     			if($c >= 1){echo 'has';die;}
	        	$res=$type->where(array('jobtype_id'=>$post['jobtype_id']))->field('jobtype_name')->filter('strip_tags')->save($data);
	        	if($res === false){
		          //$this->success("更新失败");
		        echo 'err';die;
		        }else{
		         // $this->error("更新成功!");
		        	echo "ok";die;
		        }
	        }else{
	        	echo "no";die;
	        }
	    }
	    //获取值
	    $jobtype_id=$_GET['jobtype_id'];
	    $jobtype_name = $type->where(array('jobtype_id'=>$jobtype_id))->getField('jobtype_name');
	    $this->assign('jobtype_id',$jobtype_id);
	    $this->assign('jobtype_name',$jobtype_name);
     	$this->display();
     }
     //删除
     public function typedel(){
     	$type=D('Jobtype');
     	$ids="";
     	if(IS_GET){
     		$ids.=$_GET['jobtype_id'];
     	}
     	//批量删除
     	if(IS_POST){
     		$idarr=$_POST['jobtype_id'];
     		foreach($idarr as $key=>$val){
     			$ids.=$val.',';
     		}
     	}
     	$ids=trim($ids,',');
     	$res=$type->delete($ids); 
     	if($res === false){
	          //$this->success("删除失败");
	        echo 'err';die;
            //echo $ids;die;
		}else{
         // $this->error("删除成功!");
        	echo "ok";die;
        }
     	die;
     }
     public function te(){
     	if(IS_POST){
     		p($_POST);
     	}
     	$this->display(cy);

     }
    

}
?>