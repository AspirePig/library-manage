<?php
session_start();
if(isset($_SESSION['id'])){
	$user=$_SESSION['id'];
	if($_SESSION['admin']!="no")
	{
		echo "<script>alert('管理员不要到处乱跑！');window.location.href = 'index.php';</script>";
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
			<p>用户：<?php echo $user;?><a  href='new.php?act=mybrrow'>&nbsp;我的借阅</a><a  href='user.php?act=logout'>&nbsp;注销</a></p>
				<h1>
					图书管理系统
				</h1>
				
				<!-- 查询区域-->
				<div id="container">
					<form  class="form-inline" role="form" action="user.php" method="get" >    
						<div class="form-group">
							<select  class="form-control"  name="serachtype" size="1" style="width:100px;">
									<option value="bname">书名</option>
									<option value="writer">作者</option>
									<option value="category">类别</option>
									<option value="bnum">书号</option>
									<option value="publish">出版社</option>
									<option value="series">丛书名</option>
							</select>
							<div class="form-group">
								<input type="text" class="form-control" name="key"  placeholder="请输入关键词">
							</div>
								<button type="submit" class="btn btn-default">提交</button>
							</div>
					</form>
				</div>	
				
				<!-- 查询结果展示区-->
				<div id="container">


<?php
if(!empty($_GET['key'])){
	$key = $_GET['key'];
	$serachtype = $_GET['serachtype'];
	$sql="SELECT * FROM book WHERE $serachtype like '%".$key."%'" ;
	include('config.php');
	$query=mysqli_query($conn,$sql);
	if(mysqli_num_rows($query)==0)
	{
		mysqli_close($conn);
		echo <<<HTML
		<div id="container">
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>查询结果</h2>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>未查询到符合条件的书籍</h2>
					</div>
		</div>
HTML;
		
		exit;
	}
	else
	{
		echo <<<HTML
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>查询结果</h2>
					</div>
				</div>
				
				<table class="table" align='center'>
				<thead>
					<tr>
						<th>书号</th>
						<th>书名</th>
						<th>作者</th>
						<th>出版社</th>
						<th>类别</th>
						<th>出版时间</th>
						<th>总藏书量</th>
						<th>剩余馆存</th>
					</tr>
				</thead>
				<tbody>
HTML;

		while($row=mysqli_fetch_array($query))
		{
			echo <<<BOOK
			<tr>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td>$row[5]</td>
			<td>$row[6]</td>
			<td>$row[7]</td>
			<td>$row[8]</td>
			</tr>
BOOK;
		}
		mysqli_close($conn);
	}	
echo <<<ETO
						</tbody>
					</table>
ETO;
}


?>
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
		header("Location:index.php"); 
		exit;
	}
}
?>