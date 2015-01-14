<?php
	class HolesController extends AppController{
		public $helpers = array('Html', 'Form');
		
		public function index() {
			$this->set('holes', $this->User->find('all'));
		}
		
		
	}
?>