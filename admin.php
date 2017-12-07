<?php
session_start();
if(isset($_SESSION['id'])){
	$user=$_SESSION['id'];
	if($_SESSION['admin']!="yes")
	{
		echo "<script>alert('你不是管理员！');window.location.href = 'index.php';</script>";
		session_destroy();
		exit();
	}
}
else{
echo "<script>alert('你还没有登录！');window.location.href = 'index.php';</script>";
exit();
}
?>
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
			<p>管理员：<?php echo $user;?><a  href='admin.php?act=logout'>&nbsp;注销</a></p>			
				<h1>
					图书管理系统
				</h1>
				
				<div class="container">
					<div class="row clearfix">
						<div class="col-md-12 column">
							<div class="row clearfix">
								<div class="col-md-4 column">
								<p><h2>续借</h2></p>
									<form class="form-horizontal" action = "new.php?act=xujie" method = "post" role="form">
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入借书人账号" name="snum" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入被借书号" name="bid" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												 <button type="submit" class="btn btn-default">提交</button>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4 column">
								<p><h2>还书</h2></p>
									<form class="form-horizontal" action = "new.php?act=huanshu" method = "post" role="form">
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入借书人账号" name="snum" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入被借书号" name="bid" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												 <button type="submit" class="btn btn-default">提交</button>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4 column">
								<p><h2>借书</h2></p>
									<form class="form-horizontal" action = "new.php?act=jieshu" method = "post" role="form">
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入借书人账号" name="snum" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入被借书号" name="bid" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												 <button type="submit" class="btn btn-default">提交</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-md-4 column">
								<p><h2>图书录入<small>(存在则填书号和数量)</small></h2></p>
									<form class="form-horizontal" action = "new.php?act=addbook" method = "post" role="form">
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入书号" name="bnum" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入书名" name="bname" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入作者" name="writer" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入出版社" name="publish" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入类别" name="category" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入出版时间" name="year" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入数量" name="total" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												 <button type="submit" class="btn btn-default">提交</button>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4 column">
								<p><h2>借书证办理</h2></p>
									<form class="form-horizontal" action = "new.php?act=adduser" method = "post" role="form">
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入账号" name="snum" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入密码" name="passwd" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入学院" name="academy" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<input type="text" class="form-control" placeholder="请输入姓名" name="sname" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												 <button type="submit" class="btn btn-default">提交</button>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4 column">
								<p><h2>其他功能</h2></p>
									<form class="form-horizontal" role="form">
										<div class="col-sm-offset-2 col-sm-10">
												 <button type="button" class="btn btn-default" onclick="window.open('./new.php?act=allbook')" >查看所有图书</button>
										</div>
										<div class="col-sm-offset-2 col-sm-10">
										<br/>
												 <button type="button" class="btn btn-default"  onclick="window.open('./new.php?act=noreturn')" >过期未还借阅信息</button>
										</div>
										<div class="col-sm-offset-2 col-sm-10">
										<br/>
												 <button type="button" class="btn btn-default"  onclick="window.open('./new.php?act=borrow')" >查看所有借阅信息</button>
										</div>
																				<br/>
												 <p>更多功能，敬请期待...</p>
										</div>
									</form>
								</div>
							</div>
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

if(!empty($_GET['act'])){
	if($_GET['act']=='logout')
	{
		session_destroy();
		echo "<script>window.location.href = 'index.php';</script>";
		exit;
	}
}
?>