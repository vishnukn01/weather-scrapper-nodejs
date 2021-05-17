<?php

ini_set('error_reporting', E_ALL);
$weather = '';
$errorString = '';

if(!empty($_GET['city'])){

	$city = urlencode($_GET['city']);

	$url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=6e8221ba6807eb591e0151f7e04c48f2';

	 
	 $urlContents = @file_get_contents($url);
		
		$weatherArray = json_decode($urlContents, true);
		
		if($weatherArray['cod']==200){
	 
		 $weatherArray['main']['temp'] = $weatherArray['main']['temp'] - 273.15;
		 
		 if($weatherArray['weather'][0]['description'] == 'few clouds'){
			 $weatherArray['weather'][0]['description'] = 'a '.$weatherArray['weather'][0]['description'];
		 }
		 
		 $weather = "The weather in ".ucwords($_GET['city'])." is currently '".$weatherArray['weather'][0]['description']. "'. The temperature is ".$weatherArray['main']['temp'] ." degree celcius. The humidity is ".$weatherArray['main']['humidity']." % and the wind speed is ".$weatherArray['wind']['speed']." meter/sec.";
		}
		else{
		
			$errorString = "That city could not be found";
			
		}

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Weather scrapper</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel='stylesheet' type='text/css' href='style.css'>
	
  </head>
  
  <body>
	
	<div class='container'>
		<h1>What's the weather?</h1>
	
		<form action='' method='get'>
			  <div class="form-group">
				<label >Enter the name of a city</label>
				<input type="text" class="form-control" name="city" id="city" aria-describedby="emailHelp" placeholder="Eg. Mumbai, Chennai" value="<?php if(!empty($_GET['city'])){echo $_GET['city'];}  ?>" required>
				
			  </div>
			  
			  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<div id='weather'>
			<?php
			if(!empty($_GET['city'])){
					if($weather){
					echo '<div class="alert alert-success" role="alert">'.
							$weather
						  .'</div>';
				}
				if($errorString){
					echo '<div class="alert alert-danger" role="alert"><strong>Error: </strong>'.
							$errorString
						  .'</div>';
				}
			}
			
			?>
		</div>
		
	</div>
	
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	
  </body>
  
</html>