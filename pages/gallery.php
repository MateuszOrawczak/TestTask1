<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<?php
				if(isset($_GET['id']))
				{
					$query = 'SELECT * FROM galleries WHERE galleries_id = "'.$_GET['id'].'" AND galleries_active = "1" AND galleries_deleted = "0" ';
					$result = mysqli_query($db, $query);
					$gallery = mysqli_fetch_array($result);
					$pictures = countImagesInGallery($gallery['galleries_id']);
					$pages = ceil($pictures / 12);
					if(!isset($_GET['page'])) $_GET['page'] = 1;
					echo '
						<h2>'.$gallery['galleries_title'].'</h2>
						<p>Gallery imported at '.$gallery['galleries_created'].', contains '.$pictures.' pictures.</p>
						<a href="index.php" class="btn btn-default">Galleries List</a>
					';
					if($pages == 1)
					{
						echo '
							<nav>
								<ul class="pagination">
									<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
									<li class="active"><a href="#">1</a></li>
									<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
								</ul>
							</nav>
						';
					}
					else
					{
						$page_next = $_GET['page'] + 1;
						$page_prev = $_GET['page'] - 1;
						echo '
							<nav>
								<ul class="pagination">
									';
									if($_GET['page'] == 1) echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
									else echo '<li><a href="index.php?show=gallery&id='.$gallery['galleries_id'].'&page='.$page_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';	
									for($i=1; $i<=$pages; $i++)
									{
										if($i == $_GET['page']) echo '<li class="active"><a href="index.php?show=gallery&id='.$gallery['galleries_id'].'&page='.$i.'">'.$i.'</a></li>';
										else echo '<li><a href="index.php?show=gallery&id='.$gallery['galleries_id'].'&page='.$i.'">'.$i.'</a></li>';
									}
									if($_GET['page'] == $pages) echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
									else echo '<li><a href="index.php?show=gallery&id='.$gallery['galleries_id'].'&page='.$page_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
									echo '
								</ul>
							</nav>
						';	
					}
					
					echo '
						<div class="row">
					';
					$offset = ($_GET['page'] - 1) * 12;
					$query = 'SELECT * FROM images WHERE images_gallery_id = "'.$_GET['id'].'" AND images_active = "1" AND images_deleted = "0" LIMIT '.$offset.', 12';
					$result = mysqli_query($db, $query);
					while($image = mysqli_fetch_array($result))
					{
						echo '
						<div class="col-xs-12 col-sm-4">
							<img src="'.$image['images_prefix'].'/'.$image['images_filename'].'" style="width: 100%; margin-bottom: 15px;">
						</div>
						';
					}
					echo '
						</div>
					';
				}
			?>
		</div>
	</div>
</div>
