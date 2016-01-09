<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Nurse scheduling - Zespół V</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/claro/claro.css" />
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojox/calendar/themes/claro/Calendar.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="/res/css/style.css" rel="stylesheet" type="text/css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#startForm").validate({
				submitHandler: function(form) {
					form.submit();
				},
				rules: {
					"nurse[36]": { required: true, digits: true, min: 1, max: 30 },
					"nurse[32]": { required: true, digits: true, min: 1, max: 30 },
					"nurse[20]": { required: true, digits: true, min: 1, max: 30 },
					"date[days]": { required: true, digits: true, min: 14 },
					"date[startDate]": { required: true, date: true }
				},
				messages: {
					"nurse[36]": {
						required: "To pole jest wymagane!",
						digits: "To pole może zawierać jedynie liczby!",
						min: "Podana wartość musi być większa niż 1",
						max: "Podana wartość musi być mniejsza niż 30"
					},
					"nurse[32]": {
						required: "To pole jest wymagane!",
						digits: "To pole może zawierać jedynie liczby!",
						min: "Podana wartość musi być większa niż 1",
						max: "Podana wartość musi być mniejsza niż 30"
					},
					"nurse[20]": {
						required: "To pole jest wymagane!",
						digits: "To pole może zawierać jedynie liczby!",
						min: "Podana wartość musi być większa niż 1",
						max: "Podana wartość musi być mniejsza niż 30"
					},
					"date[days]": {
						required: "To pole jest wymagane!",
						digits: "To pole może zawierać jedynie liczbę całkowitą!",
						min: "Minimalnie 14 dni!"
					},
					"date[startDate]": {
						required: "To pole jest wymagane!",
						date: "To pole może zawierać jedynie datę w formacie YYYY-MM-DD!"
					}
				}
			});
		});
	</script>
</head>
<body id="page" class="claro">
{$content}
</body>
</html>
