<?php
/**
 * @copyright   Copyright (C) 2016 Cory Webb Media, LLC. Portions copyright Sam Moffatt and Brent Maxwell. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die();

class plgSystemCw_topsecret extends JPlugin
{

	public function onAfterRoute()
	{
		// Check if we're in the admin we're supposed to run
		$app = JFactory::getApplication();
		$site_only = $this->params->get('site_only', 1);
		if($app->isAdmin() && $site_only)
		{
			return false;
		}

		// Check if the user is logged in, if so we can bail out early
		$user = JFactory::getUser();
		if($user->id)
		{
			return false;
		}

		// Check if the current Itmeid is the same as the redirect Itemid, if so we can bail out
		$itemid = $app->input->get('Itemid',0,'int');
		$redirect = $this->params->get('redirect_menuitem', '');
		if($itemid && $itemid == $redirect) {
			return false;
		}
		
		// Basic component checks
		$option = $app->input->get('option');
		// Black listed components are never accessible regardless of if they are in a menu
		$blacklist_components = $this->getList('blacklist_components', '');

		// Check if this component is blacklisted
		if(in_array($option, $blacklist_components))
		{
			$this->_permissionDenied();
		}

		// White listed components are always accessible regardless of if they are in a menu
		$whitelist_components = $this->getList('whitelist_components', 'com_users');
		if(!in_array($option, $whitelist_components))
		{
			// check if we have an itemid, if not hard kill the request
			$whitelist_menus = array();
			if($itemid)
			{
				// assemble array of whitelisted menus that are being used
				if ($this->params->get('whitelist_menu1_use', '0')) {
					$whitelist_menus[] = $this->params->get('whitelist_menu1', '');
				}
				if ($this->params->get('whitelist_menu2_use', '0')) {
					$whitelist_menus[] = $this->params->get('whitelist_menu2', '');
				}
				if ($this->params->get('whitelist_menu3_use', '0')) {
					$whitelist_menus[] = $this->params->get('whitelist_menu3', '');
				}

				$menu = $app->getMenu();
				$item = $menu->getItem($itemid);
				// check if the menutype is a whitelisted one and nuke it if it isn't
				// also check if the item's option is a whitelisted one
				if(in_array($item->menutype, $whitelist_menus) || in_array($item->component, $whitelist_components))
				{
					return false;
				}

				$this->_permissionDenied();
			}
			else $this->_permissionDenied();
		}
	}

	protected function _permissionDenied()
	{
		$redirect = $this->params->get('redirect_menuitem', '');
		$redirect_message = $this->params->get('redirect_message', JText::_('PLG_CW_TOPSECRET_REDIRECT_MESSAGE_DEFAULT'));
		$app = JFactory::getApplication();
		$uri = JFactory::getUri();

		// base64_encode is needed here to encode the return query parameter
		//  that is appended to the URL. That tells the Joomla login form
		//  where to return the user after they log in.
		$return = base64_encode($uri->toString());

		// if there is a redirect page set, go there and route appropriately
		// if not default to the built in com_user login view
		if($redirect)
		{
			$uri = new JUri();
			$uri->parse(JRoute::_('index.php?Itemid='.$redirect));
			$uri->setVar('return', $return);
			$app->redirect($uri->toString(), $redirect_message);
		}
		else
		{
			$app->redirect('index.php?option=com_users&view=login&return='.$return, $redirect_message);
		}
		die('Access Denied');
	}

	protected function getList($key, $default='')
	{
		$list = explode(',', $this->params->get($key, $default));
		array_walk($list, array($this, 'trimArray'));

		return $list;
	}

	protected function trimArray(&$item, $key)
	{
		$item = trim($item);
	}

}
