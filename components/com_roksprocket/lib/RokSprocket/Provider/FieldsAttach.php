<?php
/**
 * @version   $Id: FieldsAttach.php 55398 2012-08-28 19:13:11Z build $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Provider_FieldsAttach extends RokSprocket_Provider_AbstarctJoomlaBasedProvider
{
	/**
	 * @static
	 * @return bool
	 */
	public static function isAvailable()
	{
		if (!class_exists('JFactory')) {
			return false;
		}
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.extension_id');
		$query->from('#__extensions AS a');
		$query->where('a.type = "component"');
		$query->where('a.element = "com_fieldsattach"');
		$query->where('a.enabled = 1');

		$db->setQuery($query);

		if ($db->loadResult()) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * @param array $filters
	 * @param array $sort_filters
	 */
	public function __construct($filters = array(), $sort_filters = array())
	{
		parent::__construct('fieldsattach');
		$this->setFilterChoices($filters, $sort_filters);
	}

	/**
	 * @param     $raw_item
	 * @param int $dborder
	 *
	 * @return \RokSprocket_Item
	 */
	protected function convertRawToItem($raw_item, $dborder = 0)
	{
		require_once (JPath::clean(JPATH_SITE . '/components/com_content/helpers/route.php'));
		require_once (JPath::clean(JPATH_SITE . '/libraries/joomla/html/html/content.php'));

		//$textfield = $this->params->get('fieldsattach_articletext_field', '');

		$item = new RokSprocket_Item();

		$item->setProvider($this->provider_name);
		$item->setId($raw_item->id);
		$item->setAlias($raw_item->alias);
		$item->setAuthor(($raw_item->created_by_alias) ? $raw_item->created_by_alias : $raw_item->author_name);
		$item->setTitle($raw_item->title);
		$item->setDate($raw_item->created);
		$item->setPublished(($raw_item->state == 1) ? true : false);
		$item->setCategory($raw_item->category_title);
		$item->setHits($raw_item->hits);
		$item->setRating($raw_item->rating);
		$item->setMetaKey($raw_item->metakey);
		$item->setMetaDesc($raw_item->metadesc);
		$item->setMetaData($raw_item->metadata);
		$item->setPublishUp($raw_item->publish_up);
		$item->setPublishDown($raw_item->publish_down);

		//Set up texts array
		$texts       = array();
		$text_fields = self::getFieldTypes(array("textarea", "input"));

		if (count($text_fields)) {
			foreach ($text_fields as $field) {
				$text                        = $this->getFieldValue($raw_item->id, $field->id);
				$texts['text_' . $field->id] = $text;
			}
		}

		$texts['text_introtext'] = $raw_item->introtext;
		$texts['text_fulltext']  = $raw_item->fulltext;
		$texts['text_metadesc']  = $raw_item->metadesc;

		$item->setTextFields($texts);
		$item->setText($texts['text_introtext']);

		//set up images array
		$images = array();
		if ($image_fields = self::getFieldTypes("image")) {
			foreach ($image_fields as $field) {
				$image_uri = $this->getFieldValue($raw_item->id, $field->id);
				if (JFile::exists(JPath::clean(JPATH_SITE . '/images/documents/' . $raw_item->id . '/' . $image_uri))) {
					$image_field = new RokSprocket_Item_Image();
					$image_field->setSource(JPath::clean(JURI::root(true) . '/images/documents/' . $raw_item->id . '/' . $image_uri));
					$image_field->setIdentifier('image_' . $field->id);
					$image_field->setCaption('');
					$image_field->setAlttext('');
					$images['image_' . $field->id] = $image_field;
				}
			}
		}
		if (isset($raw_item->images) && !empty($raw_item->images)) {
			try {
				$raw_images = RokCommon_JSON::decode($raw_item->images);
				if (isset($raw_images->image_intro)) {
					$image_intro = new RokSprocket_Item_Image();
					$image_intro->setSource(JPath::clean(JURI::root(true) . '/' . $raw_images->image_intro));
					$image_intro->setIdentifier('image_intro');
					$image_intro->setCaption($raw_images->image_intro_caption);
					$image_intro->setAlttext($raw_images->image_intro_alt);
					$images[$image_intro->getIdentifier()] = $image_intro;
				}

				if (isset($raw_images->image_fulltext)) {
					$image_fulltext = new RokSprocket_Item_Image();
					$image_fulltext->setSource(JPath::clean(JURI::root(true) . '/' . $raw_images->image_fulltext));
					$image_fulltext->setIdentifier('image_fulltext');
					$image_fulltext->setCaption($raw_images->image_fulltext_caption);
					$image_fulltext->setAlttext($raw_images->image_fulltext_alt);
					$images[$image_fulltext->getIdentifier()] = $image_fulltext;
				}


			} catch (RokCommon_JSON_Exception $jse) {
				//TODO log unable to get image for article
			}
		}
		if (isset($images['image_fulltext']) && $images['image_fulltext']) {
			$image_primary = $images['image_fulltext'];
		} else {
			if (isset($images['image_intro']) && $images['image_intro']) {
				$image_primary = $images['image_intro'];
			} else {
				if (count($images)) {
					$image_primary = array_shift(array_values($images));
				} else {
					$image_primary = array();
				}
			}
		}
		$item->setPrimaryImage($image_primary);
		$item->setImages($images);

		//set up links array
		$links       = array();
		$link_fields = self::getFieldTypes("link");

		if (count($link_fields)) {
			foreach ($link_fields as $field) {
				$link_url   = $this->getFieldValue($raw_item->id, $field->id);
				$link_field = new RokSprocket_Item_Link();
				$link_field->setUrl($link_url);
				$link_field->setText('');
				$links['url_' . $field->id] = $link_field;
			}
		}
		if (isset($raw_item->urls) && !empty($raw_item->urls)) {
			try {
				$raw_links = RokCommon_JSON::decode($raw_item->urls);
				if (isset($raw_links->urla)) {
					$linka = new RokSprocket_Item_Link();
					$linka->setUrl($raw_links->urla);
					$linka->setText($raw_links->urlatext);
					$linka->setIdentifier('urla');
					$links[$linka->getIdentifier()] = $linka;
					$item->setPrimaryLink($linka);
				}
				if (isset($raw_links->urlb)) {
					$linkb = new RokSprocket_Item_Link();
					$linkb->setUrl($raw_links->urlb);
					$linkb->setText($raw_links->urlbtext);
					$linkb->setIdentifier('urlb');
					$links[$linkb->getIdentifier()] = $linkb;
				}
				if (isset($raw_links->urlc)) {
					$linkc = new RokSprocket_Item_Link();
					$linkc->setUrl($raw_links->urlc);
					$linkc->setText($raw_links->urlctext);
					$linkc->setIdentifier('urlc');
					$links[$linkc->getIdentifier()] = $linkc;
				}
			} catch (RokCommon_JSON_Exception $jse) {
				//TODO log unable to get links for article
			}
		}
		$item->setLinks($links);

		$primary_link = new RokSprocket_Item_Link();
		$slug         = !empty($raw_item->alias) ? ($raw_item->id . ':' . $raw_item->alias) : $raw_item->id;
		$catslug      = !empty($raw_item->category_alias) ? ($raw_item->catid . ':' . $raw_item->category_alias) : $raw_item->catid;
		$primary_link->setUrl(JRoute::_(ContentHelperRoute::getArticleRoute($slug, $catslug), true));
		$primary_link->getIdentifier('article_link');

		$item->setPrimaryLink($primary_link);

		// unknown joomla items
		$item->setCommentCount(0);
		$item->setTags(array());

		$item->setDbOrder($dborder);

		return $item;
	}

	/**
	 * @param $id
	 *
	 * @return string
	 */
	protected function getArticleEditUrl($id)
	{
		return JURI::root(true) . '/administrator/index.php?option=com_content&task=article.edit&id=' . $id;
	}

	/**
	 * @return array the array of image type and label
	 */
	public static function getImageTypes()
	{
		$list = array();
		if ($fields = self::getFieldTypes("image")) {
			foreach ($fields as $field) {
				$list['image_' . $field->value]            = array();
				$list['image_' . $field->value]['group']   = $field->id;
				$list['image_' . $field->value]['display'] = $field->title;
			}
		}
		$static = array(
			'image_intro'       => array(
				'group' => null, 'display' => 'Article Intro Image'
			), 'image_fulltext' => array(
				'group' => null, 'display' => 'Article Full Image'
			)
		);
		$list   = array_merge($static, $list);
		return $list;
	}

	/**
	 * @return array the array of link types and label
	 */
	public static function getLinkTypes()
	{
		$list = array();
		if ($fields = self::getFieldTypes("link")) {
			foreach ($fields as $field) {
				$list['url_' . $field->value]            = array();
				$list['url_' . $field->value]['group']   = $field->id;
				$list['url_' . $field->value]['display'] = $field->title;
			}
		}

		$static = array(
			'urla'    => array(
				'group' => null, 'display' => 'Link A'
			), 'urlb' => array(
				'group' => null, 'display' => 'Link B'
			), 'urlc' => array(
				'group' => null, 'display' => 'Link C'
			)
		);

		$list = array_merge($static, $list);
		return $list;
	}

	/**
	 * @return array the array of link types and label
	 */
	public static function getTextTypes()
	{
		$list = array();
		if ($fields = self::getFieldTypes(array("textarea", "input"))) {
			$list = array();
			foreach ($fields as $field) {
				$list['text_' . $field->value]            = array();
				$list['text_' . $field->value]['group']   = $field->id;
				$list['text_' . $field->value]['display'] = $field->title;
			}
		}
		$static = array(
			'text_fulltext'  => array('group' => null, 'display' => 'Full Text'),
			'text_introtext' => array('group' => null, 'display' => 'Intro Text'),
			'text_metadesc'  => array('group' => null, 'display' => 'Meta Description'),
		);
		$list   = array_merge($static, $list);
		return $list;
	}

	private static function getFieldTypes($fields = false)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('f.id, f.id as value, f.title, f.groupid, f.articlesid');
		$query->from('#__fieldsattach as f');
		$query->join('LEFT', '#__fieldsattach_groups AS fg ON fg.id=f.groupid');

		if ($fields && is_array($fields)) {
			$wheres = array();
			foreach ($fields as $match) {
				$wheres[] = ('f.type = "' . $match . '"');
			}
			$query->where('(' . implode(' OR ', $wheres) . ')');
		} else if ($fields && is_string($fields)) {
			$query->where('f.type = "' . $fields . '"');
		}
		$query->order('f.title ASC');
		$query->where('fg.group_for = "0"');

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	private static function getFieldValue($item_id = false, $field_id = false)
	{
		if (!$item_id || !$field_id) return '';

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('value');
		$query->from('#__fieldsattach_values');
		$query->where('fieldsid = ' . $field_id);
		$query->where('articleid = ' . $item_id);

		$db->setQuery($query);
		return $db->loadResult();
	}

}

