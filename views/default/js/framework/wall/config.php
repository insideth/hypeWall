<?php

/**
 * Add session geopositioning data to the config
 */
namespace hypeJunction\Wall;

$geopositioning = get_geopositioning();
?>

elgg.session.geopositioning = <?php echo json_encode($geopositioning) ?>;



