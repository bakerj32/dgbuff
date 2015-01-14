<br />
	<form>
		9 Holes: <input type="radio" name="holeCountSelect" id="9holes" value="9" checked onChange="updateHoleCount(this)"/>
		18 Holes: <input type="radio" name="holeCountSelect" id="18holes" value="18" onChange="updateHoleCount(this)"/>
	</form>
	<center>
		<div id="front9">
			<table id="scoreTableFront" style="width: 80%;">
				<tr>
					<th>Hole</th>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
					<td>5</td>
					<td>6</td>
					<td>7</td>
					<td>8</td>
					<td>9</td>
					<td>Front Total</td>
				</tr>
				<tr>
					<th>Score</th>
					<td id="hole1">-</td>
					<td id="hole2">-</td>
					<td id="hole3">-</td>
					<td id="hole4">-</td>
					<td id="hole5">-</td>
					<td id="hole6">-</td>
					<td id="hole7">-</td>
					<td id="hole8">-</td>
					<td id="hole9">-</td>
					<td style="color: orange;" id="totalScore">0</td>
				</tr>
			</table>
		</div><br />
		<div id="back9"></div>
		
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
			<tr>
				<td><button name="submitHole" id="submitHole">Next Hole</button></td>
			</tr>
		</table>
	</center>