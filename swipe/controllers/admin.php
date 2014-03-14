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
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('swipe_m');
		$this->load->library('form_validation');
		$this->lang->load('swipe');

		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
				),
			array(
				'field' => 'folder',
				'label' => 'Folder',
				'rules' => 'required'
				),
			array(
				'field' => 'startslide',
				'label' => 'Start Slide'
				),
			array(
				'field' => 'speed',
				'label' => 'Speed'
				),
			array(
				'field' => 'auto',
				'label' => 'Auto'
				),
			array(
				'field' => 'continuous',
				'label' => 'Continuous'
				),
			array(
				'field' => 'disablescroll',
				'label' => 'Disable Scroll'
				),
			array(
				'field' => 'stoppropagation',
				'label' => 'Stop Propagation'
				),
			array(
				'field' => 'data',
				'label' => 'Data'
				)
			);

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
		->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		$swipe = $this->swipe_m->order_by('order')->get_all();
		$this->template
		->title($this->module_details['name'])
		->set('swipe', $swipe)
		->build('admin/index');
	}

	public function create()
	{
		$swipe = new StdClass();
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if($this->form_validation->run())
		{
			// See if the model can create the record
			if($this->swipe_m->create($this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('swipe:success'));
				redirect('admin/swipe');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('swipe:error'));
				redirect('admin/swipe/create');
			}
		}
		$swipe->data = new StdClass();
		$folder = $this->file_folders_m->get_by('name', 'swipe');
		$folders = Files::folder_contents($folder->id);

		if (count($folders['data']['folder']) > 0) {
			$swipe->data->folders = array_for_select($folders['data']['folder'], 'id', 'name');
		} else {
			$swipe->data->folders = array('none' => lang('swipe:no_folders'));
		}

		foreach ($this->item_validation_rules AS $rule)
		{
			$swipe->data->{$rule['field']} = $this->input->post($rule['field']);
		}
		$this->_form_data();
		// Build the view using sample/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('swipe:new_item'))
		->build('admin/form', $swipe->data);
	}

	public function edit($id = 0)
	{
		$this->data = $this->swipe_m->get($id);

		$this->load->model('files/file_folders_m');
		$folder = $this->file_folders_m->get_by('name', 'swipe');
		$folders = Files::folder_contents($folder->id);
		$this->data->folders = array_for_select($folders['data']['folder'], 'id', 'name');

		if (count($folders['data']['folder']) > 0) {
			$this->data->folders = array_for_select($folders['data']['folder'], 'id', 'name');
		} else {
			$this->data->folders = array('none' => lang('swipe:no_folders'));
		}

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);

			// See if the model can create the record
			if($this->swipe_m->edit($id, $this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('swipe:success'));
				redirect('admin/swipe');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('swipe:error'));
				redirect('admin/swipe/create');
			}
		}
		// starting point for file uploads
		// $this->data->fileinput = json_decode($this->data->fileinput);
		$this->_form_data($this->data);
		// Build the view using sample/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('swipe:edit'))
		->build('admin/form', $this->data);
	}

	public function _form_data($data)
	{
		$this->load->model('pages/page_m');
		$folder = Files::folder_contents($data->folder);
		$values = json_decode($data->data);
		$files = $folder['data']['file'];
		$template = '';
		for ($i=0; $i < count($files); $i++) {
			$template .= '<li><label for="titles[]">Title For '.$files[$i]->name.'</label><div class="input">'.form_input('titles[]', $values->titles[$i]).'</div><label for="links[]">Link For '.$files[$i]->name.'</label><div class="input">'.form_dropdown('links[]', array(false => 'None')+array_for_select($this->page_m->get_all(), 'id', 'title'), $values->links[$i]).'</div><div class="input">'.form_input('custom_links[]', $values->custom_links[$i], 'placeholder="Custom URL"').'</div></li>';
		}
		$this->template->image_inputs = $template;
	}

	public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			// pass the ids and let MY_Model delete the items
			$this->swipe_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->swipe_m->delete($id);
		}
		redirect('admin/swipe');
	}

	public function order() {
		$items = $this->input->post('items');
		$i = 0;
		foreach($items as $item) {
			$item = substr($item, 5);
			$this->swipe_m->update($item, array('order' => $i));
			$i++;
		}
	}

	public function image_count($folderid)
	{
		$folderid = $this->input->post('folderid');
		$folder = Files::folder_contents($folderid);
		$files = $folder['data']['file'];
		$count = count($files);
		$template = '';
		foreach ($files as $file) {
			$template .= '<li><label for="titles[]">Title For '.$file->name.'</label><div class="input">'.form_input('titles[]', $file->name).'</div><label for="links[]">Link For '.$file->name.'</label><div class="input">'.form_input('links[]', '').'</div></li>';
		}
		echo $template;
		return true;
	}

}
