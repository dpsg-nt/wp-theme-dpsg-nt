<?php
register_post_type('leader', array(
    'labels' => array(
        'name'     => 'Leiterunde',
        'singular_name' => 'Leiter',
        'add_new' => __('Neuen Leiter hinzufügen'),
        'add_new_item' => __('Neuen Leiter hinzufügen'),
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
    'publicly_queryable' => true,
    'query_var' => true,
    'supports' => array('title', 'page-attributes', 'thumbnail'),
    'taxonomies' => array('leader-category')
));

register_taxonomy('leader-category', 'leader', array(
    'hierarchical' => false,
    'labels' => array(
        'name' => 'Stufe',
        'singular_name' => 'Stufe',
        'plural_name' => 'Stufen',
        'search_items' =>  __('Stufen suchen'),
        'all_items' => __('Alle Stufen'),
        'edit_item' => __('Stufe bearbeiten'),
        'update_item' => __('Stufe aktualisieren'),
        'add_new_item' => __('Neue Stufe hinzufügen'),
        'menu_name' => __('Stufen')
    ),
    'show_admin_column' => true,
));

add_action("admin_init", "add_leader_details_meta_box");
add_action('save_post', 'save_leader_details');

function add_leader_details_meta_box()
{
    add_meta_box("leader_details", "Leiter-Details", "get_leader_details", "leader", "normal");
}

function get_leader_details()
{
    global $post;
    $custom = get_post_custom($post->ID);
?>
    <style>
        .metabox-label {
            display: block;
            font-weight: bold;
            margin: 1em 0 0.5em;
        }
    </style>
    <label class="metabox-label">Position</label><input type="text" name="leader_position" value="<?php echo $custom["leader_position"][0]; ?>" />
    <label class="metabox-label">Spitzname</label><input type="text" name="leader_nickname" value="<?php echo $custom["leader_nickname"][0]; ?>" />
    <label class="metabox-label">Geburtsdatum</label><input type="text" name="leader_birthdate" value="<?php echo $custom["leader_birthdate"][0]; ?>" />
    <label class="metabox-label">Pfadi-Laufbahn</label><textarea type="text" name="leader_cv"><?php echo $custom["leader_cv"][0]; ?></textarea>
    <label class="metabox-label">Motto</label><textarea type="text" name="leader_motto"><?php echo $custom["leader_motto"][0]; ?></textarea>
    <label class="metabox-label">Hobbies</label><textarea type="text" name="leader_hobbys"><?php echo $custom["leader_hobbys"][0]; ?></textarea>
    <label class="metabox-label">Warum Pfadfinder?</label><textarea type="text" name="leader_reason"><?php echo $custom["leader_reason"][0]; ?></textarea>
    <label class="metabox-label">Coolstes Erlebnis bei den Pfadfindern?</label><textarea type="text" name="leader_event"><?php echo $custom["leader_event"][0]; ?></textarea>
    <label class="metabox-label">Lieblings-Lager-Essen</label><input type="text" name="leader_meal" value="<?php echo $custom["leader_meal"][0]; ?>" />
    <label class="metabox-label">Lieblings-Lagerfeuerlied</label><input type="text" name="leader_song" value="<?php echo $custom["leader_song"][0]; ?>" />
<?php
}

function save_leader_details()
{
    global $post;
    update_post_meta($post->ID, "leader_position", $_POST["leader_position"]);
    update_post_meta($post->ID, "leader_nickname", $_POST["leader_nickname"]);
    update_post_meta($post->ID, "leader_birthdate", $_POST["leader_birthdate"]);
    update_post_meta($post->ID, "leader_cv", $_POST["leader_cv"]);
    update_post_meta($post->ID, "leader_motto", $_POST["leader_motto"]);
    update_post_meta($post->ID, "leader_hobbys", $_POST["leader_hobbys"]);
    update_post_meta($post->ID, "leader_reason", $_POST["leader_reason"]);
    update_post_meta($post->ID, "leader_event", $_POST["leader_event"]);
    update_post_meta($post->ID, "leader_meal", $_POST["leader_meal"]);
    update_post_meta($post->ID, "leader_song", $_POST["leader_song"]);
}

function dpsgnt_leader_overview_shortcode($atts)
{
    ob_start();
?>
    <div class='leader-overview'>
        <?php

        $category_slugs =  array('stammesvorstand', 'woelflinge', 'jungpfadfinder', 'pfadfinder', 'rover', 'mitarbeiter');

        foreach ($category_slugs as $category_slug) :
            $category = get_term_by('slug', $category_slug, 'leader-category')

        ?>
            <h2><?= $category->name; ?></h2>
            <ul>
                <?php
                $args = array(
                    'post_type' => 'leader',
                    'meta_key' => 'leader_birthdate',
                    'orderby' => 'meta_value_num date',
                    'order' => 'ASC',
                    'leader-category' => $category->slug
                );
                $the_query = new WP_Query($args);

                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $custom = get_post_custom(get_the_ID());
                ?>
                    <li>
                        <a href="<?= the_permalink(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail();
                            } else {
                            ?>
                                <img src="<?= get_stylesheet_directory_uri(); ?>/images/placeholder.jpg" />
                            <?php
                            }
                            ?>
                            <div class="name"><?php the_title(); ?></div>
                            <div class="position"><?= $custom["leader_position"][0] ?: '&nbsp;' ?></div>
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

function additional_active_item_classes($classes = array(), $menu_item = false)
{
    if ($menu_item->title == 'Stufen' && is_singular('leader')) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'additional_active_item_classes', 10, 2);
