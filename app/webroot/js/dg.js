function updateHoleCount(count){
	if(count.value == 18){
		document.getElementById('back9').innerHTML = 
			'<table id="scoreTableBack" style="width: 80%;"> \
			<tr> \
				<th>Hole</th> \
				<td>10</td> \
				<td>11</td> \
				<td>12</td> \
				<td>13</td> \
				<td>14</td> \
				<td>15</td> \
				<td>16</td> \
				<td>17</td> \
				<td>18</td> \
				<td>Back Total</td> \
			</tr> \
			<tr> \
				<th>Score</th> \
				<td id="hole10">-</td> \
				<td id="hole11">-</td> \
				<td id="hole12">-</td> \
				<td id="hole13">-</td> \
				<td id="hole14">-</td> \
				<td id="hole15">-</td> \
				<td id="hole16">-</td> \
				<td id="hole17">-</td> \
				<td id="hole18">-</td> \
				<td style="color: orange;" id="backTotalScore">0</td> \
			</tr> \
		</table>';
	}
	else { document.getElementById('back9').innerHTML = ''; }
}

function handleHoleUpdate(){
	var holeNumber = document.getElementById('currentHoleNumber').value
	var holeScore = document.getElementById('currentHoleScore').value
	document.getElementById('hole' + holeNumber).innerText = holeScore
	
	if(holeScore > 0){ $("#hole" + holeNumber).css("color", "red"); }
	else if(holeScore < 0){ $("#hole" + holeNumber).css("color", "green"); }
	else { $("#hole" + holeNumber).css("color", "orange"); }
	
	document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) + 1;
	document.getElementById('currentHoleScore').value = 0;
	
	document.getElementById('totalScore').innerText = parseInt(document.getElementById('totalScore').innerText) + parseInt(holeScore);
	if(parseInt(document.getElementById('totalScore').innerText) > 0){ $("#totalScore").css("color", "red"); }
	else if(parseInt(document.getElementById('totalScore').innerText) < 0){ $("#totalScore").css("color", "green"); }
	else { $("#totalScore").css("color", "orange"); }
	
}

function buttonHandler(button){
	if(button.name == 'incrementScore'){
		document.getElementById('currentHoleScore').value = parseInt(document.getElementById('currentHoleScore').value) + 1;
	}
	else if(button.name == 'decrementScore'){
		document.getElementById('currentHoleScore').value = parseInt(document.getElementById('currentHoleScore').value) - 1;
	}
	else if(button.name == 'incrementHole'){
		var holeCount;
		if(document.getElementById('9holes').checked){ holeCount = 9;}
		else{ holeCount = 18; }
		document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) + 1;
		if (parseInt(document.getElementById('currentHoleNumber').value) > holeCount){ document.getElementById('currentHoleNumber').value = 1;}
	}
	else if(button.name == 'decrementHole'){
		var holeCount;
		if(document.getElementById('9holes').checked){ holeCount = 9;}
		else{ holeCount = 18; }
		document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) - 1;
		if (parseInt(document.getElementById('currentHoleNumber').value) <= 0){ document.getElementById('currentHoleNumber').value = holeCount;}
	}
	else if(button.name == 'submitHole'){
		handleHoleUpdate();
	}
	event.preventDefault();
}	
	
  $(function() {
	$("button")
	  .button()
	  .click(function( event ) {
		buttonHandler(this);
	  });
	  
	$( "#courseSearch" ).autocomplete({
		source:'http://localhost/courseSearch.php',
		minLength: 3,
	})
  });