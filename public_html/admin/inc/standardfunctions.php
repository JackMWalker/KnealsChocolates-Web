<?php

function show_meta()
{
	$meta = <<< END
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Keywords" content="Kneals, Chocolates, Admin">
	<meta name="Description" content="Kneals Chocolates Admin">

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"> <!-- Bootstrap Style CSS -->
	<link rel="stylesheet" type="text/css" href="/admin/css/bootstrap-theme.min.css"> <!-- Bootstrap Theme CSS -->
	<link rel="stylesheet" type="text/css" href="/admin/css/style.css"> <!-- Page Style CSS -->
	<link rel="icon" type="image/x-icon" href="/images/housestyle/Favicon.ico">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="/admin/js/scripts.js"></script>
END;
    echo $meta;
}

function show_header($name)
{
	$meta = <<<END
	<div class="container">
		<div class="row border">
			<header class="main-page">
				<div class="col-xs-3">
					<a href="/admin/" title="Kneals home">
						<img src="http://www.knealschocolates.com/images/housestyle/logo_2017.png" alt="Kneals home" width="50" height="82">
					</a>
				</div>
				<div class="col-xs-9">
					<h1>{$name}</h1>
				</div>
				<div class="clearfix"></div>
			</header>
		</div>
	</div>
END;
    echo $meta;
}

function show_footer()
{
	$meta = <<<END
	
END;
    echo $meta;
}