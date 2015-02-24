<?php /* Template Name: Author List */ ?>

<?php get_header(); ?>

<a href="<?php echo home_url(); ?>" class="back-button button">
  <span class="icon-left-open"></span>  Home
</a>


<div class="project-body">
    <?php // Main page content from WordPress editor
    if (have_posts()) {
    	while (have_posts()) {
    		the_post();
    		echo '<h1>'.get_the_title().'</h1>';
    		the_content();
    	}
    }

    // List website users
    echo '<ul id="user_list" class="author_list">';
    $wp_users = get_users( array('orderby' => 'display_name') );
    foreach ($wp_users as $user){
        $ghid = '';
        $gh_raw = explode('|', get_user_meta($user->ID, 'wpoa_identity', true));
        if(isset($gh_raw[1])){
            $ghid = 'data-ghid="'.$gh_raw[1].'"';
        }
        echo '<li id="author_'.$user->data->user_login.'" class="box no_avatar" '.$ghid.'>';
        echo '<a href="'.get_author_posts_url($user->ID).'">';
        echo '<div class="avatar"></div>';
        echo '<span class="name">'.$user->data->display_name.'</span>';
        echo '</a></li>';
    }
    echo '</ul>';
    ?>

    <h1>Other SciLifeLab Developers</h1>
    <ul id="github_users" class="author_list"></ul>
</div>

<script>
jQuery(function($) {
    // Find any missing organisation members
    $.getJSON('https://api.github.com/orgs/SciLifeLab/members', function(data) {
        $.each(data, function(key, usr){
            if ($('.author_list li[data-ghid^="'+usr.id+'"]').length == 0) {
                $('<li id="author_'+usr.login+'" class="box no_name" data-ghid="'+usr.id+'"><a href="'+usr.html_url+'"><div class="avatar" style="background-image: url(\''+usr.avatar_url+'\');"></div><span class="name">'+usr.login+'</span></a></li>').appendTo('#github_users');
            }
        });


        // Get avatars and real names (if missing)
        $('.author_list li').each(function(){
            var no_avatar = $(this).hasClass('no_avatar');
            var no_name = $(this).hasClass('no_name');
            if(no_avatar || no_name){
                var username = $(this).attr('id').substring(7);
                $.getJSON('https://api.github.com/users/'+username, function(data) {
                    if(no_avatar && data.avatar_url !== undefined && data.avatar_url.length > 0){
                        $('#author_'+username+' .avatar').css('background-image', 'url("'+data.avatar_url+'")');
                    }
                    if(no_name && data.name !== undefined && data.name.length > 0){
                        $('#author_'+username+' .name').text(data.name);
                    }
                });
            }
        });
    });
});
</script>

<?php get_footer(); ?>
