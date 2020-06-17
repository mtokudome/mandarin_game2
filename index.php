<?php
// Start the session
include "imageclass.php";
session_start();
?>

<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, intial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Mandarin Flashcard</title>

	</head>

	<body>
	
	<div class="parent">
<?php
	include "connection.php";
	include "getimages.php";
	
	if (!isset($_SESSION['visited'])) {
		$_SESSION['visited'] = array();
	  }

	$GLOBALS['result'] = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
	mysqli_select_db($GLOBALS['result'],$db_name) or die("Could not select the databse." .mysqli_error());
	$image_query = mysqli_query($GLOBALS['result'],"select img_name,img_path from image_table");
	
	$total = 0;
	
	while($rows = mysqli_fetch_array($image_query))
	{
		$total++;
	}
	
	$GLOBALS['totals'] = $total;

	$myimage = array();
	

	$num = 1;

	function changeImages(){

		$myimage[] = new image();
		$myimage[] = new image();
		$myimage[] = new image();
		$myimage[] = new image();

		$rnumbers = array();
		$rnumbers = UniqueRandomNumbersWithinRange(1,$GLOBALS['totals'],4);
	
		$randIndex = array_rand($rnumbers);
		$correct = $rnumbers[$randIndex];
		$GLOBALS['correct'] = $correct;
		
		$counter = 0;
		for ($i=0, $len=count($_SESSION['visited']); $i<$len; $i++) {

			if($len >= $GLOBALS['totals']){
				// All the images in the database are visited
				$counter = 0;
				unset($_SESSION['visited']);
				$_SESSION['visited'] = array();

				echo "<script>alert('Game Completed');</script>";
			}
			else if($correct == $_SESSION['visited'][$i]->img_id){

				if($counter < 4){
					// Choosing another image as correct from the 4 choosen images
					$counter++;
					$randIndex = array_rand($rnumbers);
					$correct = $rnumbers[$randIndex];
					$i=0;
				}
				else {
					// Recalculating 4 images indexes
					$rnumbers = UniqueRandomNumbersWithinRange(1,$GLOBALS['totals'],4);
					$randIndex = array_rand($rnumbers);
					$correct = $rnumbers[$randIndex];
					$counter = 0;
					$i=0;
				}
			}
			
		}

		$num = 1;
		while($num < 5)
		{
			$index = $num - 1;
			
			$q = "select img_id, img_name,img_path,img_audio from image_table where img_id=" . $rnumbers[$index];
			$image_query1 = mysqli_query($GLOBALS['result'],$q);
			$rows = mysqli_fetch_array($image_query1);
			
			$myimage[$index]->img_id = $rows['img_id'];
			$myimage[$index]->img_name = $rows['img_name'];
			$myimage[$index]->img_path = $rows['img_path'];
			$myimage[$index]->img_audio = $rows['img_audio'];
			if($correct == $rnumbers[$index]){
				$GLOBALS['correctone'] = $myimage[$index];
				$GLOBALS['count'] = $num;
			}
			
			$num++;
		}

		$num = 0;
		while($num < 4)
		{
		?>
		<div class="center">
			<img src="<?php echo $myimage[$num]->img_path; ?>" alt="" id="<?php echo $num; ?>" title="<?php echo $myimage[$num]->img_name; ?>" class="img-responsive imghover" >
			
		</img>
		</div>

		<?php
			$num++;
		}
	}
	  
	changeImages();
	
	if (!isset($_SESSION['visited'])) {
		$_SESSION['visited'] = array();
	  } else {
		array_push($_SESSION['visited'], $GLOBALS['correctone']);
	  }
	
	?>

	</div>
<span id="span1" style="color:green; text-align: center; display:none; left:25%; top:25%; margin-left: -40px; margin-top: -50px; position:absolute; font-size:min(max(24px, 10vw), 100px);"  >&#10004;</span>
            
<span id="span2" style="color:green; text-align: center; display:none; right:25%; top:25%; margin-right: -40px; margin-top: -50px; position:absolute; font-size:min(max(24px, 10vw), 100px);"  >&#10004;</span>
            
<span id="span3" style="color:green; text-align: center; display:none; left:25%; top:75%; margin-left: -40px; margin-top: -50px; position:absolute; font-size:min(max(24px, 10vw), 100px);"  >&#10004;</span>
           
<span id="span4" style="color:green; text-align: center; display:none; right:25%; top:75%; margin-right: -40px; margin-top: -50px; position:absolute; font-size:min(max(24px, 10vw), 100px);"  >&#10004;</span>
            


<span id="wrong0" style="color:red; text-align: center; display:none; left:25%; top:25%; margin-left: -40px; margin-top: -50px; position:absolute; font-size:min(max(26px, 14vw), 150px);"  >&#735;</span>
            
<span id="wrong1" style="color:red; text-align: center; display:none; right:25%; top:25%; margin-right: -40px; margin-top: -50px; position:absolute; font-size:min(max(26px, 14vw), 150px);"  >&#735;</span>
            
<span id="wrong2" style="color:red; text-align: center; display:none; left:25%; top:75%; margin-left: -40px; margin-top: -50px; position:absolute; font-size:min(max(26px, 14vw), 150px);"  >&#735;</span>
           
<span id="wrong3" style="color:red; text-align: center; display:none; right:25%; top:75%; margin-right: -40px; margin-top: -50px; position:absolute; font-size:min(max(26px, 14vw), 150px);"  >&#735;</span>
           

<h2 id="correct" class="centered-element"></h2>


<!-- audio files players  -->
	
<audio autoplay="true" id="myaudio"> 
  <source id="audiofile"  src="" type="audio/ogg">
</audio>

<audio id="correct1"> 
  <source id="corrects"  src="audio/correct.mp3" type="audio/mpeg">
</audio>

<audio id="incorrect1"> 
  <source id="incorrects"  src="audio/incorrect.mp3" type="audio/mpeg">
</audio>

<script>

	// Setting up Correct value
	var correct = "<?php echo $GLOBALS['correctone']->img_name ?>"
	document.getElementById("correct").innerText = correct

	document.getElementById("audiofile").src = "<?php echo $GLOBALS['correctone']->img_audio ?>"
	
	var elements = document.getElementsByClassName("img-responsive");
	function wait(ms){
		var start = new Date().getTime();
		var end = start;
		while(end < start + ms) {
			end = new Date().getTime();
		}
	}

	function displaynow(){
		var y = "span<?php echo $GLOBALS['count']?>"
		document.getElementById(y).style.display = "inline";
		console.log(y);

	}

	function reloadpage(){
		location.reload();
		wait(1000);  //1 seconds in milliseconds
	}

	var myFunction = function() {
		var attribute = this.getAttribute("title");
		this.className += " active";

		if(attribute == correct){
			displaynow();
			
			document.getElementById("corrects").src = "audio/correct.mp3"
			var x = document.getElementById("correct1")
			x.play()

			/* alert("You are correct") */
		}
		else {

			displaynow();
			document.getElementById("incorrects").src = "audio/correct.mp3"
			var x = document.getElementById("incorrect1")
			x.play()

			var z = "wrong" + this.id;
			document.getElementById(z).style.display = "inline";
			/* alert("You are Incorrect") */
		}
		
		reloadpage();
	}; 

	console.log('before');
	wait(1000);
	console.log('after');

	for (var i = 0; i < elements.length; i++) {
		elements[i].addEventListener('click', myFunction, false);
	}
	
</script>

</body>
</html>