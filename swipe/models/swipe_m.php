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
class swipe_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'swipe';
		// $this->load->model('files/file_folders_m');
		// $this->load->library('files/files');
		// $this->folder = $this->file_folders_m->get_by('name', 'swipe');
	}

	//create a new item
	public function create($input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			// 'fileinput' => json_encode($fileinput),
			'name' => $input['name'],
			'folder' => $input['folder'],
			'startslide' => ($input['startslide'] !== '') ? $input['startslide']: 0,
			'speed' => ($input['speed'] !== '') ? $input['speed']: 300,
			'auto' => ($input['auto'] !== '') ? $input['auto']: 3000,
			'continuous' => $input['continuous'],
			'disablescroll' => $input['disablescroll'],
			'stoppropagation' => $input['stoppropagation'],
			'data' => json_encode($input['titles'])
			);

		return $this->db->insert('swipe', $to_insert);
	}

	//edit a new item
	public function edit($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'name' => $input['name'],
			'folder' => $input['folder'],
			'startslide' => ($input['startslide'] !== '') ? $input['startslide']: 0,
			'speed' => ($input['speed'] !== '') ? $input['speed']: 300,
			'auto' => ($input['auto'] !== '') ? $input['auto']: 3000,
			'continuous' => $input['continuous'],
			'disablescroll' => $input['disablescroll'],
			'stoppropagation' => $input['stoppropagation'],
			'data' => json_encode($input['titles'])
			);

		// if ($fileinput['status']) {
		// 	$to_insert['fileinput'] = json_encode($fileinput);
		// }

		return $this->db->where('id', $id)->update('swipe', $to_insert);
	}
}
