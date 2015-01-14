<?php
	class RoundsController extends AppController{
		public function play(){
			App::import('model', 'Course');
			App::import('model', 'Hole');
			
			$hole = new Hole();
			$course = new Course();
			$courseId = $this->params['named']['id'];
			
			$this->set('course', $course->findAllById($courseId));
			
			$this->set('holes', $hole->find('all', array('conditions' => array('Hole.courseId' => $courseId))));
			$holeData = $hole->find('all', array('conditions' => array('Hole.courseId' => $courseId)));
			
		}
		
		public function add(){
			App::import('model', 'RoundHole');
			App::import('model', 'PlayerStat');
			App::import('model', 'PlayerCourseStat');
			
			$roundHole = new RoundHole();
			$playerStat = new PlayerStat();
			$playerCourseStat = new PlayerCourseStat();
			
			$userId = $this->Session->read('Auth.User')['id'];
			$courseId = $this->request->data['Rounds']['courseId'];
			
			//$lowestScore = PlayerCourseStat->find('all', array('conditions' => array('userId' => $userId, 'courseId' => $courseId) 'fields' => 'lowestScore'));
			
			$date = date('Y-m-d H:i:s');
			$roundData = array('Round' => array('userId' => $userId, 'courseId' => $courseId, 'date' => $date, 'score' => $this->request->data['Rounds']['totalScorePass'], 'comments' => $this->request->data['Rounds']['roundCommentsPass']));
			if($this->Round->save($roundData)){
				$this->Session->setFlash(__('The Round has been saved.'));
				
				$roundId = $this->Round->getInsertID();
				$roundHoleData = array();
				$scoreCounts = array('albatrossCount' => 0, 'holeCount' => 0, 'eagleCount' => 0, 'birdieCount' => 0, 'parCount' => 0, 'bogeyCount' => 0, 'doubleBogeyCount' => 0, 'tripleBogeyCount' => 0);
				for($i = 0; $i < (floor(count($this->request->data['Rounds']) - 2) / 3) - 1; $i++){
					if($this->request->data['Rounds']['score'.$i] != '-') { $scoreCounts['holeCount']++; }
					if($this->request->data['Rounds']['score'.$i] == '-3'){ $scoreCounts['albatrossCount']++;}
					else if($this->request->data['Rounds']['score'.$i] == '-2'){ $scoreCounts['eagleCount']++; }
					else if($this->request->data['Rounds']['score'.$i] == '-1'){ $scoreCounts['birdieCount']++; }
					else if($this->request->data['Rounds']['score'.$i] == '0'){ $scoreCounts['parCount']++; }
					else if($this->request->data['Rounds']['score'.$i] == '1'){ $scoreCounts['bogeyCount']++; }
					else if($this->request->data['Rounds']['score'.$i] == '2'){ $scoreCounts['doubleBogeyCount']++; }
					else if($this->request->data['Rounds']['score'.$i] == '3'){ $scoreCounts['tripleBogeyCount']++; }
				 	
					array_push($roundHoleData, array('roundId' => $roundId, 
													'holeNumber' => $i + 1, 
													'score' => $this->request->data['Rounds']['score'.$i], 
													'putts' =>  $this->request->data['Rounds']['putts'.$i], 
													'comments' => $this->request->data['Rounds']['comment'.$i]));
				}
				
				$playerStatQuery = array('PlayerStat.roundCount' => 'PlayerStat.roundCount+1', 
											'PlayerStat.holeCount' => 'PlayerStat.holeCount + '.$scoreCounts['holeCount'],
											'PlayerStat.totalScore' => 'PlayerStat.totalScore + '.$this->request->data['Rounds']['totalScorePass'],
											'PlayerStat.albatrossCount' => 'PlayerStat.albatrossCount + '.$scoreCounts['albatrossCount'],
											'PlayerStat.eagleCount' => 'PlayerStat.eagleCount + '.$scoreCounts['eagleCount'],
											'PlayerStat.birdieCount' => 'PlayerStat.birdieCount + '.$scoreCounts['birdieCount'],
											'PlayerStat.parCount' => 'PlayerStat.parCount + '.$scoreCounts['parCount'],
											'PlayerStat.bogeyCount' => 'PlayerStat.bogeyCount + '.$scoreCounts['bogeyCount'],
											'PlayerStat.doubleBogeyCount' => 'PlayerStat.doubleBogeyCount + '.$scoreCounts['doubleBogeyCount'],
											'PlayerStat.tripleBogeyCount' => 'PlayerStat.tripleBogeyCount + '.$scoreCounts['tripleBogeyCount'],
										);
										
				
										
				
				
				if($roundHole->saveAll($roundHoleData)){ $this->Session->setFlash(__('The Round Holes has been saved.')); }
				else{ $this->Session->setFlash(__('The Round Holes could not be saved.')); }
				
				if($playerStat->updateAll($playerStatQuery, array('PlayerStat.userId' => $userId))){ $this->Session->setFlash(__('Stats saved!')); }
				else{ $this->Session->setFlash(__('Could not save.')); }
				
				$previous = $playerCourseStat->find('all', array('conditions' => array('userId' => $userId, 'courseId' => $courseId)));
				if(!empty($previous)){
					if($this->request->data['Rounds']['totalScorePass'] < $previous[0]['PlayerCourseStat']['lowestScore']){$lowestScore = $this->request->data['Rounds']['totalScorePass'];}
					else { $lowestScore = $previous[0]['PlayerCourseStat']['lowestScore']; }
					$playerCourseStatQuery = array('PlayerCourseStat.roundCount' => 'PlayerCourseStat.roundCount+1', 
											'PlayerCourseStat.holeCount' => 'PlayerCourseStat.holeCount + '.$scoreCounts['holeCount'],
											'PlayerCourseStat.totalScore' => 'PlayerCourseStat.totalScore + '.$this->request->data['Rounds']['totalScorePass'],
											'PlayerCourseStat.lowestScore' => $lowestScore,
											'PlayerCourseStat.albatrossCount' => 'PlayerCourseStat.albatrossCount + '.$scoreCounts['albatrossCount'],
											'PlayerCourseStat.eagleCount' => 'PlayerCourseStat.eagleCount + '.$scoreCounts['eagleCount'],
											'PlayerCourseStat.birdieCount' => 'PlayerCourseStat.birdieCount + '.$scoreCounts['birdieCount'],
											'PlayerCourseStat.parCount' => 'PlayerCourseStat.parCount + '.$scoreCounts['parCount'],
											'PlayerCourseStat.bogeyCount' => 'PlayerCourseStat.bogeyCount + '.$scoreCounts['bogeyCount'],
											'PlayerCourseStat.doubleBogeyCount' => 'PlayerCourseStat.doubleBogeyCount + '.$scoreCounts['doubleBogeyCount'],
											'PlayerCourseStat.tripleBogeyCount' => 'PlayerCourseStat.tripleBogeyCount + '.$scoreCounts['tripleBogeyCount'],
										);
					if($playerCourseStat->updateAll($playerCourseStatQuery,  array('PlayerCourseStat.userId' => $userId, 'PlayerCourseStat.courseId' => $courseId))){ $this->Session->setFlash(__('Stats saved!')); }
				}
				else{
					if($playerCourseStat->save(array('userId' => $userId, 'courseId' => $courseId, 'roundCount' => 1, 'holeCount' => $scoreCounts['holeCount'], 'totalScore' => $this->request->data['Rounds']['totalScorePass'], 'lowestScore' => $this->request->data['Rounds']['totalScorePass'], 'albatrossCount' => $scoreCounts['albatrossCount'], 'eagleCount' => $scoreCounts['eagleCount'], 'birdieCount' => $scoreCounts['birdieCount'], 'parCount' => $scoreCounts['parCount'], 'bogeyCount' => $scoreCounts['bogeyCount'], 'doubleBogeyCount' => $scoreCounts['doubleBogeyCount'], 'tripleBogeyCount' => $scoreCounts['tripleBogeyCount']))){ $this->Session->setFlash(__('Stats saved!')); }
				}
				
				return $this->redirect(array('controller' => 'users', 'action' => 'view', 'id' => $userId));
			}
			else{ $this->Session->setFlash(__('Could not save.')); }
		}
		
		public function view($id = null){
			App::import('model', 'Course');
			App::import('model', 'RoundHole');
			$course = new Course();
			$roundHole = new RoundHole();
			
			if($this->params['named']['id']){ $id = $this->params['named']['id']; }
			$this->Round->id = $id;
			
			if(!$this->Round->exists()){ throw new NotFoundException(__('Invalid Round')); }
			$holes = $this->Round->find('all', array(
				'joins' => array(
						array(
							'table' => 'courses',
							'alias' => 'Courses',
							'type' => 'INNER',
							'conditions' => array('Courses.id = Round.courseId')
						),
						array(
							'table' => 'round_holes',
							'alias' => 'RoundHoles',
							'type' => 'INNER',
							'conditions' => array('RoundHoles.roundId = Round.id')
						)
					),
				'conditions' => array('Round.id' => $this->Round->id),
				'fields' => array('Courses.*', 'Round.*', 'RoundHoles.*')));
			$this->set('holes', $holes);
		}
	}
?>