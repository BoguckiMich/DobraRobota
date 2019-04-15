<?php
	// Message Vars
	$msg = '';
	$msgClass = '';

	// Check For Submit
	if(filter_has_var(INPUT_POST, 'submit')){
		// Get Form Data
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		// Check Required Fields
		if(!empty($email) && !empty($name) && !empty($message)){
			// Passed
			// Check Email
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				// Failed
				$msg = 'Błędny mail';
				$msgClass = 'alert-danger';
			} else {
				// Passed
				$toEmail = 'mbologik@gmail.com';
				$subject = 'Kontaktuje sie z Tobą: '.$name;
				$body = '<h2>Prośba kontaktu</h2>
					<h4>Imię</h4><p>'.$name.'</p>
					<h4>Email</h4><p>'.$email.'</p>
					<h4>Wiadomość</h4><p>'.$message.'</p>
				';

				// Email Headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .="Content-Type:text/html;charset=UTF-8" . "\r\n";

				// Additional Headers
				$headers .= "Od: " .$name. "<".$email.">". "\r\n";

				if(mail($toEmail, $subject, $body, $headers)){
					// Email Sent
					$msg = 'Twoj email został wysłany';
					$msgClass = 'alert-success';
					header("refresh:2 ; URL=http://www.dobrarobota.pro/index.php");
				} else {
					// Failed
					$msg = 'Twoj email nie został wysłany';
					$msgClass = 'alert-danger';
				}
			}
		} else {
			// Failed
			$msg = 'Proszę wypełnij wszystkie pola';
			$msgClass = 'alert-danger';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
	<meta name="viewport" content="width=device-width, inital-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/contact.css">
</head>
<body>
  <header>
    <h2><a href="/index.php">Dobra Robota</a></h2>
    <nav>
      <li><a href="/index.php#offer">Oferta</a></li>
      <li><a href="/index.php#galeria">Galeria</a></li>
      <li><a href="/contact.php" class="btn btn-outline-warning" style="margin-top:-5px">Napisz do nas!</a></li>
    </nav>
  </header>
  <section class="background-image" style="background-image:url(/img/dobra-top3.jpg)">
    <div class="container" >
    	<?php if($msg != ''): ?>
    	<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    	<?php endif; ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	      <div class="form-group">
		      <label>Imię</label>
		      <input type="text" placeholder="imię" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
	      </div>
	      <div class="form-group">
	      	<label>Email</label>
	      	<input type="text" placeholder="e-mail" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
	      </div>
	      <div class="form-group">
	      	<label>Wiadomość</label>
	      	<textarea name="message" placeholder="wiadomość" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
	      </div>
	      <br>
	      <button type="submit" name="submit" class="btn btn-primary srodek">Odezwij się!</button>
      </form>
    </div>
  </section>

</body>
</html>
