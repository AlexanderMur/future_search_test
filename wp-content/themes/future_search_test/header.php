<?php

global $post;
?>
<!DOCTYPE html>
<html class="no-js" lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo get_the_title() ?></title>
   <?php wp_head();?>
</head>
<body <?php body_class('body')?>>

<main>
    <header>
        <div class="header-container">
            <p class="text-header">Header</p>
        </div>
    
        
        <?php
        if ( has_nav_menu( 'primary' ) ) {

            wp_nav_menu(
                array(
                    'container'  => 'nav',
                    'container_class' => 'nav-container',
                    'theme_location' => 'primary',
                )
            );

        }
        ?>
    </header>

