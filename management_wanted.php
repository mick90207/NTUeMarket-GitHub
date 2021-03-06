<? include("header.php");?>
	<div id="main">
    <center>
        <div class="row">
            <div class="col-md-1">
       		   </div>
            <div class="col-md-2" align="left">
<table class="table table-hover">
<tr><td onClick="location.href='management.php'"><center>我的商品</center></td></tr>
<tr><td class="success" onClick="location.href='management_wanted.php'"><center>我的需求</center></td></tr>
<tr><td onClick="location.href='management_removed.php'"><center>已下架商品/需求</center></td></tr>
<tr><td onClick="location.href='management_idle.php'"><center>閒置商品/需求</center></td></tr>
</table>  
            </div>
  			<div class="col-md-9">
			<?php //MySQL
session_start();
$username=$_SESSION['MM_Username']; 
include_once("mysql_info.php");
$sql = "select m.id, m.username, i.* from member m, item_wanted i where m.id = i.owner and m.username = '$username' and status = 1 order by i.id desc"; 
$result = mysqli_query($link,$sql); // 執行SQL查詢
$total_fields=mysqli_num_fields($result); // 取得欄位數
$total_records=mysqli_num_rows($result);  // 取得記錄數
$totalCount = ceil($total_records/3)*3;
echo '<table align=left>';
  for($k = 0; $k < $totalCount; $k ++) {

        if($k%3 == 0) { echo '<tr class="row">'; }

        if($row = mysqli_fetch_array($result)) {
          echo '<td class="col-xs-9 col-md-4 col-md-offset-1">
                  <div class="item_wrapper" style="min-width:240px;">
                  <form action="management_wanted_database.php" method="post" style="max-width:360px">
                    <table class="manage_item_table" width="100%">
                      <tr>
                        <td style="min-width:35px">名稱</td>
                        <td>
                          <input type="text" name="name" class="form-control" value="'. $row[name].'">
                          <input type="hidden" name="id" value="'.$row['id'].'"/>
                        </td>
                      </tr>
                      <tr>
                        <td style="vertical-align:middle;">描述</td>
                        <td >
                          <textarea name="detail" id="detail" pattern=".{0,100}" class="form-control" rows="3">'.$row[detail].'</textarea>
                        </td>
                      </tr>
                      <tr>
                        <td>價格</td>
                        <td>
                          <input type="text" name="price" class="form-control" value="'.$row[price].'">
                        </td>
                      </tr>
                      <tr>
                        <td>方式</td>
                        <td>
                          <input type="text" name="method" class="form-control" value="'.$row[method].'">
                        </td>
                      </tr>
                      <tr>
                        <td>分類</td>
                        <td>
          		            <select name="sort" id="sort" class="form-control">'; ?>
                          
                            <option value="" <?php if($row['sort']=='') echo 'selected=selected'; ?>>商品分類</option>
                            <option value="life" <?php if($row['sort']=='life') echo 'selected=selected'; ?>>生活用品</option>
                            <option value="sport" <?php if($row['sort']=='sport') echo 'selected=selected'; ?>>運動用品</option>
                            <option value="3c" <?php if($row['sort']=='3c') echo 'selected=selected'; ?>>3C產品</option>
                            <option value="transportation" <?php if($row['sort']=='transportation') echo 'selected=selected'; ?>>交通工具</option>
                            <option value="clothes" <?php if($row['sort']=='clothes') echo 'selected=selected'; ?>>衣褲鞋帽</option>
                            <option value="stationary" <?php if($row['sort']=='stationary') echo 'selected=selected'; ?>>文具</option>
                            <option value="book" <?php if($row['sort']=='book') echo 'selected=selected'; ?>>課外讀物</option>
                            <option value="textbook" <?php if($row['sort']=='textbook') echo 'selected=selected'; ?>>教科書</option>
                            <option value="makeup" <?php if($row['sort']=='makeup') echo 'selected=selected'; ?>>美妝保養</option>
                            <option value="furniture" <?php if($row['sort']=='furniture') echo 'selected=selected'; ?>>傢俱</option>
                            <option value="games" <?php if($row['sort']=='games') echo 'selected=selected'; ?>>各式遊戲</option>
                            <option value="else" <?php if($row['sort']=='else') echo 'selected=selected'; ?>>其他</option>
                            <option value="giving" <?php if($row['sort']=='giving') echo 'selected=selected'; ?>>贈送</option>

                          <?php 
                    echo '</select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <center>
                            <input type="submit" value="修改" class="btn btn-success">
                            <input type="hidden" value="want" name="type">
                            <input type="submit" class="btn btn-danger" value="撤下" formaction="delete_wanted.php"">
                          </center>
                        </td>
                      </tr>
                    </table>
                  </form>
                  </div>
                </td>';
        }
                else{
          echo "<td class=\"col-xs-9 col-md-4 col-md-offset-1\"></td>";
        }

        if($k%3 == 2) {
          echo '</tr>';
        }
  }
echo '</table>';
               
            ?>
            </div>
        </div>
       </center>
	</div><!-- // end #main -->
</div>
<? include("footer.php");?>