<?php
	
		include('upload-code.php'); // Include upload code Script page.
		
?>
	
	
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, intial-scale=1.0"/>
	<title>Babadum | upload image and audio</title>
	<style>
	
		html, body{background: #ececec; height: 100%; margin: 0; font-family: Arial;}
		.main{height: 100%; display: flex; justify-content: center;}
		.main .image-box{width:300px; margin-top: 30px;}
		.main h2{text-align: center; color: #4D4D4D;}

		.main .tb{width: 100%; height: 40px; margin-bottom: 5px; padding-left: 5px;}
		.main .file_input{margin-top: 10px; margin-bottom: 10px;}
		.main .btn{width: 100%; height: 40px; border: none; border-radius: 3px; background: #27a465; color: #f7f7f7;}
		.main .msg{color: red; text-align: center;}


		.main .tb1{width: 100%; height: 40px; margin-bottom: 5px; padding-left: 5px;}
		.main .file_input1{margin-top: 10px; margin-bottom: 10px;}
		.main .btn1{width: 100%; height: 40px; border: none; border-radius: 3px; background: #27a465; color: #f7f7f7;}
		.main .msg{color: red; text-align: center;}
	
	</style>
	</head>

	<body>
	<!-------------------Main Content------------------------------>
	<div class="container main" >
		<div class="image-box">
			<h2>Image Upload</h2>
			<form method="POST" name="upfrm" action="" enctype="multipart/form-data">
				<div>
					<input type="text" placeholder="Enter image name" name="img-name" class="tb" />

					<label for="imagefile">Select Image File</label>
					<input type="file" id="imagefile" name="fileImg" class="file_input" /></br>

					<label for="audiofile">Select Audio File</label>
					<input type="file" name="fileaudio" id="audiofile" class="file_input1" accept=".ogg,.flac,.mp3" required="required" />
					
					<input type="submit" value="Upload" name="btn_upload" class="btn" />
				</div>
			</form>
			<div class="msg">
			<strong>
				<?php if(isset($error)){echo $error;}?>
			</strong>
			</div>
		</div>
	</div>
	</body>
	</html>
	