<?php


get_header();

?>
    <div class="main-container">

        <div class="main-content">
            <h1 class="text-header">Статьи</h1>

            <div class="articles">
                <?php
                while (have_posts()) {
                    the_post();
                    get_template_part('template-parts/loop/loop', 'post');
                }
                ?>

            </div>
            <div class="paginate-links paginate-links-desktop">
                <?php echo paginate_links([
                    'prev_text'          => '<span>' . __( 'Назад' ) . '</span>' ,
                    'next_text'          => '<span>' . __( 'Вперед' ) . '</span>',
                ]) ?>
            </div>

            <div class="paginate-links paginate-links-mobile">
                <?php echo paginate_links([

                    'mid_size'           => 1,
                    'prev_text'          => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_4_1115)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12.6809 1.66598L6.59843 8.01937L12.6422 14.4118L11.0537 16L3.30593 8.05818L11.0156 -5.34786e-05L12.6809 1.66598Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_4_1115">
<rect width="16" height="16" fill="white" transform="matrix(4.37114e-08 -1 -1 -4.37114e-08 16 16)"/>
</clipPath>
</defs>
</svg>
',
                    'next_text'          => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_4_1113)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M3.31909 1.66598L9.40157 8.01937L3.35775 14.4118L4.94626 16L12.6941 8.05818L4.98437 -5.34786e-05L3.31909 1.66598Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_4_1113">
<rect width="16" height="16" fill="white" transform="translate(0 16) rotate(-90)"/>
</clipPath>
</defs>
</svg>
',
                ]) ?>
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
