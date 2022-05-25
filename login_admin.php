<?php

require_once "dbconnect.php";

session_start();

if(isset($_REQUEST['btn_login']))
{
    $email		=strip_tags($_REQUEST["txt_email"]);
    $password	=strip_tags($_REQUEST["txt_password"]);


    if(empty($email)){
        $errorMsg[]="please enter email";
    }
    else if(empty($password)){
        $errorMsg[]="please enter password";
    }
    else
    {
        try
        {

            $select_stmt=$db->prepare("SELECT * FROM admin WHERE email_a=:aemail");


            $select_stmt->execute(array(':aemail'=>$email));

            $row=$select_stmt->fetch(PDO::FETCH_ASSOC);


            if($select_stmt->rowCount() > 0)
            {

                if($email==$row["email_a"])
                {
                    if($password ==  $row["password_a"])
                    {
                        $_SESSION["admin_login"] = $row["id_a"];
                        $loginMsg = "Successfully Login...";
                        header("refresh:13; adminhome.php");

                    }
                    else
                    {

                        $errorMsg[]="wrong password";
                    }
                }
                else
                {
                    $errorMsg[]="wrong  email";
                }
            }
            else
            {

                $errorMsg[]="wrong email";
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();

        }
    }
} else{

}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="background">

<style>
    .reg_style{
        width:25rem;
        height: auto;
        background-color: #333533;
        margin-top: 60px;
    }
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
    .background{
        overflow-x: hidden;
        background-color: #ffffff;
        background-image: url("bg4.png");
        background-repeat: no-repeat, repeat;
        background-size: cover;
    }
    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

</style>



<div class="top_border">
    <p class="border_text_style">Movie Gamma</p>
</div>
<?php
if(isset($errorMsg))
{
    foreach($errorMsg as $error)
    {
        ?>
        <div class="alert alert-secondary">
            <strong><?php echo $error; ?></strong>
        </div>
        <?php
    }
}
if(isset($loginMsg))
{
    ?>
    <div class="alert alert-success">
        <strong><?php echo $loginMsg; ?></strong>
    </div>
    <?php
}
?>

<div class="row">

    <div class="col"></div>
    <div class="col">

        <div class="card reg_style">

            <div class="card-header card-header-color text_color" align="center">
                <H4>ADMIN LOGIN PAGE</H4>
                <p class="mb-0"> You have to fiil inputs to log in.</p>
            </div>

            <div class="card-body card-body-color text_body">
                <form  method = "post">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input class="form-control" type="email" name="txt_email">
                    </div>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input class="form-control" type="password"  name="txt_password">
                    </div>
                    <div align="center">
                        <input type="submit" name="btn_login" class="btn btn-success" value="Login" >
                    </div>

                </form>
            </div>


            <div class="card-footer card-footer-color"  style="color: #f4f1de;">
                <div style="margin-left: 110px">Are you an  <a href="loginpage.php">user</a> ?</div>
            </div>

        </div>
    </div>

    <div class="col-4"></div>

</div>

</div>

</body>

</html>

