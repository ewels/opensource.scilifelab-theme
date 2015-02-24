<?php get_header(); ?>

<a href="<?php echo home_url(); ?>" class="back-button">
	<span class="icon-left-open"></span>  All
</a>

<?php
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$data = array();
		foreach(get_post_meta(get_the_ID()) as $key => $var){
			if(substr($key, 0, 5) == 'wpcf-' && strlen($var[0]) > 0){
				$data[$key] = $var[0];
			}
		}

		if ( isset($data['wpcf-project-poster']) ) { ?>
			<div class="project-poster-wrapper">
				<div class="project-poster" style="background-image: url(<?php echo $data['wpcf-project-poster']; ?> );">
					<?php if ( isset($data['wpcf-project-logo-large']) ) { ?>
						<img src="<?php echo $data['wpcf-project-logo-large']; ?>" alt="<?php the_title(); ?> Logo">
					<?php } ?>
				</div>
			</div>
		<?php } ?>

		<div class="post">
			<div class="project-body">
				<?php
				echo '<h1 class="text-center"><span class="project-title">'.get_the_title().'</span> - '.$data['wpcf-project-tagline-long'].'</h1>';
				echo wpautop(apply_filters( 'the_content', get_the_content()));

				echo '<h2 id="contributors">Contributors</h2>';
				foreach(get_coauthors() as $author){ ?>
					<p><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></p>
				<?php }
				echo wpautop($data['wpcf-contributors-custom']);

				echo '<h2 id="licence">Licence</h2>';
				echo wpautop($data['wpcf-licence']);

				echo '<p>See the code for '.get_the_title().' here: <a href="'.$data['wpcf-github-url'].'" target="_blank">'.$data['wpcf-github-url'].'</a></p>';

				// echo '<pre>'.print_r($data, true).'</pre>';
				?>
			</div>
		</div>

<?php }
}
?>


<div class="scilife-footer">

	<a class="scilife-logo" href="<?php echo home_url(); ?>">
		<img class="scilife-logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/img/scilifelab-logo.svg" title="Science for Life Laboratory" alt="SciLifeLab logo" />
	</a>

	<div class="subheader">
		<a href="<?php echo home_url(); ?>">Open source is in our DNA.</a>
	</div>

</div>

<?php get_footer(); ?>
