<h2><?php echo $user['User']['username']; ?></h2>

<div id="playerStats" style="width: 25%; display: inline; float: right">
	<h3>Stats</h3>
	<table >
		<tr>
			<th>Rounds Played</th>
			<td><?php echo $userStats[0]['PlayerStat']['roundCount']; ?></td>
		</tr>
		<tr>
			<th>Holes Played</th>
			<td><?php echo $userStats[0]['PlayerStat']['holeCount']; ?></td>
		</tr>
		<tr>
			<th>Average Score</th>
			<td><?php echo number_format(($userStats[0]['PlayerStat']['totalScore'] / $userStats[0]['PlayerStat']['roundCount']), 3); ?></td>
		</tr>
		<tr>
			<th>Albatross's</th>
			<td><?php echo $userStats[0]['PlayerStat']['albatrossCount']; ?></td>
		</tr>
		<tr>
			<th>Eagles</th>
			<td><?php echo $userStats[0]['PlayerStat']['eagleCount']; ?></td>
		</tr>
		<tr>
			<th>Birdies</th>
			<td><?php echo $userStats[0]['PlayerStat']['birdieCount']; ?></td>
		</tr>
		<tr>
			<th>Pars</th>
			<td><?php echo $userStats[0]['PlayerStat']['parCount']; ?></td>
		</tr>
		<tr>
			<th>Bogey Count</th>
			<td><?php echo $userStats[0]['PlayerStat']['bogeyCount']; ?></td>
		</tr>
		<tr>
			<th>Double Bogeys</th>
			<td><?php echo $userStats[0]['PlayerStat']['doubleBogeyCount']; ?></td>
		</tr>
		<tr>
			<th>Triple Bogeys</th>
			<td><?php echo $userStats[0]['PlayerStat']['tripleBogeyCount']; ?></td>
		</tr>
		
	</table>
</div>
<div id="recentRounds" style="width: 70%; display: inline; float: left;">
	<h3>Recent Rounds</h3>
	<table>
		<tr>
			<th>Score</th>
			<th>Course</th>
			<th>Location</th>
			<th>Date</th>
			<th>Details</th>
		</tr>

	<?php foreach($recentRounds as $round): ?> 
				<tr>
					<td><?php echo $round['Round']['score']; ?></td>
					<td><?php echo $this->Html->link($round['Courses']['name'], array('controller' => 'courses', 'action' => 'view', 'id' => $round['Courses']['id'])); ?></td>
					<td><?php echo $round['Courses']['city'].', '.$round['Courses']['state']; ?></td>
					<td><?php echo date_format(date_create($round['Round']['date']), 'd/m/Y'); ?></td>
					<td><?php echo $this->Html->link('Round Details', array('controller' => 'rounds', 'action' => 'view', 'id' => $round['Round']['id'])); ?></td>
				</tr>
			

		<?php endforeach; ?>
	</table>
</div>
<br style="clear: both;" />

<div id="playerCourses">
	<h3>My Courses</h3>
	<table>
		<tr>
			<th>Course Name</th>
			<th>Round Count</th>
			<th>Best Score</th>
			<th>Average Score</th>
		</tr>
		<?php foreach($userCourses as $course): ?>
			<tr>
				<td><?php echo $this->Html->link($course['Courses']['name'], array('controller' => 'courses', 'action' => 'view', 'id' => $course['Courses']['id'], 'userId' => $user['User']['id'])); ?></td>
				<td><?php echo $course['PlayerCourseStat']['roundCount']; ?></td>
				<td><?php echo $course['PlayerCourseStat']['lowestScore']; ?></td>
				<td><?php echo number_format(($course['PlayerCourseStat']['totalScore'] / $course['PlayerCourseStat']['roundCount']), 3); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>