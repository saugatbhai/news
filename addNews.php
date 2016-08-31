<?php

##including database connection code
include('database/dbconn.php');


##for add news

if(isset($_POST['submit'])){
	
	$cat_id=$_POST['cat_id'];
	
	$news_title=$_POST['news_title'];
	
	$news_alias=strtolower(str_replace(" ","-",$news_title));
	
	$news_date=$_POST['news_date'];
	
	$news_desc=$_POST['news_description'];
	
	##checking for image upload
	$news_image=$_FILES['news_image']['name'];
	
	if(!empty($news_image)){
		
		$src_name=$_FILES['news_image']['tmp_name'];
		
		$filename=date('Ymd_').$news_image;
		
		$dest_name="upload/news/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		}
	else{
		$filename="";
		}
		
	$news_author=$_POST['news_author'];
	
	##chcking for checkbox for feature
	if(isset($_POST['news_feature'])){
		$news_feature="Y";
		}
	else{
		$news_feature="N";
		}
		
	##chcking for checkbox for populoar
	if(isset($_POST['news_popular'])){
		$news_popular="Y";
		}
	else{
		$news_popular="N";
		}
	
	##chcking for checkbox publish
	if(isset($_POST['news_publish'])){
		$news_publish="Y";
		}
	else{
		$news_publish="N";
		}
	
	$sql="INSERT INTO tbl_news VALUES(  '',
										'$cat_id',
										'$news_title',
										'$news_alias',
										'$news_date',
										'$news_desc',
										'$filename',
										'$news_author',
										'$news_feature',
										'$news_popular',
										'$news_publish')";
										
	$msg=mysql_query($sql);
	
	if($msg)
	$msg="News Posted Successfully !!";
	else 
	$msg="Failed to Post News";
	
	}

?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Dashboard I Admin Panel</title>

<?php include('inc/top.php');?>
<body>
<?php include('inc/header.php');?>

<!-- end of header bar -->


<?php include('inc/left_bar.php');?>


<!-- end of sidebar -->

<section id="main" class="column">

  <?php if(isset($msg)):?>
  <h4 class="alert_info"><?php echo $msg;?></h4>
<?php endif;?>
 <form action="addNews.php" method="post" enctype="multipart/form-data">
 	<article class="module width_full">
    <header>
      <h3>Add News</h3>
    </header>
    <div class="module_content">
    	<fieldset >
        <!-- to make two field float next to one another, adjust values accordingly -->
        <label>News Category</label>
        <select style="width:50%;" name="cat_id">
          <option>---Select News Category ---</option>
          
          <?php 
		  
		  $sql="select * from tbl_category";
		  $data=mysql_query($sql);
		  while($c=mysql_fetch_array($data)):
		  ?>
		 	<option value="<?php echo $c['cat_id']?>"><?php echo $c['cat_title']?></option>
            
          <?php endwhile;?>
         
        </select>
      </fieldset>
      
      <fieldset>
        <label>Title</label>
        <input type="text" name="news_title">
      </fieldset>
      <fieldset>
        <label>Date</label>
        <input type="text" name="news_date" id="datepicker">(yyyy-mm-dd)
      </fieldset>
      <fieldset>
        <label style="float:none;">Description</label>
        <textarea rows="12" name="news_description" class="ckeditor"></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="news_image">
      </fieldset>
      <fieldset>
        <label>Author</label>
        <input type="text" name="news_author">
      </fieldset>
      <fieldset>
        <label>Feature</label>
        <input type="checkbox" name="news_feature">
      </fieldset>
      <fieldset>
        <label>Popular</label>
        <input type="checkbox" name="news_popular">
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="news_publish">
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" name="submit" value="Submit" class="alt_btn">
      </div>
    </footer>
  </article>
   
  </article>
  <!-- end of styles article -->
  <div class="spacer"></div>
  
  </form>
</section>

</body>
</html>