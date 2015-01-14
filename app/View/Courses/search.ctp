<?php echo $this->Form->create('Course', array('action' => 'search')); ?>
	<fieldset>
		<legend>
			<?php echo __('Course Search'); ?>
		</legend>
		<?php echo $this->Form->input('query'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Search')); ?>

<div id="searchResults">
	<?php
		if(isset($courses)){
			foreach($courses as $course):
				echo $this->Html->link($course['Course']['name'].' - '.$course['Course']['city'].', '.$course['Course']['state'],
										array('controller' => 'rounds',  'action' => 'play', 'id' => $course['Course']['id'])); 
			    echo '<br />';
		
			endforeach; 
		}
	?>
</div>