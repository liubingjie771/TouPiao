<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>投票项目列表</title>
<base target='_blank' />
</head>
<body>
<center>
<?php
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	include("../data/sqlite3.php");
	$db=new DataBase("sqlite3db/toupiao.db");
	$mlinfo=$db->query("select tp_title,tp_start,tp_end,tp_cuser,tp_id from tp_mulu");
	echo "<h1>投票项目列表</h1>";
	echo "<table border='0' cellspacing='0' cellpadding='3' width='50%'>";
	echo "<tr><td align='left'>发布者</td><td align='center'>项目</td><td align='right'>到期可查看结果</td>";
	while($mulu=$mlinfo->fetchArray())
	{
		echo "<tr><td align='left'>".$mulu["tp_cuser"]."</td>";
		if($mulu["tp_end"]<date("Y-m-d"))
			echo "<td align='center'>".$mulu["tp_title"]."</td><td align='right'><a href='laster.php?tp_id=".$mulu["tp_id"]."'>查看结果</a></td>";
		elseif($mulu["tp_end"]>date("Y-m-d")&&$mulu["tp_start"]<date("Y-m-d"))
			echo "<td align='center'><a href='index.php?tp_id=".$mulu["tp_id"]."'>".$mulu["tp_title"]."</a></td><td align='right'>投票未结束</td>";
		elseif($mulu["tp_start"]>date("Y-m-d"))
			echo "<td align='center'>".$mulu["tp_title"]."></td><td align='right'>投票未开始</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</center>
<iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe>
</body>
</html>