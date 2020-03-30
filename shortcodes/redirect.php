<?php
function dpsgnt_shortcode_redirect($attr) {
    header('Location: '.$attr['url']);
}
add_shortcode("redirect", "dpsgnt_shortcode_redirect");
