<?php
/*
* @package component panorama for Joomla! 3.x
 * @version $Id: com_panorama 1.0.0 2016-08-20 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2015- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of panorama.
    panorama is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    panorama is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with panorama.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php

defined('_JEXEC') or die;
jimport('joomla.application.component.modelitem');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_panorama/tables');

class PanoramaModelPanorama extends JModelItem
{
		protected $item = null;

	public function getTable($type="Panoramas", $prefix="PanoramaTable", $config=array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$input = $app->input;
		$pk = $input->get('title');
		
		$this->setState('panorama.id', $pk);
		$params = $app->getParams();
		$this->setState('params', $params);
        parent::populateState();

	}
	public function getItem($pk = null)
	{
		
		 if(!isset($this->item))
		 {
			 				$pk = (!empty($pk)) ? $pk : (int) $this->getState('panorama.id');
							
							$table = $this->getTable();
				            $table->load($pk);
							$this->item=$table;
							if(!isset($this->item))
							{
								echo "error!";
							}
							else
							{
								$params = new JRegistry;
								$params->loadString($this->item->params, 'JSON');
								$this->item->params = $params;
								$params = clone $this->getState('params');
								$params->merge($this->item->params);
								$this->item->params = $params;
							}

		 }
			     
				  return $this->item;

	}
}
