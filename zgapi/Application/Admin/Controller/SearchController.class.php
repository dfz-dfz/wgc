<?php
namespace Admin\Controller;
use Think\Controller;
class SearchController extends Controller {
  
    //获取手机列表
    public function searchlist(){
    	$Search=D('Search');
    	$list=$Search->getList(10);
	    $page=$Search->getPage();
		foreach($list as $key=>$row){
			if($row['status']==1){
				$list[$key]['status']="1(未审核)";
			}else{
				$list[$key]['status']="0(已经审核)";
			}
		}
	    $this->assign('list',$list);
	    $this->assign("page",$page);
    	$this->display();
    } 
    //添加
     public function searchadd(){
     	if(IS_POST){
     		$Search=D('Search');
	        $data=I('post.');
	        $mobe=trim($data['mobe']);
	        if(!empty($mobe)){
	        	//判断是否存在过此手机号码类型
     			$c=$Search->where(array('mobe'=>array('like',$mobe)))->count();
     			if($c >= 1){echo 'has';die;}
	        	$data['mobe']=$mobe;
				$data['addtime']=date('Y-m-d H:i:s', time());
                $data['area']=$data['province']." ".$data['city']." ".$data['area'];
                unset ($data['province']);
                unset ($data['city']);
	        	if($Search->data($data)->add()){
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
        //获取手机
        $type=D("Type");
        $types=$type->field("typeid,typename")->select();
        $this->assign('types',$types);
     	$this->display();
     }

     //修改
     public function searchupdate(){
     	$Search=D('Search');
     	$id=$_GET['id'];
     	if(IS_POST){
	        $post=I('post.');
	        $id=$post['id'];
	       	if($post['s_province']=='请选择'){
	       		unset($post['s_province']);
	       		unset($post['s_city']);
	       		unset($post['s_county']);
	       	}elseif($post['s_city']=='请选择'){
	       		unset($post['s_city']);
	       		unset($post['s_county']);
	       	}elseif($post['s_county']=='请选择'){
	       		unset($post['s_county']);
	       	}
                $res=$Search->save($post);
                if($res === false){
                  //$this->success("更新失败");
                    //echo 'err';die;
                    $this->assign('upok','err');
                }else{
                	$this->assign('upok','ok');
                }
	    }
	    //获取需要修改记录的值
	    $list = $Search->where(array('id'=>$id))->find();
	    $this->assign('id',$id);
         //获取所有工种
		 $jobtype=D("Jobtype");
		 $types=$jobtype->field("jobtype_id,jobtype_name")->select();
		$this->assign('types',$types);
	    $this->assign('list',$list);
     	$this->display();
     }
     //删除
     public function searchdel(){
     	$Search=D('Search');
     	$ids="";
     	if(IS_GET){
     		$ids.=$_GET['id'];
     	}
     	//批量删除
     	if(IS_POST){
     		$idarr=$_POST['id'];
     		foreach($idarr as $key=>$val){
     			$ids.=$val.',';
     		}
     	}
     	$ids=trim($ids,',');
     	$res=$Search->delete($ids); 
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
     //导出通讯录
     public function daochu(){
     	$Search=D('Search');
     	$mobes=$Search->field('mobe,name')->select();
     	$tes="";
     	foreach($mobes as $key=>$val){
     		$tes.=$val['mobe'].',';
     	}
     	$tes=trim($tes,',');
     	echo $tes;die;
     	//$this->assign('mobes',$mobes);
     	//$this->display();
     }

}
?>