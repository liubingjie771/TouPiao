<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta version="<?php include("version.inc"); ?>" />
<title>投票项目列表</title>
<base target='_blank' />
<style type="text/css">
a
{
	text-decoration:none;
}
</style>
</head>
<body>
<center>
<?php
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	include("../data/sqlite3.php");
	$db=new DataBase("sqlite3db/toupiao.db");
	$mlinfo=$db->query("select * from tp_mulu where tp_view_stop>='".date("Y-m-d H:i:s")."' ");
	echo "<h1>投票项目列表</h1>";
	echo "<table border='0' cellspacing='0' cellpadding='3' width='50%'>";
	echo "<tr bgcolor='lightgray'><th align='left'>&nbsp;&nbsp;发布者</th><th align='center'>项目</th><th align='right'>到期可查看结果&nbsp;&nbsp;</th></tr>";
	while($mulu=$mlinfo->fetchArray())
	{
		echo "<tr><td align='left'>&nbsp;&nbsp;".$mulu["tp_cuser"]."</td>";
		if(strtotime($mulu["tp_end"])<strtotime(date("Y-m-d H:i:s")))
			echo "<td align='center'>".$mulu["tp_title"]."</td><td align='right'><a href='laster.php?tp_id=".$mulu["tp_id"]."'>查看结果</a>&nbsp;&nbsp;</td>";
		elseif(strtotime($mulu["tp_end"])>strtotime(date("Y-m-d H:i:s"))&&strtotime($mulu["tp_start"])<strtotime(date("Y-m-d H:i:s")))
			echo "<td align='center'>".$mulu["tp_title"]."</td><td align='right'><a href='index.php?tp_id=".$mulu["tp_id"]."'>开始投票</a>&nbsp;&nbsp;</td>";
		elseif(strtotime($mulu["tp_start"])>strtotime(date("Y-m-d H:i:s")))
			echo "<td align='center'>".$mulu["tp_title"]."</td><td align='right'>投票未开始&nbsp;&nbsp;</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</center>
<!--iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe-->
</body>
</html>