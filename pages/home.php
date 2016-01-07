<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Images Browser</h3>
				</div>
  				<div class="panel-body">
  					<a href="index.php?show=parser" class="btn btn-default" style="margin-bottom: 15px;">Import First 20 Galleries</a>
  					<a href="index.php?show=clear" class="btn btn-default" style="margin-bottom: 15px;">Clear Database</a><br/>
  					<form method="post">
  					<select name="order_by" class="btn btn-default" style="margin-bottom: 15px;" onchange="this.form.submit()">
						<option value="date_asc">Order by Date Added ASC</option>
						<option value="date_desc" <?php if(isset($_POST['order_by']) && $_POST['order_by'] == 'date_desc') echo 'selected'; ?>>Order by Date Added DESC</option>
						<option value="images_asc" <?php if(isset($_POST['order_by']) && $_POST['order_by'] == 'images_asc') echo 'selected'; ?>>Order by Images Amount ASC</option>
						<option value="images_desc" <?php if(isset($_POST['order_by']) && $_POST['order_by'] == 'images_desc') echo 'selected'; ?>>Order by Images Amount DESC</option>
  					</select>
  					</form>
					<?php
						if(isset($_POST['order_by']))
						{
							if($_POST['order_by'] == 'date_desc') $order_by = 'ORDER BY galleries_created DESC';
							elseif($_POST['order_by'] == 'images_asc') $order_by = 'ORDER BY images ASC';
							elseif($_POST['order_by'] == 'images_desc') $order_by = 'ORDER BY images DESC';
							else $order_by = 'ORDER BY galleries_created ASC';
						}
						else $order_by = 'ORDER BY galleries_created ASC';
						$query = '
						SELECT galleries.*, 
						(
							SELECT COUNT(*) FROM images 
							WHERE images.images_gallery_id = galleries.galleries_id 
							AND images.images_active = "1" 
							AND images.images_deleted = "0" 
						) AS "images" 
						FROM galleries 
						WHERE galleries_active = "1" 
						AND galleries_deleted = "0" 
						'.$order_by.' ';
						$result = mysqli_query($db, $query);
						$gallery_count = 1;
						while($gallery = mysqli_fetch_array($result))
						{
							$first_image = getFirstImage($gallery['galleries_id']);
							echo '
								<div class="panel panel-default">
									<div class="panel-heading"><span style="font-weight: bold;">Gallery #'.$gallery_count.':</span> '.$gallery['galleries_title'].'</div>
									<div class="panel-body">
									<img src="'.$first_image['images_prefix'].'/'.$first_image['images_filename'].'" style="width: 80px; float: left; margin-right: 15px;"/>
									Gallery imported at '.$gallery['galleries_created'].', contains '.countImagesInGallery($gallery['galleries_id']).' pictures.<br/>
										<a href="index.php?show=gallery&id='.$gallery['galleries_id'].'" class="btn btn-sm btn-default">Show Gallery</a>
										<a href="'.$gallery['galleries_link'].'" target="_blank" class="btn btn-sm btn-default">Open Source Page</a>
									</div>
								</div>
							';
							$gallery_count++;
						}
					?>
  				</div>
			</div>
		</div>
	</div>
</div>
