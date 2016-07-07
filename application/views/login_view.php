<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<div>
			<?php echo validation_errors();?>
			<?php echo form_submit();?>
				<label for="username">Username:</label> 
				<input type="text" id="username" name="username"><br/>
				<label for="password">Password:</label> 
				<input type="password" id="password" name="password"><br/>
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>