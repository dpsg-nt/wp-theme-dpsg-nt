<?php

function dpsgnt_ga_tracking() {
    $trackingId = get_theme_mod('ga_tracking_id');
    if(empty($trackingId)) return;

    echo <<<EOF
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=$trackingId"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '$trackingId');
    </script>
EOF;
}

add_action('wp_head', 'dpsgnt_ga_tracking');