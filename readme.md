# CW Top Secret Plugin for Joomla

CW Top Secret is a plugin for Joomla that prevents access to a site by unauthenticated users except for a designated set of components or menus.

With CW Top Secret, you don't have to set detailed ACL rules for all of the pages on your site just to prevent unauthenticated users from accessing them. You simply install and configure CW Top Secret, and it does all the hard work for you. Redirect any unauthenticated user on your site to any page on your site.

## Features

* Deny site-wide access to unauthenticated users
* Redirect unauthenticated users to a page of your choice
* Whitelist up to 3 menus to allow access to menu items
* Whitelist components to allow access
* Blacklist components to deny access regardless of menu items in whitelisted menus
* Set a custom message for redirected users whose access was denied

## Documentation

### Step 1: Installation

1. Login to your Joomla administrator
2. Go to Extensions > Manage, and go to the "Upload Package File" tab
3. Click the "Browse" button to locate your CW Top Secret installer package
4. Click the "Upload and Install" button to finish isntallation.

### Step 2: Configuration

1. In the Joomla administrator, go to the plugin manager at Extensions > Plugins
2. Locate and open the CW Top Secret plugin
3. Note: All parameters are optional.
4. Select whether or not you want to use the first whitelist menu option.
5. If you selected "Yes" to using the first whitelist menu, select the first menu you would like to whitelist. Any menu item in this menu will be whitelisted, meaning that the user's access to that menu item will not be blocked by CW Top Secret.
6. Repeat the previous steps for the second and third whitelist menu options. You may whitelist up to 3 menus.
7. Enter a comma-separated list of components you would like to whitelist. The user's access to pages rendered by these components will not be blocked by CW Top Secret. The Joomla users component is already added here by default, because you want the user to be able to access the login form.
8. Enter a comma-separated list of components you would like to blacklist. The user's access to these components will be blocked regardless of whether or not the components have menu items in the whitelisted menus. Note that this only applies to unauthenticated users.
9. Select whether or not you want CW Top Secret to only run on the frontend of the site. Select "Yes" to ignore the administrator and only run on the front end.
10. Select the menu item to which you would like to redirect users whose access is denied.
11. Enter a message to be displayed to users when they are redirected because their access is denied.
12. Click Save & Close.
