<?php


get_header();

?>
        <div class="main-container">

            <div class="main-content">
                <h1 class="text-header"><?php echo get_the_archive_title() ?></h1>

                <div class="articles">
                    <?php
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/loop/loop', 'post');
                    }
                    ?>
                    
                </div>

            </div>

            <?php get_sidebar() ?>

        </div>
<?php
while (have_posts()) {
    the_post();
    get_template_part('template-parts/loop/loop', 'fs');
}
?>
    
<?php

get_footer();
