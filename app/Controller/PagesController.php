<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter(){
		$this->Auth->allow('index', 'view', 'display');
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
	
		App::import('model', 'User');
		App::import('model', 'Course');
		App::import('model', 'Round');
		$users = new User();
		$courses = new Course();
		$rounds = new Round();
		
		$topUsers = $users->find('all', array(
						'joins' => array(
								array(
									'table' => 'player_stats',
									'alias' => 'PlayerStats',
									'type' => 'INNER',
									'conditions' => array('PlayerStats.userId = User.id', 'PlayerStats.roundCount >' => 0)
								)
						),
						'limit' => 10,
						'order' => array('PlayerStats.roundCount DESC'),
						'fields' => array('User.username', 'User.id', 'PlayerStats.roundCount', 'PlayerStats.totalScore')));
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
							'fields' => array('Course.id', 'Course.name', 'User.username', 'User.id', 'Round.score', 'Round.date')));
		$this->set('recentRounds', $recentRounds);
		
		$topCourses = $courses->find('all', array(
						'joins' => array(
									array(
										'table' => 'rounds',
										'alias' => 'Round',
										'type' => 'INNER',
										'conditions' => array('Round.courseId = Course.id')
									)
						),
						'limit' => 10,
						'order' => array('Count(Round.score) DESC'),
						'group' => array('Course.id'),
						'fields' => array('Course.id, count(Round.score) as roundCount', 'SUM(Round.score) as totalScore', 'Course.name')));
		$this->set('topCourses', $topCourses);
		
		$this->Auth->allow('index', 'view');
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
