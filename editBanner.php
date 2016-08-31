<?php

##including database connection code
include('database/dbconn.php');


if(isset($_GET['id'])){
	
	$id=$_GET['id'];
		
	$sql="SELECT * FROM tbl_banner WHERE banner_id='$id'";
	
	$data=mysql_query($sql);
	
	$edit=mysql_fetch_assoc($data);

	
	}



if(isset($_POST['submit'])){
	
	##getting value into variables
	$banner_id=$_POST['banner_id'];
	$banner_title=$_POST['banner_title'];
	$banner_desc=$_POST['banner_description'];
	
	##chcking for checkbox
	if(isset($_POST['banner_publish'])){
		$banner_publish="Y";
		}
	else{
		$banner_publish="N";
		}
	
	##checking for image upload
	$banner_image=$_FILES['banner_image']['name'];
	
	if(!empty($banner_image)){
		
		$src_name=$_FILES['banner_image']['tmp_name'];
		
		$filename=date('Ymd_').$banner_image;
		
		$dest_name="upload/banner/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		$sql="UPDATE tbl_banner set banner_title='$banner_title',banner_description='$banner_desc',banner_publish='$banner_publish',banner_image='$filename' WHERE banner_id='$banner_id'";
		
		}
	else{
		$sql="UPDATE tbl_banner set banner_title='$banner_title',banner_description='$banner_desc',banner_publish='$banner_publish' WHERE banner_id='$banner_id'";
		}
		
	
	##database insertion
	
	
	mysql_query($sql);
	
	header("location:manageBanner.php");

	}



?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Dashboard I Admin Panel</title>
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

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
 	<input type="hidden" name="banner_id" value="<?php if(isset($edit)) echo $edit['banner_id'];?>">
    <article class="module width_full">
    <header>
      <h3>Edit Banner</h3>
    </header>
    <div class="module_content">
      <fieldset>
        <label>Title</label>
        <input type="text" name="banner_title" value="<?php if(isset($edit)) echo $edit['banner_title'];?>">
      </fieldset>
      <fieldset>
        <label>Description</label>
        <textarea rows="12" name="banner_description"><?php if(isset($edit)) echo $edit['banner_description']?></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="banner_image">
        <?php if(isset($edit) && !empty($edit['banner_image'])):?>
        <img src="upload/banner/<?php echo $edit['banner_image']?>" width="80">
        <?php endif;?>
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="banner_publish" value="Y" <?php if(isset($edit) && $edit['banner_publish']=='Y') echo "checked='checked'";?>>
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" value="Update" name="submit" class="alt_btn">
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