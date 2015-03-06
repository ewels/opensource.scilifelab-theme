<?php get_header(); ?>


<header class="header">
    <img class="header-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/img/scilifelab-logo-bp.svg" title="Science for Life Laboratory" alt="SciLifeLab logo" />
</header>

<section>
    <div class="showcase">
        <?php
        $gh_repos = array();
        $args = array( 'post_type' => 'projects', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
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
            $new_post = false;
            $post_age = (date('U') - get_post_time('U'))/(60*60*24); // days
            if($post_age < 30){
                $new_post = true;
            }
            ?>
            <div class="showcase-wrapper">
                <a href="<?php echo $data['wpcf-github-url']; ?>" alt="See the <?php the_title(); ?> code" class="case-action-wrapper">
                    <div id="gh-stars-<?php echo get_the_id(); ?>" class="case-action">
                        <div class="icon-star"></div>
                    </div>
                </a>

                <a class="showcase-item" href="<?php the_permalink(); ?>">
                    <div class="showcase-item-icon" style="background:<?php echo $data['wpcf-background-colour']; ?>">
                        <?php if(isset($data['wpcf-project-logo'])) { ?>
                            <img class="case-logo-img" src="<?php echo $data['wpcf-project-logo']; ?>" width="48" height="48" alt="<?php the_title(); ?>">
                        <?php } else if(isset($data['wpcf-project-symbol'])) { ?>
                            <div class="case-logo-icon <?php echo $data['wpcf-project-symbol']; ?>"></div>
                        <?php } ?>
                    </div>
                    <div class="showcase-item-text">
                        <span class="showcase-item-text-title"><?php the_title(); ?></span>
                        <span class="showcase-item-text-subtitle"><?php echo $data['wpcf-project-tagline-short']; ?></span>
                    </div>
                    <?php if($new_post){ ?>
                        <div class="showcase-item-badge">
                            <div class="badge">New</div>
                        </div>
                    <?php } ?>
                </a>
            </div>
    <?php endwhile; ?>
    </div>
</section>

<nav class="home-nav">
    <a class="button" href="<?php echo home_url('authors'); ?>" title="Authors">See all developers</a>

    <?php if(!is_user_logged_in()){ ?>
        <a class="button" href="<?php echo wp_login_url( home_url() ); ?>" title="Login">Log in</a>
    <?php } ?>
</nav>



<script>
jQuery(function($) {
    <?php foreach($gh_repos as $id => $repo){ ?>
    $.getJSON('https://api.github.com/repos/<?php echo $repo; ?>', function(data) {
        $('#gh-stars-<?php echo $id; ?>').append(data.stargazers_count);
    });
    <?php } ?>
});
</script>


<?php get_footer(); ?>
