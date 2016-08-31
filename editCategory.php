<?php 

##creating object
$obj=new Dbconnection;

##for edit operation

if(isset($_GET['id']) && $_GET['action']=='edit'){
	
	$id=$_GET['id'];

	$sql="SELECT * FROM tbl_category WHERE cat_id='$id'";
	
	$data=$obj->Query($sql);
	
	$edit=$obj->Fetch($data);

}




if(isset($_POST['submit']) && $_GET['action']=='update'){
	
	$cat_id=$_POST['cat_id'];
	
	$cat_title=$_POST['cat_title'];
	
	$cat_desc=$_POST['cat_description'];
	
	##checkbox part
	
	if(isset($_POST['cat_publish'])){
		
		$cat_publish="Y";
		
		}
	else{
		$cat_publish="N";
		}
	
	##checking for image
	
	$cat_image=$_FILES['cat_image']['name'];
	
	if(!empty($cat_image)){
		
		$src_name=$_FILES['cat_image']['tmp_name'];
		
		$filename=date('Ymd_').$cat_image;
		
		$dest_name="upload/news/".$filename;
		
		move_uploaded_file($src_name,$dest_name);
		
		$sql="UPDATE tbl_category set cat_title='$cat_title',cat_description='$cat_desc',cat_publish='$cat_publish',cat_image='$filename' WHERE cat_id='$cat_id'";
		
		
		}
	else
		$sql="UPDATE tbl_category set cat_title='$cat_title',cat_description='$cat_desc',cat_publish='$cat_publish' WHERE cat_id='$cat_id'";
		
	
	##database operation
	
	$obj->Query($sql);
	
	header("location:index.php?page=modules/news/manageCategory");
	
	}



?>

<section id="main" class="column">

<?php if(isset($msg)):?>
  <h4 class="alert_info"><?php echo $msg;?></h4>
<?php endif;?>

  <form action="index.php?page=modules/news/editCategory&action=update" method="post" enctype="multipart/form-data">
 	<input type="hidden" name="cat_id" value="<?php if(isset($edit)) echo $edit['cat_id']?>">
 	<article class="module width_full">
    <header>
      <h3>Add News Category</h3>
    </header>
    <div class="module_content">
      <fieldset>
        <label>Title</label>
        <input type="text" name="cat_title" value="<?php if(isset($edit)) echo $edit['cat_title']?>">
      </fieldset>
      <fieldset>
        <label>Description</label>
        <textarea rows="12" name="cat_description"><?php if(isset($edit)) echo $edit['cat_title']?></textarea>
      </fieldset>
      <fieldset>
        <label>Image</label>
        <input type="file" name="cat_image">
        <?php if(isset($edit)):?>
        <img src="upload/news/<?php echo $edit['cat_image']?>" width="80"/>
        <?php endif;?>
      </fieldset>
      <fieldset>
        <label>Publish</label>
        <input type="checkbox" name="cat_publish" <?php if(isset($edit) && $edit['cat_publish']=='Y') echo "checked='checked'";?>>
      </fieldset>
      
      <div class="clear"></div>
    </div>
    <footer>
      <div class="submit_link">
        
        <input type="submit" name="submit" value="Update" class="alt_btn">
      </div>
    </footer>
  </article>
   
   </form>
   
  </article>
  <!-- end of styles article -->
  <div class="spacer"></div>
</section>
