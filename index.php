<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<style>
			#chord-table {
				margin-top: 20px;
				display:none;
			}
			.form-group {
				margin-top:20px;
			}	
		</style>
	</head>
	<body>
		<div class='container'>
			<div class='form-group'>
				<label for='chord-input'><h3>Paste Chords/Lyrics Here</h3></label>
				<textarea class='form-control' id='chord-input' rows='20'></textarea>
			</div>
			<button class="btn btn-primary" id='submit-button'>Submit</button>
			<button class="btn btn-primary" id='sample'>Sample Input</button>
			<button class="btn btn-primary" id='clear'>Clear</button>
			<table class='table' id='chord-table'>
				<thead>
					<tr>
						<th>Change</th>
						<th style='text-align:right'>Count</th>
						<th style='text-align:right'>Percent</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<script
		  src="https://code.jquery.com/jquery-3.3.1.min.js"
		  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		  crossorigin="anonymous"></script>
		<script type="text/javascript" src="sample_chords.js"></script>
		<script src="jquery.tablesorter.min.js"></script>
		<script>
			$(function() {
				$('#chord-table').tablesorter({
					sortList: [[2,1]]
				});
			});
			$('#submit-button').click(function() {
				var input = $('#chord-input').val();

				$.post('chord_ajax.php', { input: input }, function (data) {
					var rows;
					if (Object.keys(data).length > 0) {
						$('#chord-table').show();
					}
					$('#chord-table tbody').html('');

					$.each(data, function(index,value) {
						rows += "<tr><td>" + index + 
							  "</td><td align='right'>" + value.count + 
							  "</td><td align='right'>" + value.percentage +
							  "</td></tr>";
						
					});
					$('#chord-table tbody').append(rows).trigger("update");
					var sorting = $("#chord-table")[0].config.sortList;
					setTimeout(function () {
						$("#chord-table").trigger("sorton", [sorting]);
					}, 100);
					
				}, 'json');	
			});
			$('#sample').click(function() {
				$('#chord-input').val(sample_chords);
				$('#submit-button').click();
			});
			$('#clear').click(function() {
				$('#chord-input').val('');
				$('#chord-table').hide();
			});
		</script>
	</body>
</html>
