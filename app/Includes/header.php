
<?php
	echo $this->Html->image('logo.png', array('url' => array('controller' => 'pages', 'action' => 'index')));
	if($this->Session->read('Auth.User')){
		echo '<span style="float: right;">Logged in as '.$this->Html->link($this->Session->read('Auth.User')['username'], array('controller' => 'users', 'action' => 'view', 'id' => $this->Session->read('Auth.User')['id'])).'</span>';
		echo '<br /><span style="float: right;">'.$this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout')).'</span>';
	}
	else{
		echo '<span style="float: right;">'.$this->Html->link('Login/Register', array('controller' => 'users', 'action' => 'login')).'</span>';
	}
?>