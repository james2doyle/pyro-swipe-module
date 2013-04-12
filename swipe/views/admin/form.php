<section class="title">
	<!-- We'll use $this->method to switch between swipe.create & swipe.edit -->
	<h4><?php echo lang('swipe:'.$this->method); ?></h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<div class="form_inputs">
			<ul class="fields">
				<li>
					<label for="name">Name</label>
					<div class="input"><?php echo form_input('name', $name, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="folder">Folder</label>
					<div class="input"><?php echo form_dropdown('folder', $folders, $folder); ?></div>
				</li>
				<li>
					<label for="startslide">Start Slide</label>
					<div class="input"><?php echo form_input('startslide', $startslide, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="speed">Speed</label>
					<div class="input"><?php echo form_input('speed', $speed, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="auto">Auto</label>
					<div class="input"><?php echo form_input('auto', $auto, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="continuous">Continuous</label>
					<div class="input"><?php echo form_dropdown('continuous', array(0 => 'false', 1 => 'true'), (is_null($continuous)) ? 1: $continuous); ?></div>
				</li>
				<li>
					<label for="disablescroll">Disable Scroll</label>
					<div class="input"><?php echo form_dropdown('disablescroll', array(0 => 'false', 1 => 'true'), $disablescroll); ?></div>
				</li>
				<li>
					<label for="stoppropagation">Stop Propagation</label>
					<div class="input"><?php echo form_dropdown('stoppropagation', array(0 => 'false', 1 => 'true'), $stoppropagation); ?></div>
				</li>
			</ul>

		</div>

		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>

		<?php echo form_close(); ?>
	</div>
</section>