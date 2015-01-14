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

function updateHoleInfo(){
	var currentHole = document.getElementById('currentHoleNumber').value;
	holeInfo = 'Hole #' + (currentHole).toString();
	if(window.app.holeData[currentHole - 1]['Hole']['redLength'] != 0){
		holeInfo += ' - ' + window.app.holeData[currentHole - 1]['Hole']['redLength'].toString() + 'ft. (Red)';
	}
	document.getElementById('holeInfo').innerText = holeInfo;
}

function handleHoleUpdate(){

	
	var holeNumber = document.getElementById('currentHoleNumber').value
	var holeScore = document.getElementById('currentHoleScore').value
	var id = Math.ceil((holeNumber) / 9);
	
	document.getElementById('hole' + holeNumber).innerText = holeScore
	
	if(holeScore > 0){ $("#hole" + holeNumber).css("color", "red"); }
	else if(holeScore < 0){ $("#hole" + holeNumber).css("color", "green"); }
	else { $("#hole" + holeNumber).css("color", "orange"); }
	
	document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) + 1;
	document.getElementById('currentHoleScore').value = 0;
	
	
	document.getElementById('totalScore'+id).innerText = parseInt(document.getElementById('totalScore'+id).innerText) + parseInt(holeScore);
	document.getElementById('totalScoreOverall').innerText = parseInt(document.getElementById('totalScoreOverall').innerText) + parseInt(holeScore);

	document.getElementById('totalScorePass').value = parseInt(document.getElementById('totalScoreOverall').innerText);
	if(parseInt(document.getElementById('totalScoreOverall').innerText) > 0){ $("#totalScoreOverall").css("color", "red"); }
	else if(parseInt(document.getElementById('totalScoreOverall').innerText) < 0){ $("#totalScoreOverall").css("color", "green"); }
	else { $("#totalScoreOverall").css("color", "orange"); }
	
	
	//Update hidden fields
	var holeId = 'score' + (holeNumber - 1).toString();
	document.getElementById(holeId).value = holeScore;
	
	var commendId = 'comment' + (holeNumber - 1).toString();
	document.getElementById(commendId).value = document.getElementById('holeComments').value;
	document.getElementById('holeComments').value = '';
	
	var puttId = 'putts' + (holeNumber - 1).toString();
	document.getElementById(puttId).value = document.getElementById('currentPutts').value;
	document.getElementById('currentPutts').value = '';

	
	document.getElementById('roundCommentsPass').value = document.getElementById('roundComments').value;
	
	updateHoleInfo();
	
}



function buttonHandler(button){
	var holeCount = window.app.holeData.length;
	var currentHole = document.getElementById('currentHoleNumber').value;
	
	if(button.name == 'incrementScore'){
		document.getElementById('currentHoleScore').value = parseInt(document.getElementById('currentHoleScore').value) + 1;
	}
	else if(button.name == 'decrementScore'){
		document.getElementById('currentHoleScore').value = parseInt(document.getElementById('currentHoleScore').value) - 1;
	}
	else if(button.name == 'incrementHole'){

		document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) + 1;
		if (parseInt(document.getElementById('currentHoleNumber').value) > holeCount){ document.getElementById('currentHoleNumber').value = 1;}
		updateHoleInfo(currentHole);
	}
	else if(button.name == 'decrementHole'){

		document.getElementById('currentHoleNumber').value = parseInt(document.getElementById('currentHoleNumber').value) - 1;
		if (parseInt(document.getElementById('currentHoleNumber').value) <= 0){ document.getElementById('currentHoleNumber').value = holeCount;}
		updateHoleInfo(currentHole);
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
	});
	
	$("#moreOptions").accordion({
		collapsible: true,
		active: false
	});
  });