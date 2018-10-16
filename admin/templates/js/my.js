 function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　 }
function ltrim(str){ //删除左边的空格
　　     return str.replace(/(^\s*)/g,"");
　　 }
function rtrim(str){ //删除右边的空格
　　     return str.replace(/(\s*$)/g,"");
　　 }
function ValidateNumber(e, pnumber){
          if (!/^\d+$/.test(pnumber)){
          $(e).val(/^1[\d]+/.exec($(e).val()));
          }else{
            $(e).val(/^1\d{0,10}/.exec($(e).val()));
            if($("#mobile").val().length>11){
              $(e).val(/^1\d{0,10}/.exec($(e).val()));
            }
          }
          return false;
          }
function shijiao(){
        var phonenum=trim($("#mobile").val());
        if(phonenum==""){
            //alert("手机号不能为空");
			$("#sjh").html("手机号不能为空");
          }else if(phonenum.length!=11){
            //alert('手机格式不正确，请输入11位的手机号');
			$("#sjh").html("手机格式不正确，请输入11位的手机号");
          }else{
              //判断手机是否已经注册
             $.ajax({
               type: "POST",
                url: "http://localhost/myecmall1/admin/index.php?app=user&act=ajax_chkmobe",
                data: "phonenum="+phonenum,
                success: function(msg){
                     if(msg>0){$("#sjh").html("该手机已经注册，请登陆");}else{$("#sjh").html("");}
                     }
                });     
          }
                
        
      }
   function checkagain(){
	   window.alert('ok');
        var phonenum=trim($("#mobile").val());
        if(phonenum==""){
            alert("手机号不能为空");return false;
          }else if(phonenum.length!=11){
            alert('手机格式不正确，请输入11位的手机号');return false;
          }else if($("#sjh").html()=="该手机已经注册，请登陆"){
          alert("该手机已经注册，请登陆");
          return false;
        }else{
          $("#sjh").html("");
          //alert('可以注册');
          return true;
        }
      }
	  function daochu(){
		  var res=window.confirm("你确定要导出数据吗？");
		  return res;
	  }
