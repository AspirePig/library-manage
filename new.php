<?php
session_start();
if(isset($_SESSION['id'])){
	$user=$_SESSION['id'];
	$admin = $_SESSION['admin'];
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
			<?php
			if($admin=="yes")
			{
				echo <<<HTML
				<p>管理员：$user<a  href='admin.php'>&nbsp;管理界面</a><a  href='admin.php?act=logout'>&nbsp;注销</a></p>
HTML;
			}
			else
			{
				echo <<<HTML
				<p>用户：$user<a  href='user.php'>&nbsp;图书查询</a><a  href='user.php?act=logout'>&nbsp;注销</a></p>
HTML;
			}
				
			?>
			
				<h1>
					图书管理系统
				</h1>
				

				
				<!-- 查询结果展示区-->
				<div id="container">


<?php
if(!empty($_GET['act'])){
	$key = $user;
	//我的借阅功能
	if($_GET['act']=='mybrrow')
	{
		if($admin != "no")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$sql="SELECT book.bnum,book.bname,borrow.bdate,borrow.rdate,borrow.realtime,borrow.breturn FROM book,borrow WHERE book.bnum=borrow.bid and snum = '$key'" ;
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
							<h2>你没有借阅书籍</h2>
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
							<th>借期</th>
							<th>还书截止日</th>
							<th>实际还书日</th>
							<th>是否还书</th>
						</tr>
					</thead>
					<tbody>
HTML;

			while($row=mysqli_fetch_array($query))
			{
				echo <<<BOOK
				<tr>
				<td>$row[0]</td>
				<td>$row[1]</td>
				<td>$row[2]</td>
				<td>$row[3]</td>
				<td>$row[4]</td>
				<td>$row[5]</td>
				</tr>
BOOK;
			}
		}	
	echo <<<ETO
							</tbody>
						</table>
ETO;
	}

	//续借功能
	if($_GET['act']=='xujie')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$snum = $_POST['snum'];
		$bid = $_POST['bid'];
		if(empty($snum) || empty($bid))
		{
			echo "<script>alert('填写完整信息');window.location.href = 'admin.php';</script>";
			exit();
		}
		$sql="select rdate,breturn from borrow where snum=$snum and bid='$bid'";
		include('config.php');
		$query=mysqli_query($conn,$sql);
		if(mysqli_num_rows($query)==0)
		{
			mysqli_close($conn);
			echo "<script>alert('没有此项借书记录');window.location.href = 'admin.php';</script>";
			exit();
		}
		else
		{
			$rows = mysqli_fetch_assoc($query);
			if($rows['breturn'])
			{
				mysqli_close($conn);
				echo "<script>alert('该书已还');window.location.href = 'admin.php';</script>";
				exit();
			}
			$sql="update borrow set rdate = DATE_ADD(rdate, Interval 30 day) where snum=$snum and bid='$bid'";
			if($query=mysqli_query($conn,$sql))
			{
				echo "<script>alert('续借成功');window.location.href = 'admin.php';</script>";
			}
			mysqli_close($conn);
			exit();
		}	
	}

	//还书功能
		if($_GET['act']=='huanshu')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$snum = $_POST['snum'];
		$bid = $_POST['bid'];
		if(empty($snum) || empty($bid))
		{
			echo "<script>alert('填写完整信息');window.location.href = 'admin.php';</script>";
			exit();
		}
		$sql="select rdate,breturn from borrow where snum=$snum and bid='$bid'";
		include('config.php');
		$query=mysqli_query($conn,$sql);
		if(mysqli_num_rows($query)==0)
		{
			mysqli_close($conn);
			echo "<script>alert('没有此项借书记录');window.location.href = 'admin.php';</script>";
			exit();
		}
		else
		{
			$rows = mysqli_fetch_assoc($query);
			if($rows['breturn'])
			{
				mysqli_close($conn);
				echo "<script>alert('该书已还');window.location.href = 'admin.php';</script>";
				exit();
			}
			$sql="update borrow set realtime =  curdate(),breturn=1 where snum=$snum and bid='$bid'";
			if($query=mysqli_query($conn,$sql))
			{
				$sql="update book set inventory =  inventory+1 where  bnum='$bid'";
				mysqli_query($conn,$sql);
				echo "<script>alert('还书成功');window.location.href = 'admin.php';</script>";
			}
			mysqli_close($conn);
			exit();
		}	
	}

	//借书功能
		if($_GET['act']=='jieshu')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$snum = $_POST['snum'];
		$bid = $_POST['bid'];
		if(empty($snum) || empty($bid))
		{
			echo "<script>alert('填写完整信息');window.location.href = 'admin.php';</script>";
			exit();
		}
		$sql="select * from user where snum=$snum"; 
		include('config.php');
		$query=mysqli_query($conn,$sql);
		if(mysqli_num_rows($query)==0)
		{
			mysqli_close($conn);
			echo "<script>alert('不存在该用户');window.location.href = 'admin.php';</script>";
			exit();
		}
		else
		{
			$sql="update book set inventory =  inventory-1 where inventory>0 and bnum='$bid'";
			$query=mysqli_query($conn,$sql);
			if(mysqli_affected_rows($conn))
			{
				$sql="insert into borrow values(NULL,$snum,'$bid',curdate(),DATE_ADD(curdate(), Interval 30 day),'1970-01-01','$user',0)";
				if($query=mysqli_query($conn,$sql))
				{
					mysqli_close($conn);
					echo "<script>alert('借书成功');window.location.href = 'admin.php';</script>";
				}
			}
		}	
	}

	//添加user
		if($_GET['act']=='adduser')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$snum = $_POST['snum'];
		$passwd = $_POST['passwd'];
		$academy = $_POST['academy'];
		$sname = $_POST['sname'];
		
		if(empty($snum) || empty($passwd) || empty($academy) || empty($sname))
		{
			echo "<script>alert('填写完整信息');window.location.href = 'admin.php';</script>";
			exit();
		}
		$sql="select * from user where snum=$snum"; 
		include('config.php');
		$query=mysqli_query($conn,$sql);
		if(mysqli_num_rows($query)!=0)
		{
			mysqli_close($conn);
			echo "<script>alert('已存在该账号');window.location.href = 'admin.php';</script>";
			exit();
		}
		else
		{
			$sql="insert into user values(NULL,$snum,'$passwd','$academy','$sname')";
			$query=mysqli_query($conn,$sql);
			if($query)
			{
				mysqli_close($conn);
				echo "<script>alert('添加借书证成功');window.location.href = 'admin.php';</script>";
			}
		}	
	}

	//录入图书
		if($_GET['act']=='addbook')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$bnum = $_POST['bnum'];
		$bname = $_POST['bname'];
		$writer = $_POST['writer'];
		$publish = $_POST['publish'];
		$category = $_POST['category'];
		$year = $_POST['year'];
		$total = $_POST['total'];


		$sql="select * from book where bnum='$bnum'"; 
		include('config.php');
		$query=mysqli_query($conn,$sql);
		if(mysqli_num_rows($query)!=0)
		{
			$sql="update book set total = total + $total,inventory = inventory +$total where bnum = '$bnum'"; 
			$query=mysqli_query($conn,$sql);
			if($query)
			{
				echo "<script>alert('添加库存完毕');window.location.href = 'admin.php';</script>";
				exit();
			}
		}
		else
		{
			$sql="insert into book values(NULL,'$bnum','$bname','$writer','$publish','$category','$year',$total,$total)";
			$query=mysqli_query($conn,$sql);
			if($query)
			{
				mysqli_close($conn);
				echo "<script>alert('录入图书成功');window.location.href = 'admin.php';</script>";
			} 
		}	
	}

	//查看所有图书
		if($_GET['act']=='allbook')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$sql="SELECT * FROM book " ;
		include('config.php');
		$query=mysqli_query($conn,$sql);
		echo <<<HTML
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>所有图书</h2>
					</div>
				</div>
				
				<table class="table" align='center'>
				<thead>
					<tr>
						<th>id</th>
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
			<td>$row[0]</td>
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
		echo <<<ETO
						</tbody>
					</table>
ETO;
	}
	
	//查看过期未还的图书
			if($_GET['act']=='noreturn')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$sql="SELECT * FROM `borrow` WHERE `rdate` < curdate() AND `breturn` = 0" ;
		include('config.php');
		$query=mysqli_query($conn,$sql);
		echo <<<HTML
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>过期未还的借阅信息</h2>
					</div>
				</div>
				
				<table class="table" align='center'>
				<thead>
					<tr>
						<th>id</th>
						<th>账号</th>
						<th>书号</th>
						<th>借书日期</th>
						<th>应还日期</th>
						<th>操作员</th>
					</tr>
				</thead>
				<tbody>
HTML;

		while($row=mysqli_fetch_array($query))
		{
			echo <<<BOOK
			<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td>$row[6]</td>
			</tr>
BOOK;
		}
		mysqli_close($conn);	
		echo <<<ETO
						</tbody>
					</table>
ETO;
	}
	
	//查看所有借阅信息
			if($_GET['act']=='borrow')
	{
		if($admin != "yes")
		{
			echo "<script>alert('你没有权限');window.location.href = 'index.php';</script>";
			exit();
		}
		$sql="SELECT * FROM `borrow` order by id" ;
		include('config.php');
		$query=mysqli_query($conn,$sql);
		echo <<<HTML
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h2>所有借阅信息</h2>
					</div>
				</div>
				
				<table class="table" align='center'>
				<thead>
					<tr>
						<th>id</th>
						<th>账号</th>
						<th>书号</th>
						<th>借书日期</th>
						<th>应还日期</th>
						<th>还书日期</th>
						<th>操作员</th>
					</tr>
				</thead>
				<tbody>
HTML;

		while($row=mysqli_fetch_array($query))
		{
			$temp = $row[7]?$row[5]:"未还书";
			echo <<<BOOK
			<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td>$temp</td>
			<td>$row[6]</td>
			</tr>
BOOK;
		}
		mysqli_close($conn);	
		echo <<<ETO
						</tbody>
					</table>
ETO;
	}
	
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
