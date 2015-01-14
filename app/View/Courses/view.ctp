<?php
	function getHeader($userData, $courseStats){
		if($userData){$html = $userData['User']['username'].' on '.$courseStats[0]['Course']['name'].' - '.$courseStats[0]['Course']['city'].', '.$courseStats[0]['Course']['state'].' ('.$courseStats[0]['Course']['length'].' ft)';}
		else{$html = $courseStats[0]['Course']['name'].' - '.$courseStats[0]['Course']['city'].', '.$courseStats[0]['Course']['state'].' ('.$courseStats[0]['Course']['length'].' ft)';}
		return $html;
	}
	
	function getHoleInfoTable($holes, $holeAverages, $playerAverages, $userData){
		
		$count = 0;
		$html = '<table>'.
					'<tr>'.
						'<th>Hole No.</th>';
		if($playerAverages){ $html .= '<th>'.$userData['User']['username']."'s Avg</th>"; }
		$html .= 		'<th>Hole Avg.</th>'.
						'<th>Red Length</th>'.
					'<tr>';
		foreach($holes as $hole){
			$html .= '<tr>'.
						'<td>'.$holeAverages[$count]['RoundHoles']['holeNumber'].'</td>';
			if($playerAverages){ $html .= '<td>'.$playerAverages[$count][0]['holeAvg'].'</td>'; }
			$html .= '<td>'.$holeAverages[$count][0]['holeAvg'].'</td>'.
					 '<td>'.$hole['Hole']['redLength'].'</td>'.
					'</tr>';
			$count++;
		}
		
		$html .= '</table>';
		return $html;
	}
	
	function getCourseStatsTable($courseStats, $playerStats, $userData){
		$html = '<table>'.
					'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Rounds Played</th>".
					 '<td>'.$playerStats[0][0]['roundCount'].'</td>';
		}
		$html .=    '<th>Total Rounds Played</th>'.
					'<td>'.$courseStats[0][0]['roundCount'].'</td>
				</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Course Avg</th>".
						'<td>'.number_format(($playerStats[0][0]['totalScore'] / $playerStats[0][0]['roundCount']), 3).'</td>';
		}
		$html .= '<th>Total Course Avg</th>'.
				 '<td>'.number_format(($courseStats[0][0]['totalScore'] / $courseStats[0][0]['roundCount']), 3).'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Eagles</th>".
					 '<td>'.$playerStats[0][0]['eagleCount'].'</td>';
		}
		$html .= '<th>Total Eagles</th>'.
					'<td>'.$courseStats[0][0]['eagleCount'].'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Birdies</th>".
					 '<td>'.$playerStats[0][0]['birdieCount'].'</td>';
		}
		$html .= '<th>Total Birdies</th>'.
					'<td>'.$courseStats[0][0]['birdieCount'].'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Pars</th>".
					'<td>'.$playerStats[0][0]['parCount'].'</td>';
		}
		$html .= '<th>Total Pars</th>'.
					'<td>'.$courseStats[0][0]['parCount'].'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Bogeys</th>".
						'<td>'.$playerStats[0][0]['bogeyCount'].'</td>';
		}
		$html .= '<th>Total Bogeys</th>'.
					'<td>'.$courseStats[0][0]['bogeyCount'].'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Double Bogeys</th>".
					 '<td>'.$playerStats[0][0]['doubleBogeyCount'].'</td>';
		}
		$html .= '<th>Total Double Bogeys</th>'.
					'<td>'.$courseStats[0][0]['doubleBogeyCount'].'</td>'.
				'</tr>'.
				'<tr>';
		if($playerStats){ 
			$html .= '<th>'.$userData['User']['username']."'s Triple Bogeys</th>".
					 '<td>'.$courseStats[0][0]['tripleBogeyCount'].'</td>';
		}
		$html .= '<th>Total Triple Bogeys</th>'.
					'<td>'.$courseStats[0][0]['tripleBogeyCount'].'</td>'.
				'</tr>'.
				'<tr>';
		$html .= '</table>';	

		return $html;
	}
	
	
?>
<div id="playRound" style="float: right;"><?php echo $this->Html->link(__('Play Course'), array('controller' => 'rounds', 'action' => 'play', 'id' => $courseStats[0]['Course']['id'])); ?></div>
<div>
<h2><?php echo getHeader($userData, $courseStats); ?></h2>
</div>
<div id="holes" style="width: 49%; float: right; display: inline;">
	<h3>Hole Info</h3>
	<?php echo getHoleInfoTable($holes, $holeAverages, $playerAverages, $userData); ?>
</div>
<div id="courseStats"  style="width: 49%; float: left; display: inline;">
	<h3> Course Stats</h3>
	<?php echo getCourseStatsTable($courseStats, $playerStats, $userData); ?>
</div>
<br style="clear: both;" />
<div id="topUsers"  style="width: 49%; float: right; display: inline;">
	<h3>Top Users</h3>
	<table>
		<tr>
			<th>No.</th>
			<th>Name</th>
			<th>Round Count</th>
			<th>Average Score</th>
		</tr>
		<?php 
			$count = 1; 
			foreach($topUsers as $topUser): 
		?>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $this->Html->link($topUser['User']['username'], array('controller' => 'Users', 'action' => 'view', 'id' => $topUser['User']['id'])); ?></td>
				<td><?php echo $topUser['PlayerCourseStats']['roundCount']; ?></td>
				<td><?php echo number_format(($topUser['PlayerCourseStats']['totalScore'] / $topUser['PlayerCourseStats']['roundCount']), 3);?></td>
			</tr>
		<?php 
			$count++;
			endforeach;
		?>
	</table>
</div>

<div id="recentRounds" style="width: 49%; float: left; display: inline;">
	<h3>Recent Rounds</h3>
	<table>
		<tr>
			<th>No.</th>
			<th>Player</th>
			<th>Score</th>
			<th>Time</th>
		</tr>
		<?php
			$count = 1;
			foreach($recentRounds as $recentRound):
		?>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $this->Html->link($recentRound['User']['username'], array('controller' => 'Users', 'action' => 'view', 'id' => $recentRound['User']['id'])); ?></td>
				<td><?php echo $recentRound['Round']['score']; ?></td>
				<td><?php echo $recentRound['Round']['date']; ?></td>
			</tr>
		<?php
			$count++;
			endforeach;
		?>
	</table>
</div>


