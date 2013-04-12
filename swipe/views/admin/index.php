<section class="title">
	<h4><?php echo lang('swipe:item_list'); ?></h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open('admin/swipe/delete');?>
	<?php if (!empty($swipe)): ?>
		<table border="0" class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th>ID</th>
					<th><?php echo lang('swipe:name'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $swipe as $item ): ?>
				<tr id="item_<?php echo $item->id; ?>">
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->id; ?></td>
					<td><?php echo $item->name; ?></td>
					<td class="actions">
						<?php echo
						//anchor('swipe', lang('swipe:view'), 'class="button" target="_blank"').' '.
						anchor('admin/swipe/edit/'.$item->id, lang('swipe:edit'), 'class="button"').' '.
						anchor('admin/swipe/delete/'.$item->id, 	lang('swipe:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
	<?php else: ?>
		<div class="no_data"><?php echo lang('swipe:no_items'); ?></div>
	<?php endif;?>
	<?php echo form_close(); ?>
</div>
</section>