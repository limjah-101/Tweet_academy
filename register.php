<?php 
require "config/config.php";
require "includes/form_handlers/register_handler.php";
require "includes/form_handlers/login_handler.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

    <form action="register.php" method="POST">
        <?php if (in_array("Email or Password don't match<br>", $error_message)) echo "Email or Password don't match<br>";?><br>
        <input type="email" name="log_email" placeholder="your email"
        value="<?php if(isset($_SESSION['log_email']))echo $_SESSION['log_email'];?>">
        <br><br>
        <input type="password" name="log_pwd" placeholder="your password">
        <br><br>
        <input type="submit" value="login" name="login_btn">

    </form>



    
    <form action="register.php" method="POST">

        <?php if (in_array("<span>Account created</span>", $error_message)) echo "<span>Account created</span>";?>
        <br>
        <input type="text" name="reg_fname" id="" placeholder="First Name"
            value="<?php if(isset($_SESSION['reg_fname'])) echo $_SESSION['reg_fname'];?>">        
        <br>
        <?php if (in_array("Your first name must be between 2 to 20 characters", $error_message)) echo "Your first name must be between 2 to 20 characters";?>
        <br>
        <input type="text" name="reg_lname" id="" placeholder="Last Name"
            value="<?php if(isset($_SESSION['reg_lname']))echo $_SESSION['reg_lname'];?>">
        <br>
        <?php if (in_array("Your last name must be between 2 to 20 characters", $error_message)) echo "Your last name must be between 2 to 20 characters";?><br>

        <input type="email" name="reg_email" id="" placeholder="Email"
            value="<?php if(isset($_SESSION['reg_email']))echo $_SESSION['reg_email'];?>">
        <br>
        <?php if (in_array("Sorry, email already exist", $error_message)) echo "Sorry, email already exist";
        else if (in_array("Invalid email format", $error_message)) echo "Invalid email format";
        else if (in_array("Email don't match", $error_message)) echo "Email don't match";?>
        <br>

        <input type="email" name="reg_conf_email" id="" placeholder="Confirm Email"
            value="<?php if(isset($_SESSION['reg_conf_email']))echo $_SESSION['reg_conf_email'];?>">
        <br><br>

        <input type="password" name="reg_pwd" id="" placeholder="Password"> 
        <br>       
        <?php if (in_array("Password doesn't match", $error_message)) echo "Password doesn't match";
        else if (in_array("Password must contain latin characters or numbers", $error_message)) echo "Password must contain latin characters or numbers";
        else if (in_array("Password must be at least 6 characters", $error_message)) echo "Password must be at least 6 characters";?>
        <br>
        <input type="password" name="reg_conf_pwd" id="" placeholder="Confirm Password">
        <br><br>
        <input type="submit" value="register" name="reg_btn">
    </form>



</body>
</html>

