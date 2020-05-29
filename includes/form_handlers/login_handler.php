<?php

if (isset($_POST["login_btn"])){
    $email = filter_var($_POST["log_email"], FILTER_SANITIZE_EMAIL);
    $_SESSION["log_email"] = $email;

    $pwd = md5($_POST["log_pwd"]);

    $check_email = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bindValue(1, $email);
    $stmt->bindValue(2, $pwd);
    $stmt->execute();

    if ($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row["username"];        
        //
        $permission = "SELECT * FROM users WHERE email = ? AND user_closed = ?";
        $stmt = $conn->prepare($permission);
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, "yes");
        $stmt->execute();
        if ($stmt->rowCount() > 0){
            $query = "UPDATE users SET user_closed=? WHERE email=?";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(1, "no");            
            $stmt->bindValue(2, $email); 
            $stmt->execute();
        }
        //
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        array_push($error_message, "Email or Password don't match<br>");
    }

}