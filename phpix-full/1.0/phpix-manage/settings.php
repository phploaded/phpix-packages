<br /><br /><?php 

$title = clean_text($_POST['title']);
$title_length = strlen($title);
$descr = clean_text($_POST['descr']);
$descr_length = strlen($descr);
$access = clean_text($_POST['access']);
$emails = clean_emails($_POST['emails']);

if($title!=''){

if($title_length<3){
notify('<b>Error :</b> Title too short. Minimum 2 letters needed.', 'newalbum', 'danger');
} elseif($title_length>200){
notify('<b>Error :</b> Title too long. Maximum 200 letters allowed.', 'newalbum', 'danger');
} else {

if($descr_length<1){
notify('<b>Warning :</b> You did not added any description for this album. You can do that later by editing that album.', 'newalbum', 'warning');
}

$new_id = uniqid();
$slugged = slugify($title);
$time = time();

$data = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM `".$prefix."albums` WHERE `slug`='$slugged' limit 1"));

	
mysqli_query($con, "UPDATE `".$prefix."albums` SET 
`slug` = '$slugged', 
`access` = '$access', 
`title` = '$title', 
`descr` = '$descr', 
`updated` = '$time' 
WHERE `id`='".$_GET['aid']."'");
notify('<b>Success :</b> Your album <b>'.$title.'</b> was updated successfully.', 'newalbum', 'success');


$zmails = explode(",", $emails); 

mysqli_query($con, "DELETE FROM `".$prefix."access` WHERE `aid`='".$_GET['aid']."'");

foreach($zmails as $key => $val){
mysqli_query($con, "INSERT INTO `".$prefix."access` (`id`, `uid`, `aid`) VALUES (NULL, '$val', '".$_GET['aid']."')");
}

}





}



$data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `".$prefix."albums` WHERE `id`='".$_GET['aid']."'"));

$xdata = mysqli_query($con, "SELECT `uid` FROM `".$prefix."access` WHERE `aid`='".$_GET['aid']."'");

$uid = '';
$mails = array();
while($row = mysqli_fetch_assoc($xdata)){
$mails[] = $row['uid'];
}

$emails = implode(", ", $mails);

 ?>
<div class="container">

<div class="col-xs-12 col-md-2"></div>
<div class="col-xs-12 col-md-8">
<?php echo $notify['newalbum']; ?>
<form action="" autocomplete="off" method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="panel panel-primary">
    <div class="panel-heading text-center">Add Album</div>
	<div class="panel-body">
    <div class="form-group">
      <label for="title" class="col-lg-2 control-label">Title</label>
      <div class="col-lg-10">
        <input value="<?php echo $data['title']; ?>" type="text" name="title" class="form-control" id="title" placeholder="Title">
      </div>
    </div>

    <div class="form-group">
      <label for="descr" class="col-lg-2 control-label">Description</label>
      <div class="col-lg-10">
        <textarea name="descr" class="form-control" rows="3" id="descr"><?php echo $data['descr']; ?></textarea>
        <span class="help-block">Maximum 5000 charectors allowed. Non english charectors may get converted to garbage.</span>
      </div>
    </div>
	
    <div class="form-group">
      <label class="col-lg-2 control-label">Access</label>
      <div class="col-lg-10">
        <div class="radio">
          <label>
          <input type="radio" class="radiobtn" name="access" id="optionpublic" value="public" checked="">
          <b>Public</b> - Anyone can view. Visible from album list.
          <span class="help-block">For photos that can be shared publicly. Examples - parties, travel, food, etc.</span>
		  </label>
		  
        </div>
        <div class="radio radiotoggle">
          <label>
            <input type="radio" class="radiobtn" name="access" id="optionprivate" value="private">
            <b>Private</b> - Choose who can view, by entering their email.
          <span class="help-block">Suitable for private photos. Examples - secret documents, ID cards, erotic or arousing photos, personal screenshots</span>
		  </label>
		  
			<div id="aids" class="collapse">
			<span class="help-block">Enter the email IDs of people allowed to view this album. IDs should be separated by space or comma.</span>
			<textarea name="emails" class="form-control" rows="3" id="emails"><?php echo $emails; ?></textarea>
			</div>
        </div>
      </div>
    </div>
	


    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-success">Save Changes</button>
      </div>
    </div>
	</div>
  </div>
</form>
</div>
<div class="col-xs-12 col-md-2"></div>

</div>
<script>
jQuery(document).ready(function(){
jQuery('#option<?php echo $data[access]; ?>').trigger('click');
});
</script>