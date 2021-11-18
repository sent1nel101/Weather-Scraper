<?php
	$weather = "";
	$successMessage = "";
	$failMessage = "";
	if (array_key_exists('city', $_GET)) {
		$cityUppercase = strtoupper($_GET['city']);
		$city = str_replace(' ', '', $cityUppercase);

		$file_headers = @get_headers('https://www.weather-forecast.com/locations/'.$city.'/forecasts/latest');
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			$exists = false;
			$failMessage = '<div class="alert alert-danger" role="alert"><h5>No city could be found by that name.</h5></div>';
		}else
		$forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
	
		$pageArray = explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);

		if (sizeof($pageArray) > 1){

		$secondPageArray = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9">', $pageArray[1]);

		if (sizeof($secondPageArray) > 1) {
			$weather = $secondPageArray[0];
			$successMessage = '<div class="alert alert-warning" role="alert"><h5 class="title">The 3-Day Forecast For '.$cityUppercase.'</h5>'.$weather.'</div>';
		} else {
			$failMessage1 = '<div class="alert alert-danger" role="alert"><h5>No city could be found by that name.</h5></div>';
		}
		} else {
			$failMessage2 = '<div class="alert alert-danger" role="alert"><h5>No city could be found by that name.</h5></div>';
		}

}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP Weather Scraper</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
    <div id="appContainer">

      <h1>What's The Weather?</h1>
			<form>
        <fieldset id="fieldset" class="form-group">
				<label for="city"><h4>Enter the name of a city</h4></label>
				<input type="text" class="form-control" name="city" id="city" placeholder="e.g. London, Tokyo">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
			</form>
			<br>

			<div id="resultContainer"><?php
			if ($weather){

				echo $successMessage;
			} else {
				echo $failMessage;
			}
			?>
			</div>
			
    <footer><p>&copy; 2021 | D. McDaniel</p></footer>
    
    </div>

    <script type="text/javascript" src="jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
