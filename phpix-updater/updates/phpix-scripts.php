<?php 

if(!isset($_GET['q'])){$_GET['q']='';} 
if(!isset($_GET['aid'])){$_GET['aid']='';} 

if($_GET['q']!=''){
$quality = $_GET['q'];
} else {
$quality = 'full';
}

 ?>
<meta charset="utf-8" />
<link id="gal-favicon" rel="shortcut icon" type="image/jpg" href="<?php echo $gallery_domain; ?>phpix-imports/buttons/flat-color/svg/play.svg"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
<script>
gal_domain='<?php echo $gallery_domain; ?>';
albumFILE = '<?php echo $albumFILE; ?>';
gal_quality='<?php echo $quality; ?>';
gal_vars_aid='<?php echo $_GET["aid"]; ?>';
gal_vars_uid='<?php if($phpix_user==''){echo "0"; $xtag_save_db = "false";} else {echo $phpix_user; $xtag_save_db = "true";} ?>';
var xtag_save_db=<?php echo $xtag_save_db; ?>;
gal_sitekey = '<?php echo $siteKey; ?>';
</script>
<link href="<?php echo gal_enqueue('css/imagehover.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('css/album.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('css/brightness.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('css/fast.gallery.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('css/tagged.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('css/flex-images.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('phpix-libs/alert/alert.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('phpix-libs/pagination/simplePagination.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo gal_enqueue('phpix-libs/rcrop/rcrop.min.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo gal_enqueue('js/jquery-3.5.1.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/brightness.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/main-config.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/longpress.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/panzoom.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('phpix-libs/rcrop/rcrop.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('phpix-libs/pagination/jquery.simplePagination.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/screenfull.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/flex-images.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/hotkeys.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/jquery-visibility.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('phpix-libs/alert/alert.js'); ?>" type="text/javascript"></script>
<script src="<?php echo gal_enqueue('js/custom.js'); ?>" type="text/javascript"></script>

<script src="<?php echo $gallery_domain; ?>js/tagged.js" type="text/javascript"></script>
