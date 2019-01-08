<?php

//
//  Enrico Simonetti
//  enricosimonetti.com
//
//  2019-01-08 on SugarCRM 8.0.2
//
//  Set on config_override.php $sugar_config['inbound_emails']['new_email_case_status'] = 'My New Status';
//  to set the case status that should be set after a new inbound email arrives
//
//  Optionally set on config_override.php $sugar_config['inbound_emails']['case_statuses_to_ignore'] = ['Assigned'];
//  to set the case statuses that will never trigger an automated status change
//

class beforeSaveInboundEmails
{
    public function changeCaseStatus($bean, $event, $args)
    {
        $newEmailCaseStatus = \SugarConfig::getInstance()->get('inbound_emails.new_email_case_status', '');
        $ignoreCaseStatuses = \SugarConfig::getInstance()->get('inbound_emails.case_statuses_to_ignore', []);

        // note that this logic works because the Emails record is saved by the system multiple times
        // on the second save, if the parent_id record changes, this logic will trigger

        // if the configuration option has been configured
        if (!empty($newEmailCaseStatus)) {

            // if the email is inbound, there is a mailbox id and it is related to a case
            // and if this is not a subsequent update of the reply_to_status field due to a user replying to an email
            // and if the parent_id is in the process of changing, trigger the rest of the logic

            $GLOBALS['log']->fatal(__METHOD__  . ' triggered hook with parent id ' . $bean->parent_id);

            if ($bean->type === 'inbound' && !empty($bean->mailbox_id)
                && !empty($bean->parent_type) && $bean->parent_type === 'Cases' && !empty($bean->parent_id)
                && $bean->fetched_row['parent_id'] !== $bean->parent_id) {

                $case = BeanFactory::retrieveBean('Cases', $bean->parent_id);

                // if the case exists, and the status is not already the configured value, and the status is not in the ignore list, change it to the configured value
                if (!empty($case) && !empty($case->status) && $case->status !== $newEmailCaseStatus
                    && !in_array($case->status, $ignoreCaseStatuses, true)) {

                    // change case status
                    $GLOBALS['log']->debug(__METHOD__  . ' changing existing case status to ' . $newEmailCaseStatus . ' from ' . $case->status . ' for the case with id ' . $case->id);
                    $case->status = $newEmailCaseStatus;
                    $case->save();
                }
            }
        }
    }
}
