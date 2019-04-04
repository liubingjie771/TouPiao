<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>投票结果</title>
</head>
<body>
<body>
<center>
<?php
	include("../data/sqlite3.php");
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	$db=new DataBase("sqlite3db/toupiao.db");
	
	$a1=$db->query("select * from tp_mulu where tp_id=".$_GET["tp_id"]);
	$a2=$a1->fetchArray();
	echo "<h1>".$a2["tp_title"]."</h1>";
	echo "<h3>发布者：".$a2["tp_cuser"]."</h3>";
	
	$b1=$db->query("select * from tp_mlst where tp_id=".$_GET["tp_id"]);
	echo "<table width='50%' cellpadding='0' cellspacing='0' border='1'>";
	while($b2=$b1->fetchArray())
	{
		echo "<tr>";
		echo "<td><font style='color:red;font-weight:bold'>&nbsp;&#".$b2["tp_value"]."</font>&nbsp;&nbsp;".$b2["tp_option"]."</td>";
		echo "<td><font style='color:blue;font-weight:bold'>&nbsp;".$b2["tp_count"]."</font></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</center>
<iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe>
</body>
</html>