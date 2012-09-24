<?php

// Hides specified config files from the world

// Put a list of the config file(s) to be hidden from world readable below

$hidden_config_files = array(
                             "hide_config_files.php",
                             "configuration.php"
                            );

foreach ($hidden_config_files as $x) {
    if (@is_file($x)) {
        chmod($x, 0600);
    }
}
?>
