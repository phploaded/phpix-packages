<?php 

include('../../phpix-config.php'); 

$sql = "ALTER TABLE `".$prefix."spots`
ADD COLUMN `sort` INT(11) NOT NULL DEFAULT 0 AFTER `uid`;";

mysqli_query($con, $sql);

 ?>