

<?php

##including database connection code
include('database/dbconn.php');

if(isset($_POST['submit'])){
	
	##getting value into variables
	$cat_title=$_POST['cat_title'];
	
	$cat_alias=str_replace(" ","-",$cat_title);
	
	$cat_desc=$_POST['cat_description'];
	
	##checking for image upload
	$cat_image=$_FILES['cat_image']['name'];
	
	if(!empty($cat_image)){
		
		$src_name=$_FILES['cat_image']['tmp_name'];
		
		$filename=date('Ymd_').$cat_image;
		
		$dest_name="upload/news/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		}
	else{
		$filename="";
		}
		
	##chcking for checkbox
	if(isset($_POST['cat_publish'])){
		$cat_publish="Y";
		}
	else{
		$cat_publish="N";
		}
	##database insertion
	
	$sql="INSERT INTO tbl_category VALUES('',
											'$cat_title',
											'$cat_alias',
											'$cat_desc',
											'$filename',
											'$cat_publish')";
	
	$msg=mysql_query($sql);
	
	if($msg){
		
		$msg="Data Successfully Added !!!";
		}
	else{
		$msg="Data Failed to Add!!!";
		}
	
	}



?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Dashboard I Admin Panel</title>
<?php include('inc/top.php');?>
</head>

<body>
<?php include('inc/header.php');?>

<!-- end of header bar -->


<?php include('inc/left_bar.php');?>


<!-- end of sidebar -->

<section id="main" class="column">

<?php if(isset($msg)):?>
  <h4 class="alert_info"><?php echo $msg;?></h4>
<?php endif;?>

  <form action="addCategory.php" method="post" enctype="multipart/form-data">
 
 	<article class="module width_full">
    <header>
      <h3>Add News Category</h3>
    </header>
    <div class="module_content">
      <fieldset>
        <label>Title</label>
        <input type="text" name="cat_title">
      </fieldset>
      <fieldset>
        <label style="float:none !important;">Description</label>
        <textarea rows="12" name="cat_description" class="ckeditor"></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="cat_image">
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="cat_publish">
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" name="submit" value="Submit" class="alt_btn">
      </div>
    </footer>
  </article>
   
   </form>
   
  </article>
  <!-- end of styles article -->
  <div class="spacer"></div>
</section>
</body>
</html>