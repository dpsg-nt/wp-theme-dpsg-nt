<?php

function dpsgnt_header_background() {
?>
<style>
.site-header {
    background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/header-background/background-<?php echo rand(1,3); ?>.jpg);
}
</style>
<?php
}

add_action('wp_head', 'dpsgnt_header_background');