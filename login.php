<?php
//session_start();
//require 'redirectHTTPS.php';
//include 'errorReporting.php';
include 'loginheader.php';
include 'footer.php';

$loginHTML = <<< EOF
<html lang="en">
      <body>
	<header>
		$loginhead
	</header>
		
		<div class="form">
  			<div class="thumbnail"><img src="//s3-us-west-2.amazonaws.com/s.cdpn.io/169963/hat.svg"/></div>
  				<form method="POST" action="session_check.php" enctype="multipart/form-data" class="login-form">
    					<input type="text" name="Username" placeholder="E-mail"/>
    					<input type="password" name="Password" placeholder="Κωδικός" autocomplete="on"/>
    					<button type="submit" name="Submit">Σύνδεση</button>
  				</form>
		</div>
               

  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="index.js"></script></section>

     <footer>
         		$footer
    </footer>
    </body>
</html>
EOF;
echo $loginHTML;
?>