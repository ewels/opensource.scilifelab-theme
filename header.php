<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<title><?php bloginfo( 'name' ); wp_title(); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="copyright" content="All site content copyright <?php bloginfo( 'name' ); ?>, <?php echo date('Y'); ?>" />
	<meta name="robots" content="ALL,INDEX,FOLLOW,ARCHIVE" />
	<meta name="revisit-after" content="7 days" />

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,400italic|Source+Code+Pro:400,700' rel='stylesheet' type='text/css'>

	<!-- Custom CSS -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/font-entypo/0.1/dev/entypo.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

	<?php wp_head(); ?>
</head>
<body>

	<div class="page-content">
