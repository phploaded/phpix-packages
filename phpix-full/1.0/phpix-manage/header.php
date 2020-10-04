<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">

<title><?php echo $website_name; ?> Management</title>
<?php $mlib_domain = $domain.'medialibv2/'; ?>
<script>
main_domain = '<?php echo $domain; ?>';
mlib_domain = '<?php echo $mlib_domain; ?>';
albumFILE = '<?php echo $albumFILE; ?>';
</script>
<!-- MediaLib and CKeditor -->
<script src="<?php echo $mlib_domain; ?>mlib-includes/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<link href="<?php echo $mlib_domain; ?>mlib-includes/css/mlib.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mlib_domain; ?>mlib-includes/dropzone/css/basic.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mlib_domain; ?>mlib-includes/dropzone/css/dropzone.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $mlib_domain; ?>mlib-includes/dropzone/dropzone.min.js" type="text/javascript"></script>
<script src="<?php echo $mlib_domain; ?>mlib-includes/js/mlib.js" type="text/javascript"></script>

<!-- CSS -->
<link href="<?php echo $domain; ?>phpix-libs/theme/united.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $domain; ?>phpix-libs/rcrop/rcrop.min.css" rel="stylesheet">
<link href="<?php echo $domain; ?>phpix-libs/pagination/simplePagination.css" rel="stylesheet">
<link href="<?php echo $domain; ?>phpix-libs/theme/admin.css" rel="stylesheet">
<link href="<?php echo $domain; ?>phpix-libs/DataTables/datatables.min.css" rel="stylesheet">

<!-- Font awesome -->
<link href="<?php echo $domain; ?>phpix-libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">


<!-- JavaScripts -->
<script src="<?php echo $domain; ?>phpix-libs/js/moment.min.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/rcrop/rcrop.min.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/js/livestamp.min.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/js/bootstrap.min.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/pagination/jquery.simplePagination.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/DataTables/datatables.min.js"></script>
<script src="<?php echo $domain; ?>phpix-libs/js/admin.js"></script>

</head>

<body>

<div id="wrapper">
<?php 

if($_SESSION[$website_name]!=''){

?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom: 0">
<div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<?php 

//print_r($settings);

 ?><a class="navbar-brand" href="<?php echo $admin_url; ?>index"><i class="fa fa-lg fa-home"></i></a>
            </div>


<div class="navbar-collapse collapse">

<ul id="bigmenu" class="nav navbar-nav">
<li><a href="<?php echo $admin_url ?>albums"><i class="fa fa-lg fa-photo"></i> Albums</a></li>
<li><a href="<?php echo $admin_url ?>content&id=note"><i class="fa fa-lg fa-edit"></i> Notes</span></a></li>
<li><a href="<?php echo $admin_url ?>options"><i class="fa fa-lg fa-gear"></i> Options</span></a></li>
<li title="Update <?php echo $website_name; ?> to latest version"><a href="<?php echo $admin_url ?>update"><i class="fa fa-lg fa-refresh"></i> Updates</a></li>
</ul>

<ul class="nav navbar-nav navbar-right">
<li title="View Gallery"><a target="_blank" href="<?php echo $domain ?>phpix-album.php"><i class="fa fa-lg fa-photo"></i> Gallery</a></li>
<li title="Logout"><a class="confirm" href="<?php echo $admin_url ?>logout"><i class="fa fa-lg fa-sign-out"></i> Logout</a></li>
</ul>

<div style="display:none;" class="navbar-default sidebar" role="navigation">
</div>

</div>
</div>
</nav>
<?php } ?>
<div id="page-wrapper" class="container">
<div style="height:50px;"></div>
