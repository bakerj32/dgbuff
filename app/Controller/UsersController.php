<?php
	class UsersController extends AppController{
		public $helpers = array('Html', 'Form');
		public $components = array('Session');
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('add', 'logout');
		}
		
		public function index() {
			$this->User->recursive = 0;
			$this->set('users', $this->paginate());
		}
		
		public function view($id = null){
			App::import('model', 'Course');
			App::import('model', 'Round');
			App::import('model', 'PlayerStat');
			App::import('model', 'PlayerCourseStat');
			
			$course = new Course();
			$round = new Round();
			$playerStat = new PlayerStat();
			$playerCourseStat = new PlayerCourseStat();
			
			if($this->params['named']['id']){ $id = $this->params['named']['id']; }
			$this->User->id = $id;
			if(!$this->User->exists()){ throw new NotFoundException(__('Invalid User')); }
			$this->set('user', $this->User->read(null, $id));
			
			$recentRounds = $round->find('all', array(
				'joins' => array(
						array(
							'table' => 'courses',
							'alias' => 'Courses',
							'type' => 'INNER',
							'conditions' => array('Courses.id = Round.courseId')
						)
					),
				'conditions' => array('Round.userId' => $id), 
				'limit' => 10,
				'order' => array('Round.date DESC'),
				'fields' => array('Courses.*', 'Round.*')));
			$this->set('recentRounds', $recentRounds);
			
			$userCourses = $playerCourseStat->find('all', array(
				'joins' => array(
							array(
								'table' => 'courses',
								'alias' => 'Courses',
								'type' => 'inner',
								'conditions' => array('Courses.id = PlayerCourseStat.courseId')
							)
						),
					'conditions' => array('PlayerCourseStat.userId' => $id),
					'fields' => array('Courses.name', 'Courses.id', 'PlayerCourseStat.totalScore', 'PlayerCourseStat.roundCount', 'PlayerCourseStat.lowestScore')));
			$this->set('userCourses', $userCourses);
			$userStats = $playerStat -> find('all', array('conditions' => array('userId' => $id)));
			$this->set('userStats', $userStats);
			
		}
		
		public function add(){
			App::import('model', 'PlayerStat');
			$playerStat = new PlayerStat();
			
			if ($this->request->is('post')) {
				$this->User->create();
				if($this->request->data['User']['password'] == $this->request->data['User']['confirmPassword']){
					if($this->User->save($this->request->data)){
						$this->Session->setFlash(__('Thank you for registering.'));
						$row = array('userId' => $this->User->getInsertID(), 'roundCount' => 0, 'holeCount' => 0, 'avgScore' => 0, 'avgHoleScore' => 0, 'albatrossCount' => 0, 'eagleCount' => 0, 'birdieCount' => 0, 'parCount' => 0, 'bogeyCount =>' => 0, 'doubleBogeyCount' => 0, 'tripleBogeyCount' => 0);
						$playerStat->save($row);
						return $this->redirect(array('action' => 'login'));
					}
					$this->Session->setFlash(__('There was a problem registering. Please try again.'));
				}
				$this->Session->setFlash(__('Passwords must match.'));
				
			}
		}
		
		public function edit($id = null){
			$this->User->id = $id;
			if(!$this->User->exists()){ throw new NotFoundException(__('Invalid User')); }
			if($this->request->is('post') || $this->request->is('put')){
				if($this->User->save($this->request->data)){
					$this->Session->setFlash(__('The user has been saved.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(__('The user could not be saved. Please try again.'));
			}
			else{
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
		}
		
		public function delete($id = null){
			$this->request->onlyAllow('post');
			
			$this->User->id = $id;
			if(!$this->User->exists()){ throw new NotFoundException(__('Invalid user')); }
			if($this->User->delete()){
				$this->Session->setFlash(__('User deleted'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('User was not deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		
		public function login(){
			if($this->request->is('post')){
				if($this->Auth->login()){ return $this->redirect($this->Auth->redirect()); }
				$this->Session->setFlash(__('Invalid username or password.'));
			}
		}
		
		public function logout(){ return $this->redirect($this->Auth->logout());} }
?>