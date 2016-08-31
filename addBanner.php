<?php

##including database connection code
include('database/dbconn.php');

if(isset($_POST['submit'])){
	
	##getting value into variables
	$banner_title=$_POST['banner_title'];
	$banner_desc=$_POST['banner_description'];
	
	##checking for image upload
	$banner_image=$_FILES['banner_image']['name'];
	
	if(!empty($banner_image)){
		
		$src_name=$_FILES['banner_image']['tmp_name'];
		
		$filename=date('Ymd_').$banner_image;
		
		$dest_name="upload/banner/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		}
	else{
		$filename="";
		}
		
	##chcking for checkbox
	if(isset($_POST['banner_publish'])){
		$banner_publish="Y";
		}
	else{
		$banner_publish="N";
		}
	##database insertion
	
	$sql="INSERT INTO tbl_banner VALUES('','$banner_title','$banner_desc','$filename','$banner_publish')";
	
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
 
 	<form name="addbanner" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
 	<article class="module width_full">
    <header>
      <h3>Add New Banner</h3>
    </header>
    <div class="module_content">
      <fieldset>
        <label>Title</label>
        <input type="text" name="banner_title">
      </fieldset>
      <fieldset>
        <label>Description</label>
        <textarea rows="12" name="banner_description"></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="banner_image">
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="banner_publish" value="Y">
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" value="Submit" name="submit" class="alt_btn">
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