<!doctype html>
<html>
<head>
<meta charset="UTF-8"/>
<title>投票系统初始化数据</title>
</head>
<body>
<?php
include("sqlite3.php");
$db=new DataBase("sqlite3db/toupiao.db");

/**tp_mulu*********************************************************************************************************************************************
  tp_id    | tp_title          | tp_start     | tp_end       | tp_min        | tp_max         | tp_cuser           | tp_ctime        | tp_bakinfo 
------------------------------------------------------------------------------------------------------------------------------------------------------
投票目录号 | 投票问题的标题    | 投票开始时间 | 投票结束时间 | 投票最小选项  | 投票最大选项   | 投票发布用户别名   | 投票创建时间    | 投票备注信息
******************************************************************************************************************************************************/
$istb[0]="drop table tp_mulu";
$istb[1]="create table tp_mulu(tp_id int unique,tp_title varchar(100) not null,tp_start date not null,tp_end date not null,tp_min int not null,tp_max int not null,tp_cuser varchar(50) not null,tp_ctime datetime not null,tp_bakinfo varchar(1000))";
$istb[2]="insert into tp_mulu values(1000,'测试投票标题一','2019-02-01','2019-02-28','2','3','投票管理员','2019-01-31 08:32:33','')";
$istb[20]="insert into tp_mulu values(1001,'测试已结束的投票标题','2019-02-01','2019-02-02','1','2','投票管理员','2019-01-31 08:32:33','')";
$istb[21]="insert into tp_mulu values(1002,'测试未开始的投票标题','2029-03-01','2029-03-31','1','2','投票管理员','2019-01-31 08:32:33','')";
/**tp_mlst********************************************************************************
  tp_id      |  tp_option          | tp_value          | tp_count    | tp_bakinfo
------------------------------------------------------------------------------------------
 投票目录号  | 投票选项的显示信息  | 投票选项的表单值  | 记录投票数  |表单选项的备注信息
*****************************************************************************************/
$istb[3]="drop table tp_mlst";
$istb[4]="create table tp_mlst(tp_id int not null,tp_option varchar(100) not null,tp_value varchar(10) not null,tp_count int not null,tp_bakinfo varchar(1000))";
$istb[5]="insert into tp_mlst values(1000,'选项一','65',0,null)";
$istb[6]="insert into tp_mlst values(1000,'选项二','66',4,null)";
$istb[7]="insert into tp_mlst values(1000,'选项三','67',0,null)";
$istb[8]="insert into tp_mlst values(1000,'选项四','68',0,null)";
$istb[9]="insert into tp_mlst values(1000,'选项五','69',0,null)";
$istb[10]="insert into tp_mlst values(1001,'选项六','70',5,null)";
$istb[11]="insert into tp_mlst values(1001,'选项七','71',0,null)";
$istb[12]="insert into tp_mlst values(1002,'选项八','72',0,null)";
$istb[13]="insert into tp_mlst values(1002,'选项九','73',0,null)";
$istb[14]="insert into tp_mlst values(1002,'选项十','74',0,null)";

/****tp_users******************************************************************************************************************************
  tpu_id      |    tpu_name   |   tpu_alias     |  tpu_pass      |  tpu_admin     |  tpu_tel         |   tpu_mail        | tpu_bakinfo
-------------------------------------------------------------------------------------------------------------------------------------------
 投票用户ID号 |  投票用户名   | 投票用户显示名  | 投票用户密码   |  用户管理启用  |投票用户手机号  | 投票用户电子邮箱  | 投票用户备注信息
*******************************************************************************************************************************************/
$istb[15]="drop table tp_users";
$istb[16]="create table tp_users(tpu_id int unique,tpu_name varchar(100) not null,tpu_alias varchar(200) not null,tpu_pass varchar(100) not null,tpu_admin bool  not null,tpu_tel varchar(12) not null,tpu_mail varchar(100) not null,tpu_bakinfo varchar(1000))";
$istb[17]="insert into tp_users values(9000,'admin','投票管理员1','".sha1("891021")."',1,'18562221224','liubingjie771@live.cn',null)";
$istb[18]="insert into tp_users values(9001,'liubingjie771','投票管理员2','".sha1("lbj*891021")."',1,'18562221224','liubingjie771@live.cn',null)";
$istb[19]="insert into tp_users values(9002,'guest','临时访问者','".sha1("123")."',1,'18562221224','liubingjie771@live.cn',null)";

for($i=0;$i<count($istb);$i++)
{
	echo "<p>执行语句【".$istb[$i]."】";
	if($db->exec($istb[$i]))
		echo "<font style='background:lightgray;color:green;'>&nbsp;成功&nbsp;</font>";
	else
		echo "<font style='background:red;color:yellow;font-weight:bold;font-size:28px;'>&nbsp;失败&nbsp;</font>";
	echo "</p>";
}
?>
</body>
</html>