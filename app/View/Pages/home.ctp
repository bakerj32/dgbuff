<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */

?>


<?php
	//include('../View/Users/login.ctp');
	include('../View/Courses/search.ctp');
?>

<div id="topUsers"  style="width: 49%; float: left; display: inline;">
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
				<td><?php echo $topUser['PlayerStats']['roundCount']; ?></td>
				<td><?php echo number_format(($topUser['PlayerStats']['totalScore'] / $topUser['PlayerStats']['roundCount']), 3);?></td>
			</tr>
		<?php 
			$count++;
			endforeach; 
		?>
	</table>
</div>

<div id="topCourses" style="width: 49%; float: right; display: inline;">
	<h3>Top Courses</h3>
	<table>
		<tr>
			<th>No. </th>
			<th>Course</th>
			<th>Rounds Played</th>
			<th>Course Average</th>
		</tr>
		<?php
			$count = 1;
			foreach($topCourses as $topCourse):
		?>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $this->Html->link($topCourse['Course']['name'], array('controller' => 'Courses', 'action' => 'view', 'id'=> $topCourse['Course']['id'])); ?></td>
				<td><?php echo $topCourse[0]['roundCount']; ?></td>
				<td><?php echo number_format(($topCourse[0]['totalScore'] / $topCourse[0]['roundCount']), 3); ?></td>
			</tr>
		<?php
			$count++;
			endforeach;
		?>
	</table>
</div>
<br style="clear: both;" />	

<div id="recentRounds">
	<h3>Recent Rounds</h3>
	<table>
		<tr>
			<th>No.</th>
			<th>Player</th>
			<th>Course</th>
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
				<td><?php echo $this->Html->link($recentRound['Course']['name'], array('controller' => 'Courses', 'action' => 'view', 'id' => $recentRound['Course']['id'])); ?></td>
				<td><?php echo $recentRound['Round']['score']; ?></td>
				<td><?php echo $recentRound['Round']['date']; ?></td>
			</tr>
		<?php
			$count++;
			endforeach;
		?>
	</table>
</div>


	

