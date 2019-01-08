<?php

// Enrico Simonetti
// 2019-01-07
// enricosimonetti.com

// post uninstall actions



// START - definition of sugar_config_to_uninstall

$sugar_config_to_uninstall = [];
$sugar_config_to_uninstall['inbound_emails'] = false;

// END - definition of sugar_config_to_uninstall



require_once 'modules/Configurator/Configurator.php';

$configuratorObj = new Configurator();
$configuratorObj->loadConfig();

if (!empty($sugar_config_to_uninstall)) {
    foreach ($sugar_config_to_uninstall as $cKey => $cValue) {
        $configuratorObj->config[$cKey] = $cValue;
    }
    $configuratorObj->saveConfig();
}
