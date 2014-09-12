<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="我們試圖建立一個屬於台大人的二手交換電子商務平台，你可能會有想要買/賣/贈送的二手教科書，要搬家出清的家具、用不到的衣服雜物。你可以藉由社群成員具有需求同質性高、地利之便的優勢，很快找到買/賣家、很方便遞交/接收物品，最重要的是能讓物盡其用，每一分資源都不被浪費。" />
    <meta name="keywords" content="台大,二手物,交換平台,電子商務" />
    <title>NTUeMarket</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />	
	<link href="css/nivo-slider.css" rel="stylesheet" type="text/css" />
    <!--[if IE]><link href="css/style-ie.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!-- jQuery (使用Bootstrap的JavaScript外掛) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- jQuery (使用Bootstrap的JavaScript外掛) -->
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.nivo.slider.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$('#slideshow').nivoSlider({
				directionNav: false
			});
		});
	</script>
        <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style-ie.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 shim 和 Respond.js 讓IE8支援HTML5元素和媒體查詢 -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- 在下面加入所有已編譯外掛，或是當需要時加入獨立檔案 -->
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<div id="wrapper">
	<div id="header">
		<div class="container">
			<h1>
				<a href="default.php" title="NTUeMarket">NTUeMarket</a>
		  </h1>
		  <ul class="menu fr">
                 <li><a href="upload_area.php">上傳商品</a></li>
                 <li><a href="upload_wanted.php">公開徵求</a></li>
                 <li><a href="show_item.php">商品總覽</a></li>
                 <li><a href="show_item_wanted.php">需求總覽</a></li>
                 <li class="dropdown" id="twohandedmenu">
                        
                       
<?php //已經登入
if (isset($_SESSION['MM_Username'])){ ?>
<a class="dropdown-toggle" data-toggle="dropdown" href="show_item.php">會員專區<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="modify.php">修改資料</a></li>
                            <li><a href="management.php">管理商品</a></li>
							<li><a href="message_area.php">私人訊息</a></li>
                            <li><a href="logout.php">登出</a></li>
<?php //尚未登入
} else{ ?><a class="dropdown-toggle" data-toggle="dropdown" href="show_item.php">會員註冊/登入<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        	<li><a href="registration.php">會員註冊</a></li>
                            <li><a href="login.php">會員登入</a></li> 
                            <?php }?>
                                                    </ul>
                    </li>
				<!--<li><a href="contact-us.php">聯絡我們</a></li>!-->
                <li><a href="contact_us.php">聯絡我們</a></li>
		  </ul>
		</div>
	</div><!-- // end #header -->
