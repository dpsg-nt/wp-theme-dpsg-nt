<?php
function dpsgnt_stufen_banner_shortcode($atts)
{
    ob_start();
?>
    <style>
        /** stufen-banner */
        .stufen-banner {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: calc(100% + 10px);
            margin-left: -5px;
        }
        .stufen-banner .stufe {
            width: calc(50% - 10px);
            margin: 5px;
            position: relative;
        }
        .stufen-banner .stufe.woe { border: 4px solid #ff6600; }
        .stufen-banner .stufe.jupfi { border: 4px solid #2f53a7; }
        .stufen-banner .stufe.pfadi { border: 4px solid #00823c; }
        .stufen-banner .stufe.rover { border: 4px solid #cc1f2f; }

        .stufen-banner .stufe img.bild {
            max-width: 100%;
            max-height: 100%;
        }
        .stufen-banner .stufe img.lilie {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
            width: 50px;
            opacity: 0.75;
        }
        .stufen-banner .stufe div {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;

            background-color: rgba(0,0,0,0.5);
            color: #fff;
            text-decoration: none;

            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
        }
        .stufen-banner .name {
            font-weight: bold;
            font-size: 1.1em;
        }
        .stufen-banner .stufe:hover div {
            display: flex;
        }
    </style>

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
