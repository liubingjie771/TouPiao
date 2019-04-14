<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta version="<?php include("version.inc"); ?>" />
<title>投票管理列表界面</title>
<base target="_blank" />
<script language="javascript">
function delkao(s)
{
	var u='delete.php?tp_id='+s;
	if(window.confirm("你确定要删除吗？"))
		window.location.href=u;
}
</script>
</head>
<body>
<center>
<?php
//注册时使用的REGID信息
$regid="ABC"."B60E0DDC080B9591F8FD422BF8C03B4A70C42625"."DEF";
if($_COOKIE["tp_regid"]!=$regid)
{
	echo "<script>window.alert('REGID号有问题，请联系管理员！');location.href='user.php';</script>";
}
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
		case "2" : echo "location.href='user.php';"; break;
	}
	echo "</script>";
	exit(0);
}
if($_COOKIE["tp_loginuser"]==null&&$_COOKIE["tp_limit"]==false)
{
	alerr("本页面授权的用户可以操作！",2);
}
?>
<fieldset>
<legend>投票管理列表</legend>
<?php
	include("../data/sqlite3.php");
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	$db=new DataBase("sqlite3db/toupiao.db");

$mlinfo=$db->query("select * from tp_mulu");
echo "<table border='1' cellspacing='0' cellpadding='0' width='100%'>";
echo <<<THEAD
	<tr>
		<th>投票<br/>ID号</th>
		<th>投票标题</th>
		<th>投票开始日期</th>
		<th>投票结束日期</th>
		<th>最小选择<br/>项目数</th>
		<th>最大选择<br/>项目数</th>
		<th>投票发布者</th>
		<th>投票发布日期</th>
		<th>结果查看<br/>截止日期</th>
		<th>项目总数</th>
		<th>操作</th>
	</tr>
THEAD;
while($mulu=$mlinfo->fetchArray())
{
	echo "<tr>";
	echo "<td>".$mulu["tp_id"]."</td>";
	echo "<td>".$mulu["tp_title"]."</td>";
	echo "<td>".$mulu["tp_start"]."</td>";
	echo "<td>".$mulu["tp_end"]."</td>";
	echo "<td>".$mulu["tp_min"]."</td>";
	echo "<td>".$mulu["tp_max"]."</td>";
	echo "<td>".$mulu["tp_cuser"]."</td>";
	echo "<td>".$mulu["tp_ctime"]."</td>";
	echo "<td>".$mulu["tp_view_stop"]."</td>";
	echo "<td>".$mulu["tp_znum"]."</td>";
	echo "<td align='center'>";
	if(strtotime($mulu["tp_start"])<=strtotime(date("Y-m-d H:i:s"))&&strtotime($mulu["tp_end"])>=strtotime(date("Y-m-d H:i:s")))
		echo "<a href='index.php?tp_id=".$mulu["tp_id"]."'>开始投票</a>";
	elseif(strtotime($mulu["tp_start"])>strtotime(date("Y-m-d H:i:s")))
		echo "投票未开";
	elseif(strtotime($mulu["tp_end"])<strtotime(date("Y-m-d H:i:s")))
		echo "投票已关";
	echo "&nbsp;&nbsp;<a href='laster.php?tp_id=".$mulu["tp_id"]."'>结果</a>&nbsp;&nbsp;<a href=\"javascript:delkao('".$mulu["tp_id"]."');\">删除</a></td>";
	echo "</tr>";
}
echo "</table>";
?>
</fieldset>
<button onclick="location.href='create.php';">创建投票信息</button>
</center>
<!--iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe-->
</body>
</html>