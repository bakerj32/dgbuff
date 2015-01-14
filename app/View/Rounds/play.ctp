
	<?php
		function getHoleInfoHtml($holes){
			$holeInfoHtml = '<h1 id="holeInfo">Hole #'.$holes[0]['Hole']['holeNumber'];
			if($holes[0]['Hole']['redLength'] != 0 && $holes[0]['Hole']['redLength'] != ''){
				$holeInfoHtml .= ' - '.$holes[0]['Hole']['redLength'].' ft.';
			}
			if($holes[0]['Hole']['whiteLength'] != 0 && $holes[0]['Hole']['whiteLength'] != ''){
				$holeInfoHtml .= ' - '.$holes[0]['Hole']['whiteLength'].' ft.';
			}
			if($holes[0]['Hole']['blueLength'] != 0 && $holes[0]['Hole']['blueLength'] != ''){
				$holeInfoHtml .= ' - '.$holes[0]['Hole']['blueLength'].' ft.';
			}
			if($holes[0]['Hole']['yellowLength'] != 0 && $holes[0]['Hole']['yellowLength'] != ''){
				$holeInfoHtml .= ' - '.$holes[0]['Hole']['yellowLength'].' ft.';
			}
			if($holes[0]['Hole']['orangeLength'] != 0 && $holes[0]['Hole']['orangeLength'] != ''){
				$holeInfoHtml .= ' - '.$holes[0]['Hole']['orangeLength'].' ft.';
			}
			$holeInfoHtml .= '</h1>';
			return $holeInfoHtml;
		}
		
		function getScoreTableHtml($holes){
			$html = '<table id="scoreTable" style="width: 80%">'.
						'<tr>'.
							'<th>Hole</th>';
			$rowsLeft = count($holes) - 1;
			$rowsToAdd = 0;
			$holeCount = 1;
			$idCount = 1;
			$totalScoreCount = 0;
			while($rowsLeft >= 0){
				$html .= '<td>'.(string)($holeCount).'</td>';
				if($holeCount % 9 == 0 && $holeCount != 0){
					$html .= '<td>Total</td>'.
							'</tr>'.
							 '<tr>'.
								'<th>Score</th>';
					for($i = 0; $i < 9; $i++){
						$html .= '<td id="hole'.$idCount.'">-</td>';
						$idCount++;
					}
					$html .= '<td style="color: orange;" id="totalScore'.(string)ceil(($idCount - 1) / 9).'">0</td>'.
							'</tr>'.
						'</table>';
					if($rowsLeft > 0){
						$html .= 
								'<table>'.
								'<tr>'.
									'<th>Hole</th>';
					}
				}
				else{
					$rowsToAdd++;
				}
				$holeCount++;
				$rowsLeft--;
			}
			return $html;
			
		}
		
		$this->Js->set('holeData', $holes);
		echo $this->Js->writeBuffer(array('onDomReady' => false));
		echo $this->Html->script('play');
		echo '<h1>'.$course[0]['Course']['name'].'</h1>';
		echo getHoleInfoHtml($holes);
		
		
		
		
	?>

	<center>
		<?php echo getScoreTableHtml($holes); ?>
		<div id="overallTotal"><h2 style="color: black;">Total Score: <span id="totalScoreOverall">0</span></div>
		<table id="inputTable">
			<tr>
				<td>Hole: </td>
				<td><input type="text" size="2" name="currentHoleNumber" id="currentHoleNumber" value="1"/></td>
				<td><button name="incrementHole" id="incrementHole">+</button>
				<button name="decrementHole" id="decrementHole">-</button></td>
			</tr>
			<tr>
			
				<td>Score: </td>
				<td><input type="text" size="2" name="currentHoleScore" id="currentHoleScore" value="0"/></td>
				<td><button name="incrementScore" id="incrementScore">+</button>
				<button name="decrementScore" id="decrementScore">-</button></td>
			</tr>
		</table>
	</center>
	
	<div id="moreOptions">
		<h3>More Options</h3>
		<table>
			<tr>
				<td>Putts: </th>
				<td><input type="text" size="2" name="currentPutts" id="currentPutts" value=""/></td>
			</tr>
			<tr>
				<td>Hole Comments</th>
				<td><textarea name="holeComments" id="holeComments" /></textarea></td>
			</tr>
			<tr>
				<td>Round Comments</th>
				<td><textarea name="roundComments" id="roundComments" /></textarea></td>
			</tr>
		</table>
	</div>
	
	<br />
	<button name="submitHole" id="submitHole">Next Hole</button>
	
	<?php
		echo $this->Form->create('Rounds', array('action' => 'add'));
		echo $this->Form->input('courseId', array('type' => 'hidden', 'default' => $course[0]['Course']['id']));
		for($i = 0; $i < count($holes); $i++){
			$scoreId = 'score'.$i;
			$commentId = 'comment'.$i;
			$puttId = 'putts'.$i;
			echo $this->Form->input($scoreId, array('default' => '-', 'id' => $scoreId,'type' => 'hidden'));
			echo $this->Form->input($commentId, array('default' => '-', 'id' => $commentId,'type' => 'hidden'));
			echo $this->Form->input($puttId, array('default' => '-', 'id' => $puttId,'type' => 'hidden'));
		}
		echo $this->Form->input('roundCommentsPass', array('default' => '-', 'id' => 'roundCommentsPass', 'type' => 'hidden')); 
		echo $this->Form->input('totalScorePass', array('default' => '-', 'id' => 'totalScorePass', 'type' => 'hidden')); 
		echo $this->Form->end('Submit Round');
	?>
	
	