<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

JHtml::_('behavior.tooltip');

/**
 *
 */
class RoksprocketViewContentBuilderItems extends JView
{
    /**
     * @var
     */
    protected $items;
    /**
     * @var
     */
    protected $pagination;
    /**
     * @var
     */
    protected $state;

    /**
     * @param null $tpl
     * @return bool
     */
    function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');
        $this->categories = $this->get('Categories');
        $this->storages = $this->get('Storages');



        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        parent::display($tpl);
    }

}
