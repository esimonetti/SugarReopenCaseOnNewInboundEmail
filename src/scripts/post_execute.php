<?php

// Enrico Simonetti
// 2019-01-07
// enricosimonetti.com

// post execute actions


// START - definition of sugar_config_to_install

$sugar_config_to_install = [];
$sugar_config_to_install['inbound_emails']['new_email_case_status'] = 'Assigned';
$sugar_config_to_install['inbound_emails']['case_statuses_to_ignore'][] = 'New';
$sugar_config_to_install['inbound_emails']['case_statuses_to_ignore'][] = 'Duplicate';

// END - definition of sugar_config_to_install



require_once 'modules/Configurator/Configurator.php';

$configuratorObj = new Configurator();
$configuratorObj->loadConfig();

if (!empty($sugar_config_to_install)) {
    foreach ($sugar_config_to_install as $cKey => $cValue) {
        $configuratorObj->config[$cKey] = $cValue;
    }
    $configuratorObj->saveConfig();
}
