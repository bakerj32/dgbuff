<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 * @property PaginatorComponent $Paginator
 */
class CoursesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Course->recursive = 0;
		$this->set('courses', $this->Paginator->paginate());
	}
	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		App::import('model', 'Hole');
		App::import('model', 'User');
		App::import('model', 'Round');
		$rounds = new Round();
		$users = new User();
		$hole = new Hole();
		
		if(!$id){$id = $this->params['named']['id']; }
		if (!$this->Course->exists($id)) {
			throw new NotFoundException(__('Invalid course'));
		}
		
		if(isset($this->params['named']['userId'])){ 
			$userId = $this->params['named']['userId'];
			
			$userData = $users->find('first', array('conditions' => array('id' => $userId)));
			$this->set('userData', $userData);
			
			$this->set('playerStats', $this->Course->find('all', array(
										'joins' => array(
											array(
												'table' => 'player_course_stats',
												'alias' => 'PlayerCourseStats',
												'type' => 'INNER',
												'conditions' => array('PlayerCourseStats.courseId' => $id, 'PlayerCourseStats.userId' => $userId)
											)
										),
									'conditions' => array('Course.id' => $id),
									'group' => array('PlayerCourseStats.id'),
									'fields' => array('Course.*', 
													'SUM(PlayerCourseStats.roundCount) as roundCount',
													'SUM(PlayerCourseStats.totalScore) as totalScore',
													'SUM(PlayerCourseStats.eagleCount) as eagleCount',
													'SUM(PlayerCourseStats.birdieCount) as birdieCount',
													'SUM(PlayerCourseStats.parCount) as parCount',
													'SUM(PlayerCourseStats.bogeyCount) as bogeyCount',
													'SUM(PlayerCourseStats.doubleBogeyCount) as doubleBogeyCount',
													'SUM(PlayerCourseStats.tripleBogeyCount) as tripleBogeyCount'))));
													
			$this->set('playerAverages', $rounds->find('all', array(
							'joins' => array(
								array(
									'table' => 'round_holes',
									'alias' => 'RoundHoles',
									'type' => 'INNER',
									'conditions' => array('RoundHoles.roundId = Round.id', 'Round.userId' => $userId)
								)
							),
							'group' => array('RoundHoles.holeNumber'),
							'conditions' => array('Round.courseId' => $id),
							'fields' => array('RoundHoles.holeNumber, AVG(RoundHoles.score) as holeAvg'))));
		}
		
		else { 
			$this->set('userData', null);
			$this->set('playerStats', null);
			$this->set('playerAverages', null);
		}
		
		$this->set('courseStats', $this->Course->find('all', array(
										'joins' => array(
											array(
												'table' => 'player_course_stats',
												'alias' => 'PlayerCourseStats',
												'type' => 'INNER',
												'conditions' => array('PlayerCourseStats.courseId' => $id)
											)
										),
									'conditions' => array('Course.id' => $id),
									'fields' => array('Course.*', 
													'SUM(PlayerCourseStats.roundCount) as roundCount',
													'SUM(PlayerCourseStats.totalScore) as totalScore',
													'SUM(PlayerCourseStats.eagleCount) as eagleCount',
													'SUM(PlayerCourseStats.birdieCount) as birdieCount',
													'SUM(PlayerCourseStats.parCount) as parCount',
													'SUM(PlayerCourseStats.bogeyCount) as bogeyCount',
													'SUM(PlayerCourseStats.doubleBogeyCount) as doubleBogeyCount',
													'SUM(PlayerCourseStats.tripleBogeyCount) as tripleBogeyCount'))));
													
		$holeAverages = $rounds->find('all', array(
							'joins' => array(
								array(
									'table' => 'round_holes',
									'alias' => 'RoundHoles',
									'type' => 'INNER',
									'conditions' => array('RoundHoles.roundId = Round.id')
								)
							),
							'group' => array('RoundHoles.holeNumber'),
							'conditions' => array('Round.courseId' => $id),
							'fields' => array('RoundHoles.holeNumber, AVG(RoundHoles.score) as holeAvg')));
		$this->set('holeAverages', $holeAverages);
		
		$topUsers = $users->find('all', array(
						'joins' => array(
								array(
									'table' => 'player_course_stats',
									'alias' => 'PlayerCourseStats',
									'type' => 'INNER',
									'conditions' => array('PlayerCourseStats.userId = User.id', 'PlayerCourseStats.roundCount >' => 0, 'PlayerCourseStats.courseId' => $id)
								)
						),
						'limit' => 10,
						'order' => array('PlayerCourseStats.roundCount DESC'),
						
						'fields' => array('User.username', 'User.id', 'PlayerCourseStats.roundCount', 'PlayerCourseStats.totalScore')));
		$this->set('topUsers', $topUsers);
		
		$recentRounds = $rounds->find('all', array(
							'joins' => array(
										array(
											'table' => 'users',
											'alias' => 'User',
											'type' => 'INNER',
											'conditions' => array('User.id = Round.userId')
										),
										array(
											'table' => 'courses',
											'alias' => 'Course',
											'type' => 'INNER',
											'conditions' => array('Course.id = Round.courseId')
										)
							),
							'limit' => 10,
							'order' => array('Round.date DESC'),
							'conditions' => array('Course.id' => $id),
							'fields' => array('Course.id', 'Course.name', 'User.username', 'User.id', 'Round.score', 'Round.date')));
		$this->set('recentRounds', $recentRounds);
				
		$this->set('holes', $hole->find('all', array('conditions' => array('Hole.courseId' => $id))));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Course->exists($id)) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
			$this->request->data = $this->Course->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Course->delete()) {
			$this->Session->setFlash(__('The course has been deleted.'));
		} else {
			$this->Session->setFlash(__('The course could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function search(){
		if($this->request->data){
			$this->set('courses', $this->Course->find('all', array('conditions' => array('Course.name LIKE' => '%'.$this->request->data['Course']['query'].'%'))));
		}
		else{ $this->set('courses', array()); }
	}
}
