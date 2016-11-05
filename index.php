<!DOCTYPE html>
<html>
	<head>
		<?php wp_head() ?>
		<title><?php wp_title( '&middot;', true, 'right' ); ?> Born to be wise</title>

		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- <script src="//use.typekit.net/yjd8lkq.js"></script><script>try{Typekit.load();}catch(e){}</script> -->
		<!-- <script src="https://maps.googleapis.com/maps/api/js"></script> -->
		<?php if ( defined( 'HM_DEV' ) ) : ?>
			<script src="//localhost:35729/livereload.js"></script>
		<?php endif; ?>
		<?php do_action( 'opengraph' ); ?>

		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicons/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicons/manifest.json">
		<link rel="mask-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="theme-color" content="#1990cc">
	</head>

	<body>
		<!-- Start Sign-up Box -->

		<div id="app"></div>

		<?php wp_footer() ?>
	</body>

</html>
