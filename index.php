<?php get_header(); ?>

<a href="<?php echo home_url('authors'); ?>" class="back-button button">
  <span class="icon-left-open"></span>  All
</a>



<div class="post">
	<div class="project-body">

        <?php global $wp_query;
        if($wp_query->query['post_type'] == 'projects' && !is_single()):

            if ( is_post_type_archive() ) {
                echo '<h1>'.post_type_archive_title(false, false).'</h1>';
            }
            ?>
        <section>
            <div class="showcase">
                <?php
                $gh_repos = array();
                if (have_posts()): while (have_posts()): the_post();
                    $data = array();
                    foreach(get_post_meta(get_the_ID()) as $key => $var){
                        if(substr($key, 0, 5) == 'wpcf-'){
                            $data[$key] = $var[0];
                        }
                        if($key == 'wpcf-github-url'){
                            $url_path = parse_url($var[0], PHP_URL_PATH);
                            $gh_repos[get_the_ID()] = trim($url_path, '/');
                        }
                    }
                    ?>
                    <div class="case-wrapper">
                        <a href="<?php echo $data['wpcf-github-url']; ?>" alt="See the <?php the_title(); ?> code" class="showcase-aside">
                            <div id="gh-stars-<?php echo get_the_id(); ?>" class="showcase-aside-action">
                                <div class="icon-star"></div>
                            </div>
                        </a>

                        <a class="case" href="<?php the_permalink(); ?>">
                        <div class="case-logo bg-yellow" style="background:<?php echo $data['wpcf-background-colour']; ?>">
                        <?php if(isset($data['wpcf-project-logo'])) { ?>
                            <img class="case-logo-img" src="<?php echo $data['wpcf-project-logo']; ?>" width="48" height="48" alt="<?php the_title(); ?>">
                        <?php } else if(isset($data['wpcf-project-icon'])) { ?>
                            <div class="case-logo-icon <?php echo $data['wpcf-project-icon']; ?>"></div>
                        <?php } ?>
                        </div>
                        <div class="case-intro">
                            <span class="case-intro-title"><?php the_title(); ?></span>
                            <span class="case-intro-text"><?php echo $data['wpcf-project-tagline-short']; ?></span>
                        </div>
                        </a>
                    </div>
            <?php endwhile; endif; ?>
            </div>
        </section>
        <?php else:
            if (have_posts()) {
            	while (have_posts()) {
            		the_post();
            		echo '<h1>'.get_the_title().'</h1>';
            		the_content();
            	}
            }
        endif; ?>
    </div>
</div>

<script>
jQuery(function() {
    <?php foreach($gh_repos as $id => $repo){ ?>
    jQuery.getJSON('https://api.github.com/repos/<?php echo $repo; ?>', function(data) {
        jQuery('#gh-stars-<?php echo $id; ?>').append(data.stargazers_count);
    });
    <?php } ?>
});
</script>

<?php get_footer(); ?>
