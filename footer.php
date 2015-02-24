
        <?php if(!is_front_page()){ ?>
        <div class="scilife-footer">
            <a class="scilife-logo" href="<?php echo home_url(); ?>">
                <img class="scilife-logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/img/scilifelab-logo.svg" title="Science for Life Laboratory" alt="SciLifeLab logo" />
            </a>
            <div class="subheader">
                <a href="<?php echo home_url(); ?>">Open source is in our DNA.</a>
            </div>
        </div>
        <?php } ?>


        </div> <!-- .page-content -->
        <?php wp_footer(); ?>
    </body>
</html>
