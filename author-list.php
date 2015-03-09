<?php /* Template Name: Author List */ ?>

<?php get_header(); ?>

<a href="<?php echo home_url(); ?>" class="button mod-fab">
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
    echo '<div id="user-list" class="showcase">';
    $wp_users = get_users( array('orderby' => 'display_name') );
    foreach ($wp_users as $user){
        $ghid = '';
        $gh_raw = explode('|', get_user_meta($user->ID, 'wpoa_identity', true));
        if(isset($gh_raw[1])){
            $ghid = 'data-ghid="'.$gh_raw[1].'"';
        }
        echo '<div id="author_'.$user->data->user_login.'" class="showcase-wrapper no-avatar" '.$ghid.'>';
            echo '<a class="showcase-item" href="'.get_author_posts_url($user->ID).'">';
                echo '<div class="showcase-item-icon"></div>';
                echo '<div class="showcase-item-text">';
                    echo '<div class="showcase-item-text-title">';
                        echo $user->data->display_name;
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
    }
    echo '</div>';
    ?>

    <h1>Other SciLifeLab Developers</h1>
    <div id="github-users" class="showcase"></div>
</div>

<script>
jQuery(function($) {
    var scilifelabMembers = 'https://api.github.com/orgs/SciLifeLab/members';
    var jqxhr = $.getJSON(scilifelabMembers, function(data) {
        // Find any missing organisation members
        $.each(data, function(key, usr) {
            // only include unless project author (already in "user-list")
            if ($('.showcase-wrapper[data-ghid^="'+usr.id+'"]').length == 0) {
                $('<div id="author_' + usr.login + '" class="showcase-wrapper no-name" data-ghid="'+usr.id+'"><div class="showcase-item"><div class="showcase-item-icon" style="background-image: url(\''+usr.avatar_url+'\');"></div><div class="showcase-item-text"><a class="showcase-item-text-title" href="' + usr.html_url + '">' + usr.login + '</a></div></div></div>').appendTo('#github-users');
            }
        });

        // Get avatars and real names (if missing)
        $('.showcase-wrapper').each(function() {
            var no_avatar = $(this).hasClass('no-avatar');
            var no_name = $(this).hasClass('no-name');
            if (no_avatar || no_name) {
                var username = $(this).attr('id').substring(7);
                $.getJSON('https://api.github.com/users/'+username, function(data) {
                    if(no_avatar && data.avatar_url !== undefined && data.avatar_url.length > 0){
                        $('#author_'+username+' .showcase-item-icon').css('background-image', 'url("'+data.avatar_url+'")');
                    }
                    if(no_name && data.name !== undefined && data.name.length > 0){
                        $('#author_'+username+' .showcase-item-text-title').text(data.name);
                    }
                });
            }
        });

    })
        .fail(function() {
            $('#github-users').html('<p class="error-message">Oops, couldn\'t communicate with the GitHub API.</p>');
        })
        .always(function() {
            console.log( "complete" );
        });
});
</script>

<?php get_footer(); ?>
