<?php
/**
 * @version   $Id: LanguagePopulator.php 54338 2012-07-13 17:49:24Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Provider_ContentBuilder_LanguagePopulator implements RokCommon_Filter_IPicklistPopulator
{
    /**
     *
     * @return array;
     */
    public function getPicklistOptions()
    {
        $options = array();

        // Get the database object and a new query object.
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Build the query.
        $query->select('a.lang_code AS value, a.title AS text, a.title_native');
        $query->from('#__languages AS a');
        $query->where('a.published >= 0');
        $query->order('a.title');

        // Set the query and load the options.
        $db->setQuery($query);
        $items = $db->loadObjectList();

        $options['*'] = JText::alt('JALL', 'language');
        foreach ($items as $item) {
            $options[$item->value] = $item->text;

        }
        return $options;
    }
}
