<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Swipe extends Module {

	public $version = '1.1.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Swipe'
				),
			'description' => array(
				'en' => 'create sliders with swipe.js'
				),
			'frontend' => true,
			'backend' => true,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Swipe',
			'sections' => array(
				'items' => array(
					'name' 	=> 'swipe:items', // These are translated from your language file
					'uri' 	=> 'admin/swipe',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'swipe:create',
							'uri' 	=> 'admin/swipe/create',
							'class' => 'add'
							)
						)
					)
				)
			);
	}

	public function install()
	{
		$this->dbforge->drop_table('swipe');
		//$this->db->delete('settings', array('module' => 'swipe'));

		$this->load->library('files/files');
		Files::create_folder(0, 'swipe');

		$swipe = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'auto_increment' => TRUE
				),
			'order' => array(
				'type' => 'INT',
				'constraint' => '11',
				'null' => true
				),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => false
				),
			'folder' => array(
				'type' => 'INT',
				'constraint' => '11',
				'null' => false
				),
			'startslide' => array(
				'type' => 'INT',
				'constraint' => '2',
				'null' => false
				),
			'speed' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '400',
				'null' => false
				),
			'auto' => array(
				'type' => 'INT',
				'constraint' => '4',
				'default' => '3000',
				'null' => false
				),
			'continuous' => array(
				'type' => 'INT',
				'constraint' => '1',
				'default' => 1
				),
			'disablescroll' => array(
				'type' => 'INT',
				'constraint' => '1',
				'default' => 0
				),
			'stoppropagation' => array(
				'type' => 'INT',
				'constraint' => '1',
				'default' => 0
				),
			);

		// $swipe_setting = array(
		// 	'slug' => 'swipe_setting',
		// 	'title' => 'Swipe Setting',
		// 	'description' => 'A Yes or No option for the Swipe module',
		// 	'`default`' => '1',
		// 	'`value`' => '1',
		// 	'type' => 'select',
		// 	'`options`' => '1=Yes|0=No',
		// 	'is_required' => 1,
		// 	'is_gui' => 1,
		// 	'module' => 'swipe'
		// 	);

		$this->dbforge->add_field($swipe);
		$this->dbforge->add_key('id', TRUE);

		if($this->dbforge->create_table('swipe') AND
		   //$this->db->insert('settings', $swipe_setting) AND
			is_dir($this->upload_path.'swipe') OR @mkdir($this->upload_path.'swipe',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		$folder = $this->file_folders_m->get_by('name', 'swipe');
		Files::delete_folder($folder->id);
		$this->dbforge->drop_table('swipe');
		//$this->db->delete('settings', array('module' => 'swipe'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
