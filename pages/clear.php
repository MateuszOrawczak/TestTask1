<?php
	$result = mysqli_query($db, 'TRUNCATE TABLE galleries');
	$result = mysqli_query($db, 'TRUNCATE TABLE images');
?>
						
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Database Status</h3>
				</div>
  				<div class="panel-body">
					<span style="font-weight: bold;">Database Truncated</span><br/>
					<a href="index.php" class="btn btn-default">Galleries List</a>
				</div>
			</div>
		</div>
	</div>
</div>