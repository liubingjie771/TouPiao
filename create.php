<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta version="1.0" />
<title>创建投票栏目</title>
<?php
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
function alerr($a,$b)
{
	//$a弹出：错误信息
	//$b 0进入list.php，1返回表单
	echo "<script language='javascript'>";
	if($a!="")
	{
		echo "window.alert('".$a."');";
	}
	switch($b)
	{
		case "1" : echo "history.go(-1);"; break;
		case "2" : echo "location.href='admin_list.php';"; break;
		case "3" : echo "location.href='user.php';"; break;
	}
	echo "</script>";
	exit(0);
}
if($_COOKIE["tp_loginuser"]==null&&$_COOKIE["tp_limit"]==false)
{
	alerr("本页面授权的用户可以操作！",3);
}

function addcan($ad,$bc,$cb)
{
	//$ad投票ID
	//$bc选项名数组
	//$cb数据指针
	$addstr="insert into tp_mlst values";
	for($i=0;$i<count($bc);$i++)
	{
		$v=(65+$i);
		$o=$bc[$i];
		if($o=="")
			continue;
		$addstr=$addstr."(".$ad.",'".$o."','".$v."',0,''),";
	}
	if($cb->exec(substr($addstr,0,-1)))
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>
<script language="javascript">
function add()
{
    var ul=document.getElementById("tpxx");
	var li=document.createElement("li");
	li.innerHTML="<li><input type=\"text\" name=\"tp_can[]\" id=\"tp_can\" size=\"75\" /><input type=\"button\" onClick='del(this);' value=\"删除\" /></li>";
	ul.appendChild(li);
}
 
function del(e) { 
	e.parentNode.parentNode.removeChild(e.parentNode);

} 
</script>
</head>
<body>
<center>
<fieldset style="padding:8px;margin-left:300px;margin-right:300px;border:1px solid green;">
<legend align="center"><font style="font-size:50px;font-family:黑体;font-weight:bold;color:blue;">新建投票</font></legend>
<?php
//$_COOKIE["tp_loginuser"]="liubingjie771";
//$_COOKIE["tp_loginname"]="刘星云";
if($_GET["yn"]=="0")
{
	//创建投票表单
	echo <<<TOUPIAOFORM1
		<form id="tpc" name="tpc" action="?yn=1" method="post">
		<table border="1" width="100%" cellpadding="2" cellspacing="0">
		<tr>
			<th width="20%">开始时间：</th><td width="30%"><input type="date" name="tp_start" id="tp_start" value="" placeholder="如：2019-01-03"/></td>
			<th width="20%">结束时间：</th><td width="30%"><input type="date" name="tp_end" id="tp_end" value="" placeholder="如：2019-01-03"/></td>
		</tr>
		<tr>
			<th>投票标题：</th><td colspan='3'><input type="text" id="tp_title" name="tp_title" size="70" /></td>
		</tr>
		<tr>
			<th>最小选项：</th><td><input type="number" id="tp_min" name="tp_min" value="0" /></td>
			<th>最大选项：</th><td><input type="number" id="tp_max" name="tp_max" value="1" /></td>
		</tr>
		<tr><td colspan="4">
		<p style="font-weight:bold">投票选项：<input type="button" onclick="add()" value="添加选项" /></p>
		<ul style="list-style-type:none;" id="tpxx" name="tpxx">
			<li><input type="text" name="tp_can[]" id="tp_can" size="75" /><input type="button" onClick='del(this);' value="删除" /></li>
			<li><input type="text" name="tp_can[]" id="tp_can" size="75" /><input type="button" onClick='del(this);' value="删除" /></li>
		</ul></td></tr>
TOUPIAOFORM1;

		echo "<tr><td colspan=\"4\" align=\"center\"><input type=\"submit\" value=\"生成投票\" /><span style=\"float:left;font-size:4px;font-weight:tiny;line-height:24px;color:lightgray;\">&trade;lyclub2016&trade;</span><span style=\"float:right;font-size:4px;font-weight:tiny;line-height:24px;color:lightgray;\">&copy;发布者：".$_COOKIE["tp_loginname"]."&copy;</span></td></tr>";
echo <<<TOUPIAOFORM2
		</table>
		</form>
TOUPIAOFORM2;
}
elseif($_GET["yn"]=="1")
{
	//创建投票处理
	//echo "<h1 style='color:red'>生成投票失败！正在建设此功能……</h1>";
	
	$yu_tp_title=$_POST["tp_title"];
	$yu_tp_start=$_POST["tp_start"];
	$yu_tp_end=$_POST["tp_end"];
	$yu_tp_min=$_POST["tp_min"];
	$yu_tp_max=$_POST["tp_max"];
	$yu_tp_cuser=$_COOKIE["tp_loginname"];
	$yu_tp_ctime=date("Y-m-d H:i:s");
	$yu_tp_bakinfo="";
	$yu_tp_options=$_POST["tp_can"];
	
	if($yu_tp_start>$yu_tp_end)
	{
		alerr("开始日期和结束日期不正确！",1);
	}
	if($yu_tp_min>$yu_tp_max)
	{
		alerr("最小选项和最大选项不正确！",1);
	}
	if(count($yu_tp_options)<2)
	{
		alerr("请添加最小两项的投票选择！",1);
	}
	include("../data/sqlite3.php");
	$db=new DataBase("sqlite3db/toupiao.db");
	if(!$mlid=$db->query("select max(tp_id) from tp_mulu"))
	{
		alerr("查询投票目录ID号失败1!",1);
	}
	elseif(!$mid=$mlid->fetchArray())
	{
		alerr("查询投票目录ID号失败2!",1);
	}
	elseif(($mdn=$mid[0]+1)<=1000)
	{
		alerr("查询投票目录ID号失败3!",1);
	}
	elseif($db->exec("insert into tp_mulu values(".$mdn.",'".$yu_tp_title."','".$yu_tp_start."','".$yu_tp_end."',".$yu_tp_min.",".$yu_tp_max.",'".$yu_tp_cuser."','".$yu_tp_ctime."',null)"))
	{
		if(addcan($mdn,$yu_tp_options,$db))
		{
			alerr("创建投票信息成功！",2);
		}
		else
		{
			$db->exec("delete from tp_mulu where tp_id=".$mdn);
			alerr("创建投票信息失败2！",1);
		}
	}
	else
	{
		alerr("创建投票信息失败1！",1);
	}
}
elseif($_GET["yn"]==null)
{
	header("Location: ?yn=0");
}
?>
</fieldset>
</center>
<iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe>
</body>
</html>