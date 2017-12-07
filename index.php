
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>图书管理系统</title>

<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="jumbotron">
				<h1>
					图书管理系统
				</h1>
				
				<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<form class="form-horizontal" role="form" method="POST" action="index.php">
				<div class="form-group">
					 <label  class="col-sm-2 control-label" >账号</label>
					<div class="col-sm-10">
						<input  class="form-control"  name="username"/>
					</div>
				</div>
				<div class="form-group">
					 <label for="inputPassword3" class="col-sm-2 control-label" >密码</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputPassword3" name="passwd"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							 <label><input type="checkbox" name="admin" value="admin"/>admin账号需勾选</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 <button type="submit" class="btn btn-default">登录</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
				
			</div>
		</div>
	</div>
</div>

  
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


<?php
if(!empty($_POST['username']) && !empty($_POST['passwd']) )
{
	if(empty($_POST['admin']))
	{
		$username = $_POST['username'];
		$passwd = $_POST['passwd'];
		include('config.php');
		$sql = "select * from user where snum=$username and passwd='$passwd'";
		$result = mysqli_query($conn,$sql);
		$rows = mysqli_num_rows($result);
		if(!$result)
		{
			die("查询失败");
		}
		if ($rows==0){
			mysqli_close($conn);
			echo "<script>alert('用户名或密码错误');
			window.location.href = 'index.php';</script>";
			exit;
			
		}
		else{
		mysqli_close($conn);
		session_start();
		// store session data
		$_SESSION['id']=$username;
		$_SESSION['admin']='no';
		echo "<script>window.location.href = 'user.php';</script>";
		}
	}
	else
	{
		$username = $_POST['username'];
		$passwd = $_POST['passwd'];
		include('config.php');
		$sql = "select * from admin where adminID=$username and passwd='$passwd'";
		$result = mysqli_query($conn,$sql);
		$rows = mysqli_num_rows($result);
		if(!$result)
		{
			die("查询失败");
		}
		if ($rows==0){
			mysqli_close($conn);
			echo "<script>alert('用户名或密码错误');
			window.location.href = 'index.php';</script>";
			exit;
			
		}
		else{
		mysqli_close($conn);
		session_start();
		// store session data
		$_SESSION['id']=$username;
		$_SESSION['admin']='yes';
		echo "<script>window.location.href = 'admin.php';</script>";
		}
	}
}
?>