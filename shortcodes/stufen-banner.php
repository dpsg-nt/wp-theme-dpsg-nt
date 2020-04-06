<?php
function dpsgnt_stufen_banner_shortcode($atts)
{
    ob_start();
?>
    <div class="stufen-banner">
        <a href="/gruppen/woelflinge" class="stufe woe">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/woelflinge_cat.jpg" class="bild" alt="Wölflinge (6-10 Jahre)">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/dpsg_logo_orange.svg" class="lilie" alt="Lilie">
            <div>
                <span class="name">Wölflinge</span>
                <span class="alter">6-10 Jahre</span>
            </div>
        </a>
        <a href="/gruppen/jungpfadfinder" class="stufe jupfi">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/jupfis_cat.jpg" class="bild" alt="Jungpfadfinder (10-13 Jahre)">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/dpsg_logo_blue.svg" class="lilie" alt="Lilie">
            <div>
                <span class="name">Jungpfadfinder</span>
                <span class="alter">10-13 Jahre</span>
            </div>
        </a>
        <a href="/gruppen/pfadfinder" class="stufe pfadi">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/pfadis_cat.jpg" class="bild" alt="Pfadfinder (13-16 Jahre)">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/dpsg_logo_green.svg" class="lilie" alt="Lilie">
            <div>
                <span class="name">Pfadfinder</span>
                <span class="alter">13-16 Jahre</span>
            </div>
        </a>
        <a href="/gruppen/rover" class="stufe rover">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/rover_cat.jpg" class="bild" alt="Rover (16-20 Jahre)">
            <img src="<?= get_stylesheet_directory_uri(); ?>/images/stufen-banner/dpsg_logo_red.svg" class="lilie" alt="Lilie">
            <div>
                <span class="name">Rover</span>
                <span class="alter">16-20 Jahre</span>
            </div>
        </a>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode("stufen_banner", "dpsgnt_stufen_banner_shortcode");
