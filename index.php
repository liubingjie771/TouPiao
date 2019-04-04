<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>投票系统-公测版</title>
<meta version="1.0" />
</head>
<body>
<center>
<?php
	$tp_id=$_GET["tp_id"];
	if($tp_id==null)
	{
		header("Location: view_list.php");
	}
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	include("../data/sqlite3.php");
	$db=new DataBase("sqlite3db/toupiao.db");
	$tpln=0;
if($_GET["start"]=="0")
{	
	echo "<form action=' ?start=1&tp_id=".$tp_id."' method='post' name='myForm' id='myForm'>";
	$m1=$db->query("select * from tp_mulu where tp_id=".$tp_id);
	$mulu=$m1->fetchArray();
	if($mulu["tp_start"]<=date("Y-m-d")&&$mulu["tp_end"]>=date("Y-m-d"))
	{
		echo "<h1>".$mulu["tp_title"]."</h1>";
		echo "<p>发布者：".$mulu["tp_cuser"]."</p>";
		$tpln=$mulu["tp_max"];
		echo "<input type='hidden' id='tp_id' name='tp_id' value='".$tp_id."' />";
		echo "<input type='hidden' id='tpmin' name='tpmin' value='".$mulu["tp_min"]."' />";
	}
	
	echo "<ul style=\"list-style-type:none;\">";
	$a2=$db->query("select * from tp_mlst where tp_id=".$tp_id);
	while($a3=$a2->fetchArray())
	{
		echo "<li><input type=\"checkbox\" name=\"fmtps[]\" id=\"fmtps\" value=\"".$a3["tp_value"]."\" onclick=\"return checkDate();\" />&#".$a3["tp_value"].":".$a3["tp_option"]."</li>";
	}
	echo "</ul>";
	echo "<p><input type='submit' value='投票' /></p>";
	echo "</form>";
}
elseif($_GET["start"]=="1")
{
	 $tp_id=$_POST["tp_id"];
	 $tp_num=$_POST["fmtps"];
	 //print_r($tp_num);
	 if($_POST["tpmin"]>count($tp_num))
	 {
		 echo "<script language='javascript'>window.alert('最小只能选择项目为".$_POST["tpmin"]."！');history.go(-1);</script>";
		 exit(0);
	 }
	 $cj=0;
	 for($i=0;$i<count($tp_num);$i++)
	 {
		 if($db->exec("update tp_mlst set tp_count=tp_count+1 where tp_id=".$tp_id." and tp_value='".$tp_num[$i]."'"))
			 $cj=$cj+1;
	 }
	 if($cj>0)
	 {
		 echo "<script language='javascript'>window.alert('投票完成！');location.href='?tp_id=".$tp_id."';</script>";
	 }
}
elseif($_GET["start"]==null)
{
	header("Location: ?start=0&tp_id=".$tp_id);
}
?>
<script type="text/javascript" > 

function  checkDate(){ 


  var checkedCount=0; 

  for(var i=0;i<myForm.fmtps.length ;i ++){ 

  if(myForm.fmtps[i].checked){ 

     checkedCount++; 
  
      } 
  } 

   if(checkedCount><?php echo $tpln; ?>){ 
  
  alert("最多只能选择<?php echo $tpln; ?>项。"); 
  
       return false; 
  
  } 

  } 
  
</script>
</center>
<iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe>
</body>
</html>