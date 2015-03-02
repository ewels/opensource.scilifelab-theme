
        <?php if(!is_front_page()){ ?>
        <div class="footer mod-solid">
            <a href="<?php echo home_url(); ?>">
                <img class="footer-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/img/scilifelab-logo.svg" title="Science for Life Laboratory" alt="SciLifeLab logo" />
            </a>
            <div class="footer-subheader">
                <a class="footer-subheader-link" href="<?php echo home_url(); ?>">Open source is in our DNA.</a>
            </div>
        </div>
        <?php } ?>

        <?php wp_footer(); ?>
    </body>
</html>
