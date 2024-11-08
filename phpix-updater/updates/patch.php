<?php 

include('../../phpix-config.php'); 

$sql = "CREATE TABLE IF NOT EXISTS `".$prefix."spots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL,
  `title` varchar(1000) NOT NULL DEFAULT 'no_title',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

mysqli_query($con, $sql);

 ?>