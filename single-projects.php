<?php get_header(); ?>

<a href="<?php echo home_url(); ?>" class="back-button button">
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
				echo '<h1 class="text-center project-h1"><span class="project-title">'.get_the_title().'</span> - '.$data['wpcf-project-tagline-long'].'</h1>';
				echo wpautop(apply_filters( 'the_content', get_the_content()));

				echo '<h2 id="contributors">Contributors</h2>';
			    echo '<ul id="contributors_list" class="author_list">';
				foreach(get_coauthors() as $author){
					$aid = get_the_author_meta( 'ID' );
			        $ghid = '';
			        $gh_raw = explode('|', get_user_meta($aid, 'wpoa_identity', true));
			        if(isset($gh_raw[1])){
			            $ghid = 'data-ghid="'.$gh_raw[1].'"';
			        }
			        echo '<li id="author_'.get_the_author_meta( 'user_login' ).'" class="box no_avatar" '.$ghid.'>';
			        echo '<a href="'.get_author_posts_url($aid).'">';
			        echo '<div class="avatar"></div>';
			        echo '<span class="name">'.get_the_author_meta( 'display_name' ).'</span>';
			        echo '</a></li>';
				}
				echo '</ul>';
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

<script>
jQuery(function($) {
    // Get avatars
    $('.author_list li').each(function(){
        var no_avatar = $(this).hasClass('no_avatar');
        if(no_avatar){
            var username = $(this).attr('id').substring(7);
            $.getJSON('https://api.github.com/users/'+username, function(data) {
                if(no_avatar && data.avatar_url !== undefined && data.avatar_url.length > 0){
                    $('#author_'+username+' .avatar').css('background-image', 'url("'+data.avatar_url+'")');
                }
            });
        }
    });
});
</script>

<?php get_footer(); ?>
