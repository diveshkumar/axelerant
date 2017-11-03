ABOUT MODULE
------------
This Module performs the following actions/tasks.


* A new form text field named "Site API Key" needs to be added to the "Site Information" form with the default value of No API Key yetâ.
* When this form is submitted, the value that the user entered for this field should be saved as the system variable named "siteapikey".
* A Drupal message should inform the user that the Site API Key has been saved with that value.
* When this form is visited after the "Site API Key" is saved, the field should be populated with the correct value.
* The text of the "Save configuration" button should change to "Update Configuration".
* This module also provides a URL that responds with a JSON representation of a given node with the content type "page" only if the previously submitted API Key and a node id (nid) of an appropriate node are present, otherwise it will respond with "access denied".

CONFIGURATION AND FEATURES
--------------------------
Module can be configured by following the Steps:
- Goto /admin/extend and install 'Axelerant' module.
- Configure the Site API Key by going to /admin/config/system/site-information.
- After updating the Config Key, visit URL /page_json/[SITE_API_KEY]/[VALID_NODE_ID], and this shall be showing you the node data in JSON format.

AUTHOR DETAILS
--------------
Divesh Kumar
diveshkumar1983@gmail.com
