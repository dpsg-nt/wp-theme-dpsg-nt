<?php  
register_post_type('leader', array(
	'labels' => array(
		'name'	 => 'Leiterunde',
		'singular_name' => 'Leiter',
		'add_new' => __( 'Neuen Leiter hinzufügen' ),
		'add_new_item' => __( 'Neuen Leiter hinzufügen' ),
		'view_item' => 'Leiter anzeigen',
		'edit_item' => 'Leiter bearbeiten',
		'new_item' => __('Neuer Leiter'),
		'search_items' => __('Leiter suchen'),
		'not_found' =>  __('Keine Leiter gefunden'),
		'not_found_in_trash' => __('Es gibt keine Leiter im Papierkorb'),
	),
	'public' => true,
	'exclude_from_search' => false,
	'show_ui' => true, 
    'capability_type' => 'post',
	'hierarchical' => true,
	'_edit_link' =>  'post.php?post=%d',
	'rewrite' => array(
		"slug" => "leiter",
		"with_front" => false,
	),
	'query_var' => true,
    'supports' => array('title', 'page-attributes', 'custom-fields', 'thumbnail'),
    'taxonomies' => array( 'leader-category' ),
));


register_taxonomy('leader-category', 'leader', array(
    'hierarchical' => false,
    'labels' => array(
        'name' => 'Stufe',
        'singular_name' => 'Stufe',
        'plural_name' => 'Stufen',
        'search_items' =>  __( 'Stufen suchen' ),
        'all_items' => __( 'Alle Stufen' ),
        'edit_item' => __( 'Stufe bearbeiten' ),
        'update_item' => __( 'Stufe aktualisieren' ),
        'add_new_item' => __( 'Neue Stufe hinzufügen' ),
        'menu_name' => __( 'Stufen' ),
    ),
    'show_admin_column' => true,
    'rewrite' => array(
        'slug' => 'stufen',
        'with_front' => false, 
        'hierarchical' => false
    ),
));

// TODO category order
// TODO custom fields 
// TODO single page
function dpsgnt_leader_overview_shortcode($atts)
{
    ob_start();
    ?>
    <div class='leader-overview'>
    <?php

    $_terms = get_terms( array('leader-category') );
    foreach ($_terms as $term) :
        ?>
        <h2><?= $term->name; ?></h2>
        <ul>
        <?php
        $args = array(
            'post_type' => 'leader', 
            'posts_per_page' => 10, 
            'leader-category' => $term->slug );
        $the_query = new WP_Query( $args ); 
        
        while ( $the_query->have_posts() ) {
            $the_query->the_post(); ?>
            <li>
                <a href="<?= the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                    <p class="name"><?php the_title(); ?></p>
                </a>
            </li>
                <?php wp_reset_postdata();
        }
        ?>
        </ul>
        <?php
    endforeach;

    ?>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode("leader_overview", "dpsgnt_leader_overview_shortcode");

