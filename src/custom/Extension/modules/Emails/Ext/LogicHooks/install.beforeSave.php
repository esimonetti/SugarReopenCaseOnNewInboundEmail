<?php
  
$hook_array['before_save'][] = array(
    1,
    'Emails before save hook',
    'custom/logichooks/modules/Emails/beforeSaveInboundEmails.php',
    'beforeSaveInboundEmails',
    'changeCaseStatus'
);
