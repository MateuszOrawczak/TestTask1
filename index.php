<?php
	require('lib/simple_html_dom.php');
	require('lib/functions.php');
?>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<title>LifeinMobile Review Task</title>
		<link href="css/normalize.css" media="all" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body style="padding-top: 15px;">
		<?php
			if(isset($_GET['show']))
			{
				switch ($_GET['show'])
				{
					case 'parser':
						include('pages/parser.php');
						break;
					case 'gallery':
						include('pages/gallery.php');
						break;
					case 'clear':
						include('pages/clear.php');
						break;
					default:
						include('pages/home.php');
				}
			}
			else include('pages/home.php');
		?>
	</body>
</html>