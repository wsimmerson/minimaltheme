<?php
/*
Everything is going to be displayed on this one page,
we don't want to put potentially thousands of posts on 
our one page... so we redefine the query to paginate.
But only if we are not on a single item page.
*/

if (!is_singular()) {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : '1';
    $args = array(
        'nopaging'               => false,
        'paged'                  => $paged,
        'posts_per_page'         => '2',
        'post_type'              => 'post',
    );
    $query = new WP_Query($args);
} else {
    $query = $wp_query;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Theme</title>
    <!-- wp_head will inject all of wordpress's specific header info
    and anything else we define, like custome css.  We could just write that
    in here ourselves, but we could end up with mulitple headers and this
    helps keep us DRY
    -->
    <?php wp_head() ?>
</head>

<body>
    <nav>
        <div class="nav-wrapper  container">
            <a href="/" class="brand-logo"><?php echo get_bloginfo('name'); ?></a>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'container_class' => 'right'
            ));
            ?>
        </div>
    </nav>
    <main class="container">
        <div class="row">
            <div class="col s12 m8">
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                        <article class="card-panel">
                            <h3>
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <small><?php the_time('F jS, Y'); ?> by <?php the_author(); ?></small>

                            <div class="entry">
                                <!-- we only want to show the full post if we aren't on a list -->
                                <?php if (is_singular()) {
                                    the_content();
                                    // If comments are open or we have at least one comment, 
                                    // load up the comment template.
                                    if (comments_open() || get_comments_number()) {
                                        comments_template();
                                    }
                                } else {
                                    the_excerpt();
                                } ?>
                            </div>
                            <p class="postmetadata"><?php _e('Posted in'); ?> <?php the_category(', '); ?></p>

                        </article>

                    <?php endwhile;
                    // show pagination links
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'mid_size' => 2
                    ));

                else : ?>
                    <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
                <?php endif; ?>
            </div>
            <div class="col s12 m4">
                <?php get_sidebar() ?>
            </div>
        </div>
    </main>


    <footer>
        <!-- like wp_head wp_footer injects necessary script stuff
            such as the code that gives us the WordPress Admin bar
         -->
        <?php wp_footer(); ?>
    </footer>
</body>

</html>