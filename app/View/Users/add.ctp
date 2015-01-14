<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
        <?php echo $this->Form->input('username');
		echo $this->Form->input('email');
        echo $this->Form->input('password');
		echo $this->Form->input('confirmPassword', array('type' => 'password'));
		?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>