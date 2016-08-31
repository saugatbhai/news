<?php

##including database connection code
include('database/dbconn.php');


##for add news

if(isset($_POST['submit'])){
	
	$news_id=$_POST['news_id'];
		
	$cat_id=$_POST['cat_id'];
	
	$news_title=$_POST['news_title'];
	
	$news_alias=strtolower(str_replace(" ","-",$news_title));
	
	$news_date=$_POST['news_date'];
	
	$news_desc=$_POST['news_description'];
	
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
	
	##checking for image upload
	$news_image=$_FILES['news_image']['name'];
	
	if(!empty($news_image)){
		
		$src_name=$_FILES['news_image']['tmp_name'];
		
		$filename=date('Ymd_').$news_image;
		
		$dest_name="upload/news/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		
	$sql="UPDATE tbl_news set 	cat_id='$cat_id',
								news_title='$news_title',
								news_alias='$news_alias',
								news_date='$news_date',
								news_description='$news_desc',
								news_image='$filename',
								news_author='$news_author',
								news_feature='$news_feature',
								news_popular='$news_popular',
								news_publish='$news_publish' WHERE news_id='$news_id'";
		
		}
	else{
			
		
	
	
	$sql="UPDATE tbl_news set 	cat_id='$cat_id',
								news_title='$news_title',
								news_alias='$news_alias',
								news_date='$news_date',
								news_description='$news_desc',
								news_author='$news_author',
								news_feature='$news_feature',
								news_popular='$news_popular',
								news_publish='$news_publish' WHERE news_id='$news_id'";
										
		}
		
										
	$msg=mysql_query($sql) or die(mysql_error());
	header("location:manageNews.php");
	
	}
	
	
if(isset($_GET['id'])){
	
	$id=$_GET['id'];
	
	$sql="SELECT * from tbl_news WHERE news_id='$id'";
	
	$data=mysql_query($sql);
	
	$edit=mysql_fetch_assoc($data);

	
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
 <form action="editNews.php" method="post" enctype="multipart/form-data">
 	<input type="text" name="news_id" value="<?php echo $edit['news_id']?>">
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
		  
		  	if($edit['cat_id']==$c['cat_id']):
		  
		  ?>
		 	<option value="<?php echo $c['cat_id']?>" selected="selected"><?php echo $c['cat_title']?></option>
            
          <?php 
		  else:
		  ?>
          <option value="<?php echo $c['cat_id']?>"><?php echo $c['cat_title']?></option>
          <?php
		  
		  endif;
		  
		  endwhile;?>
         
        </select>
        <?php echo $edit['cat_id']?>
      </fieldset>
      
      <fieldset>
        <label>Title</label>
        <input type="text" name="news_title" value="<?php echo $edit['news_title']?>">
      </fieldset>
      <fieldset>
        <label>Date</label>
        <input type="text" name="news_date" value="<?php echo $edit['news_date']?>">(yyyy-mm-dd)
      </fieldset>
      <fieldset>
        <label>Description</label>
        <textarea rows="12" name="news_description"><?php echo $edit['news_description']?></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="news_image">
        <img src="upload/news/<?php echo $edit['news_image']?>" width="100">
      </fieldset>
      <fieldset>
        <label>Author</label>
        <input type="text" name="news_author" value="<?php echo $edit['news_author']?>">
      </fieldset>
      <fieldset>
        <label>Feature</label>
        <input type="checkbox" name="news_feature" <?php if($edit['news_feature']=='Y') echo "checked='checked'";?>>
      </fieldset>
      <fieldset>
        <label>Popular</label>
        <input type="checkbox" name="news_popular" <?php if($edit['news_popular']=='Y') echo "checked='checked'";?>>
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="news_publish" <?php if($edit['news_publish']=='Y') echo "checked='checked'";?>>
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" name="submit" value="Update" class="alt_btn">
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