<?php

//測試檔案

$valid_formats = array("jpg","JPG","jpeg", "JPEG","png","PNG", "gif","GIF","BMP","bmp");
$max_file_size = 1024*100; //100 kb
$resized_img_width = 700; //700px
$folderPath = "Picture/"; // Upload directory
$count = 0;
$checkExt = "";
$checkSize = "";
$checkmsg = "";
$file_name = "";
$fileRenamed = "";
$successUpload = false;
$errorFiles = "";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

	foreach ($_FILES['files']['name'] as $f => $file_name) { 

		if ($_FILES['files']['error'][$f] == 4) {
			$file_name = strtolower($file_name);
			$successUpload = false;
			$errorFiles .= $_FILES['files']['name'][$f].",";
		    continue; // Skip file if any error found
		}

	    if ($_FILES['files']['error'][$f] == 0) {
			//判斷檔案格式
	    	if(!in_array(pathinfo($file_name, PATHINFO_EXTENSION), $valid_formats)){

	    		$checkExt ="檔案格式不符(jpg,gif,png)";
	    		$errorFiles .= $_FILES['files']['name'][$f].",";
	    		continue;
	    	}else{
	    		$checkExt = "ok";
	    		$fn_array=explode(".",$file_name);//分割檔名
				$mainName = $fn_array[0];//檔名
				$ext = $fn_array[1];//副檔名
			}	

			if($count==0){
				//重新命名檔案
				$fileRenamed = md5($_SESSION['MM_Username'].date("ymdHis"));
			}
			
			$file_name = sprintf("%s_%d",$fileRenamed,$count+1);

			//檔名重覆處理
			while(file_exists($folderPath . basename(sprintf("%s",$file_name)))){

				$fileRenamed = md5($_SESSION['MM_Username'].date("ymdHis"));
				$file_name = sprintf("%s_%d",$fileRenamed,$count+1);
			}


			$image_info = getimagesize($_FILES['files']['tmp_name'][$f]);
			$image_type = $image_info[2];
			$image;

			switch($image_type){
				case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($_FILES['files']['tmp_name'][$f]); 
				break;
				case IMAGETYPE_GIF:
				$image = imagecreatefromgif($_FILES['files']['tmp_name'][$f]); 
				break;
				case IMAGETYPE_PNG:
				$image = imagecreatefrompng($_FILES['files']['tmp_name'][$f]); 
				break;
			}

			//重設檔案大小
			$ratio = $resized_img_width / imagesx($image);
			$height = imagesy($image) * $ratio; 
			$new_image = imagecreatetruecolor($resized_img_width, $height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $resized_img_width, $height, imagesx($image), imagesy($image));
			$successUpload = imagejpeg($new_image,$folderPath.$file_name.".jpg");
			$checkSize = "ok";

			if($successUpload)
				$count++;	

		}

	}

	if($successUpload && $count>=1){

		// mySQL資料庫
		session_start();
		$username=$_SESSION['MM_Username'];
		$user_id=$_SESSION['MM_UserID'];
		$currtimestr=date("Y-m-d H:i:s"); 
		include_once("mysql_info.php");


//取得使用者ip
if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   $ip = $_SERVER['HTTP_CLIENT_IP'];
}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
   $ip= $_SERVER['REMOTE_ADDR'];
}
$counter=file("counter.txt") ;
$log_now=$currtimestr.'['.$ip.']使用者'.$username."上傳商品----瀏覽人次：".$counter[0].'<br>';
mysqli_query ($link,"update Stastic set Log=CONCAT(Log,'$log_now'), Upload_sell=CONCAT(Upload_sell,'$log_now')");

		// $sql = "select id from member where username = '$username'";
		// $result = mysqli_query($link,$sql);
		// $row = mysqli_fetch_array($result);
		// $user_id = $row['id'];
		if ($_POST[name]==NULL)
			$name="未命名";
		else
			$name=$_POST[name];
		$success = mysqli_query ($link,"insert into item_forsell(name,detail,price,method,sort,filename,img_count,date,owner,msg_welcome,phone,contact_email)

			values('$name','$_POST[detail]','$_POST[price]','$_POST[method]','$_POST[sort]','$fileRenamed','$count','$currtimestr','$user_id','$_POST[message]','$_POST[phone]','$_POST[contact_email]')");

		if(!$success){
			echo '<pre>';
			printf("Failed to insert into database.");
			echo '</pre>';
		}
		header("Location: upload_item_succeed.php");
	}

	//錯誤,無法上傳
	else{
		$checkmsg = sprintf("1.檔案格式：%s<hr>2.檔案大小：%s<hr>3.上傳檔案：%s ",$checkExt,$checkSize,$errorFiles);
		header('Content-type: text/html; charset=utf-8');
		printf("<b style='color:red;'>上傳失敗,請洽系統管理員</b><hr>%s",$checkmsg);
	}

}
//沒有選取檔案
else {
	header('Content-type: text/html; charset=utf-8');
	printf("<b style='color:red;'>錯誤,沒有選取檔案</b>");
}?>