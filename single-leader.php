<?php get_header();

the_post(); ?>
<div class="row">
    <div class="content col-xs-12 col-sm-6 col-lg-8">
        <article class="post leader">
            <a class="back-to-parent-page" href="<?php echo esc_url(get_page_link(663)); ?>">
                Zurück zur Leiterrunde
            </a>
            <?php dpsg_page_title(); ?>
            <?php
            if (has_post_thumbnail())
                the_post_thumbnail();

            global $post;
            $custom = get_post_custom($post->ID);
            ?> <?= print_detail('leader_position', 'Position', $custom); ?> <?= print_detail('leader_nickname', 'Spitzname', $custom); ?> <?= print_detail('leader_birthdate', 'Alter', $custom); ?> <?= print_detail('leader_cv', 'Pfadi-Laufbahn', $custom); ?> <?= print_detail('leader_motto', 'Motto', $custom); ?> <?= print_detail('leader_hobbys', 'Hobbies', $custom); ?> <?= print_detail('leader_reason', 'Warum Pfadfinder?', $custom); ?> <?= print_detail('leader_event', 'Coolstes Erlebnis bei den Pfadfindern?', $custom); ?> <?= print_detail('leader_meal', 'Lieblings-Lager-Essen', $custom); ?> <?= print_detail('leader_song', 'Lieblings-Lagerfeuerlied', $custom); ?> <div class="entry">
                <?php dpsg_content_edit(); ?>
            </div>
        </article><!-- /.post -->
    </div><!-- /.col-xs-6 -->
    <?php get_sidebar(); ?>
</div><!-- /.row -->
<?php get_footer();


function print_detail($detail_id, $detail_nicename, $custom)
{
    if ($custom[$detail_id][0] == null)
        return; ?>
    <span><?= $detail_nicename; ?></span>
    <p><?= $detail_id == 'leader_birthdate' ? calulate_age($custom[$detail_id][0]) : nl2br($custom[$detail_id][0]) ?></p>
<?php
}


function calulate_age($birthdate)
{
    $birthdate = strtotime($birthdate);
    $age = floor((time() - $birthdate) / (60 * 60 * 24 * 365.25));
    return $age . ' Jahre';
}
