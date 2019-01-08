# SugarReopenCaseOnNewInboundEmail
This customisation changes a Case status when a new Inbound Email is received, in certain conditions, based on how it is configured. The aim is to help users be aware on when a new Inbound Email is received, for an existing (and maybe already Closed) Case.

## Supported Platforms and Versions
This package is only installable for Sugar versions 8.0.x (Sugar Cloud and On-Premise installations), 8.2.x and 8.3.x (Sugar Cloud installations).

## Configuration
The package has two `config_override.php` configuration settings.

The first setting `new_email_case_status` defines the Case status that the system will set when a new Inbound Email is received. It is a required setting. If this configuration setting is not set, the logic will not trigger:
```
$sugar_config['inbound_emails']['new_email_case_status'] = 'New Email';
```
The second setting `case_statuses_to_ignore` defines a list of Case statuses that will prevent the logic from triggering if a Case has any of those statuses. This setting is optional:
```
$sugar_config['inbound_emails']['case_statuses_to_ignore'] = ['New', 'Duplicate'];
```

## Installation Steps
- Clone this repository and enter the cloned directory
- Edit the file `src/scripts/post_execute.php` with the correct configuration options based on the Configuration section above 
- Retrieve the Sugar Module Packager dependencies by running `composer install`
- Generate the installable .zip Sugar module with `./vendor/bin/package 0.1`
- Navigate to Admin > Module Loader and install the generated module
