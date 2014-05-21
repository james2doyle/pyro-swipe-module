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
					<label for="name"><?php echo lang('swipe:name') ?><small><?php echo lang('swipe:name:small') ?></small></label>
					<div class="input"><?php echo form_input('name', $name, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="folder"><?php echo lang('swipe:folder') ?><small><?php echo lang('swipe:folder:small') ?></small></label>
					<div class="input"><?php echo form_dropdown('folder', $folders, $folder); ?></div>
				</li>
				<li>
					<label for="startslide"><?php echo lang('swipe:startslide') ?><small><?php echo lang('swipe:startslide:small') ?></small></label>
					<div class="input"><?php echo form_input('startslide', $startslide, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="speed"><?php echo lang('swipe:speed') ?><small><?php echo lang('swipe:speed:small') ?></small></label>
					<div class="input"><?php echo form_input('speed', $speed, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="auto"><?php echo lang('swipe:auto') ?><small><?php echo lang('swipe:speed:small') ?></small></label>
					<div class="input"><?php echo form_input('auto', $auto, 'class="width-15"'); ?></div>
				</li>
				<li>
					<label for="continuous"><?php echo lang('swipe:continuous') ?></label>
					<div class="input"><?php echo form_dropdown('continuous', array(0 => 'false', 1 => 'true'), (is_null($continuous)) ? 1: $continuous); ?></div>
				</li>
				<li>
					<label for="disablescroll"><?php echo lang('swipe:disablescroll') ?></label>
					<div class="input"><?php echo form_dropdown('disablescroll', array(0 => 'false', 1 => 'true'), $disablescroll); ?></div>
				</li>
				<li>
					<label for="stoppropagation"><?php echo lang('swipe:stoppropagation') ?></label>
					<div class="input"><?php echo form_dropdown('stoppropagation', array(0 => 'false', 1 => 'true'), $stoppropagation); ?></div>
				</li>
				<fieldset>
					<legend><?php echo lang('swipe:fieldset') ?></legend>
					<small><?php echo lang('swipe:fieldset:small') ?></small>
					<hr>
					<ul id="slide-titles">
						<?php echo $image_inputs; ?>
					</ul>
				</fieldset>
			</ul>

		</div>

		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>

		<?php echo form_close(); ?>
	</div>
</section>
<script>
	$(document).ready(function() {
		var $slideTitles = $('#slide-titles');
		// get the method for this page
		var method = '<?php echo $this->method; ?>';
		function getInputs(folderid) {
			$.post(BASE_URL + 'admin/swipe/image_count', {
				folderid: folderid,
				csrf_hash_name: $.cookie(pyro.csrf_cookie_name)
			}, function(res){
				$slideTitles.html(res);
			});
		}
		if (method == 'create') {
			getInputs($('select[name="folder"]').val());
		}
		$('select[name="folder"]').on('change', function(e) {
			if (method == 'edit') {
				// confirm that they want to erase the old forms when editing
				var check = confirm('Changing the folder will empty the title fields. \nAre you sure you want to continue?');
				if (!check) {
					return;
				}
			}
			getInputs(this.value);
		});
	});
</script>