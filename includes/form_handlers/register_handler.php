<?php
//GET INPUT
$first_name="";
$last_name = "";
$email = "";
$conf_email = "";
$pwd = "";
$conf_pwd = "";
$date = "";
$error_message = [];

if (isset($_POST["reg_btn"])){
    $first_name = trim(strip_tags($_POST["reg_fname"]));
    $first_name = ucfirst(strtolower($first_name));
    $_SESSION['reg_fname'] = $first_name;

    $last_name = trim(strip_tags($_POST["reg_lname"]));
    $last_name = ucfirst(strtolower($last_name));
    $_SESSION['reg_lname'] = $last_name;

    $email = trim(strip_tags($_POST["reg_email"]));    
    $_SESSION['reg_email'] = $email;

    $conf_email = trim(strip_tags($_POST["reg_conf_email"]));    
    $_SESSION['reg_conf_email'] = $conf_email;

    $pwd = trim(strip_tags($_POST["reg_pwd"]));    
    $conf_pwd = trim(strip_tags($_POST["reg_conf_pwd"]));    
            
    $date = date("Y-m-d");
    
    if ($email == $conf_email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            $query = "SELECT email from users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(1, $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0){                
                array_push($error_message, "Sorry, email already exist");
            }             
        }else{            
            array_push($error_message, "Invalid email format");
        }

    }else{        
        array_push($error_message, "Email don't match");        
    }
    //INPUT FIELDS VALIDATION
    if ( strlen($first_name) > 20 || strlen($first_name) < 2 ){
        
        array_push($error_message, "Your first name must be between 2 to 20 characters");
    }
    if ( strlen($last_name) > 20 || strlen($last_name) < 2 ){        
        array_push($error_message, "Your last name must be between 2 to 20 characters");
    }
    if ($pwd != $conf_pwd){
        array_push($error_message, "Password doesn't match");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $pwd)){            
            array_push($error_message, "Password must contain latin characters or numbers");
        }
    }
    if ( strlen($pwd) < 6 ){        
        array_push($error_message, "Password must be at least 6 characters");
    }

    //ASSIGN USERNAME AUTOMATICALLY
    if (empty($error_message)){
        $pwd = md5($pwd);
        $username = strtolower($first_name . "_" . $last_name);
        $check_user_name = "SELECT username FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_user_name);
        $stmt->bindValue(1, $username);
        $stmt->execute();

        $i = 0;
        while ($stmt->rowCount() > 0){
            $username = $username . "_" . $i;
            $check_user_name = "SELECT username FROM users WHERE username = ?";
            $stmt = $conn->prepare($check_user_name);
            $stmt->bindValue(1, $username);
            $stmt->execute();
        }

        //ASSIGN RANDOM DEFAULT PROFILE PICS
        $random = rand(1,2);
        if ($random = 1){
            $profile_pic = "assets/images/profile_pics/defaults/default_profile.png";
        } else if($random = 2){
            $profile_pic = "assets/images/profile_pics/defaults/default_avatar.jpg";
        }

        $query  = "INSERT INTO users 
            (firstname, lastname, username, email, password, created_at, profile_pic, num_posts, num_likes, user_closed, friend_array) 
            VALUES ('$first_name', '$last_name', '$username', '$email', '$pwd', '$date', '$profile_pic', '0', '0', 'no', ',')";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        array_push($error_message, "<span>Account created</span>");

        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_conf_email'] = "";
        // unset($_SESSION);
    }
}

?>