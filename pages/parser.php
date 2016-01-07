<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Images Parser</h3>
				</div>
  				<div class="panel-body">
  					
					<?php
						$result = mysqli_query($db, 'TRUNCATE TABLE galleries');
						$result = mysqli_query($db, 'TRUNCATE TABLE images');
						$html = file_get_html('http://www.watchthedeer.com/photos.aspx');
						$headlines = array();
						$galleries_count = 0;
						$galleries_time = 0;
						foreach($html->find('li > a') as $gallery) 
						{
							$time_start = microtime(true);
							$title = $gallery->innertext;
							$title = preg_replace('/\s+/', ' ', $title); //remove whitespace characters except signle spaces
							$title = preg_replace('@\(.*?\)@', '', $title); // remove number of images
							$href = $gallery->href;
							$link = str_replace('..', 'http://www.watchthedeer.com', $href);
							
							if(strpos($link, '.aspx')) //look only in links with .axps (there was few links to .MOV files instead of .aspx sites)
							{
								$query = 'INSERT INTO galleries (galleries_title, galleries_link, galleries_active, galleries_deleted) VALUES ("'.$title.'", "'.$link.'", "1", "0") ';
								$result = mysqli_query($db, $query);
								$gallery_id = mysqli_insert_id($db);
							
								$prefix = str_replace('/viewer.aspx', '', $link);
								$html_gallery = file_get_html($link);
								if(is_object($html_gallery)) 
								foreach($html_gallery->find('script[language=javascript]') as $script) 
								{
									$js_array = $script->innertext;
									$array = explode(';', $js_array);
									foreach($array as $key=>$item)
									{
										if($key > 0 && $item != '' && $item != ' ')
										{
											$data = explode(' = ', $item);
											$filename = str_replace('\'', '', $data[1]);
											$array2[$key] = $filename;
											$query = 'INSERT INTO images (images_gallery_id, images_prefix, images_filename, images_active, images_deleted) VALUES ("'.$gallery_id.'", "'.$prefix.'", "'.$filename.'", "1", "0") ';
											mysqli_query($db, $query);
										}
									}
								}
								$galleries_count++;
								$error = null;
							}
							else $error = '<span style="font-weight: bold; color: #FF0000;">Gallery skipped</span></br>'; 
							$time_end = microtime(true);
							$time = $time_end - $time_start;
							$galleries_time = $galleries_time + $time;
							echo '
								<div class="panel panel-default">
									<div class="panel-heading"><span style="font-weight: bold;">Gallery name: '.$title.'</div>
									<div class="panel-body">
										'.$link.' <br/>
										'.$error.'
										Import finished in '.round($time, 3).' s.
									</div>
								</div>
							';
							if($galleries_count == 20) break;
						}
					
						$galleries_time = $galleries_time;
						$galleries_avg_time = round($galleries_time / $galleries_count, 3);
					
						echo '
							<div class="panel panel-default">
								<div class="panel-heading"><span style="font-weight: bold;">Import Summary</div>
								<div class="panel-body">
									Galleries found: '.$galleries_count.'<br/>
									Total time: '.$galleries_time.' sec. <br/>
									Avg. time: '.$galleries_avg_time.' sec. per gallery
								</div>
							</div>
						';
					?>
					<a href="index.php" class="btn btn-default">Galleries List</a>
  				</div>
			</div>
		</div>
	</div>
</div>
