<?php

require_once "dbconnect.php";

if(isset($_REQUEST['btn_register']))
{
    $name	= strip_tags($_REQUEST['txt_name']);
    $lastname	= strip_tags($_REQUEST['txt_lastname']);
    $email		= strip_tags($_REQUEST['txt_email']);
    $username		= strip_tags($_REQUEST['txt_username']);
    $password	= strip_tags($_REQUEST['txt_password']);

    if(empty($name)){
        $errorMsg[]="Please enter name";
    }
    if(empty($lastname)){
        $errorMsg[]="Please enter last name";
    }
    else if(empty($email)){
        $errorMsg[]="Please enter email";
    }
    else if(empty($username)){
        $errorMsg[]="Please enter username";
    }

    else if(empty($password)){
        $errorMsg[]="Please enter password";
    }
    else if(strlen($password) < 6){
        $errorMsg[] = "Password must be at least 6 characters";
    }
    else
    {
        try
        {
            $select_stmt = $db->prepare("SELECT email FROM user WHERE email=:uemail");
            $select_stmt->execute(array( ':uemail'=>$email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


            $select_stmt = $db->prepare("SELECT username FROM user WHERE username=:uusername");
            $select_stmt->execute(array( ':uusername'=>$username));

            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if($row["username"]==$username){
                $errorMsg[]="Sorry username already exists";
            }
            if($row["email"]==$email){
                $errorMsg[]="Sorry email already exists";
            }
            else if(!isset($errorMsg))
            {
                $new_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_stmt=$db->prepare("INSERT INTO user( name, lastname,username,email,password,pp) VALUES (:uname,:ulastname,:uusername,:uemail,:upassword,'usericon.png')"); 		//sql insert query

                if($insert_stmt->execute(array(
                    ':uname'	=>$name,
                    ':ulastname'=>$lastname,
                    ':uusername'=>$username,
                    ':uemail'	=>$email,
                    ':upassword'=>$new_password))){

                    $registerMsg="Register Successfully..... Please Click On Login Account Link";
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();

        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>


<style>
    .top_border{
        margin-top: 0px;
        background-color: #202020;
        width: -moz-max-content;
        height: 45px;

    }
    .border_text_style {
        font-size: 18px;
        font-weight: bold;
        color: #F8961E;
        vertical-align: center;
        margin-left: 30px;
        font-family: "cursive";
    }
    .reg_style{
        width:30rem;
        height: auto;
        background-color: #333533;
        margin-top: 25px;
    }

    .background{
        overflow-x: hidden;
        background-color: #ffffff;
        background-image: url("bg4.png");
        background-repeat: no-repeat, repeat;
        background-size: cover;

    }
    .text_color{
        font-weight: bold;
        font-family: "Berlin Sans FB Demi";
        color: #F9C74F;
    }
    .text_body{
        color: #F9C74F;
        font-weight: bold;
    }


</style>

<body class="background">

<div class="top_border">
    <p class="border_text_style">Movie Gamma</p>
</div>
<?php
if(isset($errorMsg))
{
    foreach($errorMsg as $error)
    {
        ?>

        <div class="alert alert-secondary" role="alert">
            <strong>WRONG ! <?php echo $error; ?></strong>
        </div>
        <?php
    }
}
if(isset($registerMsg))
{
    ?>
    <div class="alert alert-secondary">
        <strong><?php echo $registerMsg; ?></strong>
    </div>
    <?php
}
?>
<div class="row">

    <div class="col"></div>
    <div class="col">

        <div class="card reg_style">

            <div class="card-header card-header-color  text_color" align="center" >
                <H4>REGISTER PAGE</H4>
                <p class="mb-0"> You have to fiil inputs to register.</p>
            </div>

            <div class="card-body card-body-color text_body" >
                <form  method = "post">
                    <div class="form-group" >
                        <label for="name">Name</label>
                        <input class="form-control" type="text"  name="txt_name">
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input class="form-control" type="text"  name="txt_lastname">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="username" class="form-control"name = 'txt_username' aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address</label>
                        <input type="email" class="form-control"name = 'txt_email' aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input class="form-control is invalid" type="password"  name="txt_password">
                    </div >
                    <div align="center">
                        <input type="submit"  name="btn_register" class="btn btn-success " value="Register">
                    </div>

                </form>
            </div>

            <div class="card-footer card-footer-color" align="center" style="color: #f4f1de">
                You have a account register here? <a href="loginpage.php"><p class="text-info">Login Account</p></a>
            </div>

        </div>
    </div>

    <div class="col-4"></div>

</div>

</body>

</html>