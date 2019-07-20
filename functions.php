<?php
/* 
You can register your stylesheets and scripts in the same function
but I prefer to keep them seperate, it just feels cleaner to me
*/
function minimaltheme_enqueue_styles()
{
    wp_enqueue_style('materialize-css', "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css");
}
add_action('wp_enqueue_scripts', 'minimaltheme_enqueue_styles');

function minimaltheme_enqueue_scripts()
{
    wp_enqueue_script('materialize-js', "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js");
}
add_action('wp_enqueue_scripts', 'minimaltheme_enqueue_scripts');
wp_enqueue_style('style', get_stylesheet_uri());


/*
  We need one menu for our nav bar, but you can register
  as many as you like and put them anywhere
*/
function register_menus()
{
    register_nav_menu('main-menu', __('Main Menu'));
}
add_action('init', 'register_menus');


// register a sidebar to user throughout the site
add_action('widgets_init', 'minimaltheme_register_sidebars');
function minimaltheme_register_sidebars()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'minimaltheme'),
        'id' => 'sidebar',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'minimaltheme'),
        'before_widget' => '<div class="card"><div class="card-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="card-title">',
        'after_title'   => '</div>',
    ));
}
