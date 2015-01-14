<?php if($holes[0]['Round']['comments'] != ''){ ?>
<h3>Round Comments</h3>
<?php echo $holes[0]['Round']['comments']; } ?>
<table>
	<tr>
		<th>Hole</th>
		<th>Score</th>
		<th>Putts</th>
		<th>Comments</th>
	</tr>
<?php foreach($holes as $hole): ?>
	<tr>
		<td><?php echo $hole['RoundHoles']['holeNumber']; ?></td>
		<td><?php echo $hole['RoundHoles']['score']; ?></td>
		<td><?php echo $hole['RoundHoles']['putts']; ?></td>
		<td><?php echo $hole['RoundHoles']['comments']; ?></td>
	</tr>
<?php endforeach; ?>
</table>