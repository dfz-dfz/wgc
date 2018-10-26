<?php
//获取所有子栏目id
function get_child(&$menu,int $menuid)
{
  $f=false;
  $data=array();
  foreach($menu as $v)
  {
    if($v['parentid'] == $menuid)
    {
      $f=true;
      $data[]=$v['menuid'];
      $res=get_child($menu,$v['menuid']);
      if($res){
        $data=array_merge($data,$res);
      }
    }
  }
  if($f){
    return $data;
  }else{
    return $f;
  }
}

//获取所有父栏目
function get_parent_menu($id=0){
  $res = array();
  if($id){
    $res = M('menu')->where('menuid = %d',$id)->find();
    if($res){
      $res2 = get_parent_menu($res['parentid']);
      $res = array($res);
      if($res2){
        $res = array_merge($res2,$res);
      }
      return $res;
    }else{
      return $res;
    }
  }else{
    return false;
  }
}

//获取后台栏目参数
function get_arg($str){
  $arr = explode('&',$str);
  if(!is_array($arr)){
    $n_arr = array(0=>$arr);
  }else{
    $n_arr = &$arr;
  }
  $res = array();
  foreach ($n_arr as $v) {
    $target = explode('=',$v);
    if(is_array($target)){
      $res[$target[0]] = $target[1];
    }
  }
  return $res;
}

?>
