CiviCRM Event Organiser
=======================

A *WordPress* plugin for syncing *Event Organiser* plugin Events with *CiviCRM* Events. The plugin syncs *Event Organiser* Events, Venues and Event Categories to their corresponding entities in CiviCRM.

If you want *Event Organiser* Events to play nicely with *BuddyPress* Groups and Group Hierarchies, you can also install [BuddyPress Event Organiser](https://github.com/christianwach/bp-event-organiser).



#### Notes ####

Be aware that this plugin is still in development.

This plugin requires at least *WordPress 3.6*, *CiviCRM 4.4* and (optionally) *BuddyPress 1.8*.

It requires:

* [Event Organiser](http://wordpress.org/plugins/event-organiser/) version 3.0 or greater
* [Radio Buttons for Taxonomies](http://wordpress.org/plugins/radio-buttons-for-taxonomies/) to ensure only one event type is selected

If you are using a version of *CiviCRM* prior to 4.6, it also requires:

* the appropriate branch of the [CiviCRM WordPress plugin](https://github.com/civicrm/civicrm-wordpress)
* the custom WordPress.php hook file from the [CiviCRM Hook Tester repo on GitHub](https://github.com/christianwach/civicrm-wp-hook-tester) installed so that it overrides the built-in *CiviCRM* hook file.



#### Known Issues ####

There is currently no proper integration with *CiviCRM's* implementation of repeating events in version 4.7.n because, at present, *CiviCRM* does not save (or expose) the schedule that generates the sequence. To get around this limitation, this plugin prioritises a workflow based on creating events in *Event Organiser* and then (optionally, via the "CiviCRM Settings" metabox on the event's edit page) passing the data over to *CiviCRM* when published.

The plugin implements automatic linking to an event's online registration page via the [`eventorganiser_additional_event_meta`](https://github.com/boonebgorges/Event-Organiser/commit/1c94d707741b12d5a8731fc39507aa80af805c4a) hook which has been available since *Event Organiser* 2.12.5. If you have overridden the *Event Organiser* template(s) you may have to apply the function to the appropriate hook in your template(s) yourself. See the documentation for the function `civicrm_event_organiser_registration_link()` for details. Thanks to [Consilience Media](https://github.com/consilience/) for providing the resources to push this forward.



#### Installation ####

There are two ways to install from GitHub:

###### ZIP Download ######

If you have downloaded *CiviCRM Event Organiser* as a ZIP file from the GitHub repository, do the following to install and activate the plugin and theme:

1. Unzip the .zip file and rename the enclosing folder so that the plugin's files are located directly inside `/wp-content/plugins/civicrm-event-organiser`
2. Activate the plugin (if on WP multisite, only activate the plugin on the main site, or wherever *Event Organiser* is activated)
3. Go to the plugin's admin page and follow the instructions
4. You are done!

###### git clone ######

If you have cloned the code from GitHub, it is assumed that you know what you're doing.
