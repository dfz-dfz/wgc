<?php
namespace Admin\Controller;
use Think\Controller;
class ContentController extends Controller {
  
    //获取手机类型列表
    public function contentlist(){
    	$Content=D('Content');
    	$list=$Content->getList(20);
	    $page=$Content->getPage();
	    $this->assign('list',$list);
	    $this->assign("page",$page);
    	$this->display();
    } 
    //类型添加
     public function contentadd(){
     	if(IS_POST){
     		$Content=D('Content');
	        $post=I('post.');
	        $post['receive_num']=trim($post['receive_num']);
             $post['content']=trim($post['content']);
             $receive_num=$post['receive_num'];
             $content=$post['content'];
			 $content="【59家居】".$content."[回T退订]";
             $post['content']=$content;
	        if(!empty($post['receive_num']) && !empty($content)){
	        	//分割手机号码
	        	$mobiles=explode(",",$receive_num);
	        	//去掉左右空格
	        	foreach($mobiles as $key=>$val){
	        		$val=trim($val);
	        		$mobiles[$key]=$val;
	        	}
	        	foreach($mobiles as $key=>$val){
	        		send($val,$content);
	        	}
                $post['sender_num']="10655020073166422";
                $post['sendtime']=time();
                //循环短信入库
                foreach($mobiles as $key=>$val){
                	$post['receive_num']=$val;
                	 if($Content->data($post)->add()){
		                }else{
		                    echo "err";die;
		                }
                }
               echo "ok";die;
	        }elseif(empty($receive_num) && empty($content)){
	        	 echo "no";die;
	        }elseif(empty($receive_num)){
                echo "np";die;
            }else{
                 echo "nc";die;
            }
	    }

     	$this->display();
     }

     //删除
     public function contentdel(){
     	$Content=D('Content');
     	$ids="";
     	if(IS_GET){
     		$ids.=$_GET['msgid'];
     	}
     	//批量删除
     	if(IS_POST){
     		$idarr=$_POST['msgid'];
     		foreach($idarr as $key=>$val){
     			$ids.=$val.',';
     		}
     	}
     	$ids=trim($ids,',');
     	$res=$Content->delete($ids); 
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
    
}
?>