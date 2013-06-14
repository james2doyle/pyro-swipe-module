<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * create sliders with swipe.js
 *
 * @author 		James Doyle (james2doyle)
 * @website		http://ohdoylerules.com/
 * @package 	PyroCMS
 * @subpackage 	Sliders
 * @copyright 	MIT
 */
class Plugin_swipe extends Plugin
{
	public $version = '1.0.0';

	public $name = array(
		'en'  => 'Swipe'
		);

	public $description = array(
		'en'  => 'Plugin for swipe slider module.'
		);
	/**
	 * Item List
	 * Usage:
	 *
	 * {{ swipe:slider id="5" }}
	 *   {{ id }}
	 * {{ /swipe:slider }}
	 *
	 * @return	array
	 */
	function slider() {
		$id = (int)$this->attribute('id');
		// figure out if this is in the default or shared_addons
		// probably could be done better but hey thats what forks are for
		$path = 'modules/swipe/js/swipe.min.js';
		$this->load->model('swipe/swipe_m');
		$this->lang->load('swipe');
		$this->load->library('files/files');
		$swipe = (array)$this->swipe_m->get($id);
		if (count($swipe) > 0) {
			// path to swipe javascript file
			is_file(ADDONPATH.$path) ? $swipe['source'] = BASE_URL.ADDONPATH.$path : $swipe['source'] = BASE_URL.SHARED_ADDONPATH.$path;
			$swipe['script'] = "window.swipe{$swipe[id]} = new Swipe(document.getElementById('slider_{$swipe[id]}'), {
				startSlide: {$swipe[startslide]},
				speed: {$swipe[speed]},
				auto: {$swipe[auto]},
				continuous: {$swipe[continuous]},
				disableScroll: {$swipe[disablescroll]},
				stopPropagation: {$swipe[stoppropagation]}
			});";
			return $swipe;
		} else {
			return lang('swipe:no_items');
		}
	}
}

/* End of file plugin.php */
