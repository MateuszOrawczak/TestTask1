<?php
	include('db.php');
	
	function countImagesInGallery($gallery_id)
	{
		global $db;
		$query = 'SELECT * FROM images WHERE images_gallery_id = "'.$gallery_id.'" AND images_active = "1" AND images_deleted = "0" ';
		$result = mysqli_query($db, $query);
		return mysqli_num_rows($result);
	}
	
	function getFirstImage($gallery_id)
	{
		global $db;
		$query = 'SELECT * FROM images WHERE images_gallery_id = "'.$gallery_id.'" AND images_active = "1" AND images_deleted = "0" LIMIT 1';
		$result = mysqli_query($db, $query);
		return mysqli_fetch_array($result);
	}

?>