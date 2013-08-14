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
		if (!$data = $this->pyrocache->get('swipe_cache')) {
			$this->load->model('swipe/swipe_m');
			$this->lang->load('swipe');
			$this->load->library('files/files');
			$swipe = $this->swipe_m->get($id);
			$files = Files::folder_contents($swipe->folder);
			$swipe->files = $files['data']['file'];
			$this->pyrocache->write($swipe, 'swipe_cache');
		} else {
			$swipe = $this->pyrocache->get('swipe_cache');
		}
		$titles = json_decode($swipe->data);
		for ($i=0; $i < count($swipe->files); $i++) {
			$swipe->files[$i]->swipe_title = $titles[$i];
		}
		if (count($swipe) > 0) {
			// path to swipe javascript file
			// figure out if this is in the default or shared_addons
			// probably could be done better but hey thats what forks are for
			$path = 'modules/swipe/js/swipe.min.js';
			is_file(ADDONPATH.$path) ? $swipe->source = BASE_URL.ADDONPATH.$path : $swipe->source = BASE_URL.SHARED_ADDONPATH.$path;
			$swipe->script = "window.swipe{$swipe->id} = new Swipe(document.getElementById('slider_{$swipe->id}'), {startSlide: {$swipe->startslide},speed: {$swipe->speed},auto: {$swipe->auto},continuous: {$swipe->continuous},disableScroll: {$swipe->disablescroll},stopPropagation: {$swipe->stoppropagation}});";
			return array((array)$swipe);
		} else {
			return lang('swipe:no_items');
		}
	}
}

/* End of file plugin.php */
