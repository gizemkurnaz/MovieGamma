<?php

require_once "dbconnect.php";

session_start();

$id = $_SESSION['user_login'];

$select_stmt = $db->prepare("SELECT * FROM user WHERE user_id=:uid");
$select_stmt->execute(array(":uid" => $id));

$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
$pp = $row["pp"];

$idp = $row["user_id"];
$password = $row["password"];


if (isset($_REQUEST['btn_submit'])) {
    $oldpassword = strip_tags($_REQUEST["txt_oldpassword"]);
    $newpassword = strip_tags($_REQUEST["txt_newpassword"]);
    $confirmpassword = strip_tags($_REQUEST["txt_confirmpassword"]);

    if (empty($oldpassword)) {
        $errorMsg[] = "Please enter old password !";
    }
    else if (empty($newpassword)) {
        $errorMsg[] = "Please enter new password !";
    }
    else if (empty($confirmpassword)) {
        $errorMsg[] = "Please confirm new password !";
    } else {
        try {



            if(crypt($oldpassword, $password)){
                if ($confirmpassword == $newpassword){

                    if (!isset($errorMsg)) {
                        $hashpassword = password_hash($newpassword, PASSWORD_DEFAULT);
                        $update_stmt = $db->prepare("UPDATE user set password =:upassword where user_id = $idp");

                        if ($update_stmt->execute(array(
                            ':upassword' => $hashpassword,
                        ))) {

                            $updateMsg = "Update Successfully....";
                            header("refresh:2; loginpage.php");
                        }
                    }



                }else{
                    echo "Please make sure both passwords match.";
                }
            }else{
                echo "Your old password was entered incorrectly. Please enter it again.";
            }

        } catch (PDOException $e) {
            echo $e->getMessage();

        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>change Password</title>

    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"></script>


</head>
<style>
    .top_border {
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
        margin-top: 4px;
    }

    .background {
        overflow-x: hidden;
        background-color: #292929;
        background-repeat: no-repeat, repeat;
        background-size: cover;
        justify-content: center;
        align-items: center;

    }

    .search {
        width: 200px;
        height: 25px;
        margin-top: 6px;
        margin-left: 30px;
    }

    .pp {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-top: 2.5px;
        border-color: #F8961E;
        border-style: solid;
        margin-left: 320px;
        border-width: 2px;
    }

    .editcard {
        width: 500px;
        border-width: 5px;
        border-style: solid;
        justify-content: center;
        background-color: #202020;
        padding: 5px;
        border: 5px solid #F9C74F;
        border-radius: 25px;
        margin-top: 60px;
    }

    .leftcard {
        margin-top: 20px;
        border-right-style: solid;
        border-right-width: 1px;
        border-right-color: white;
        height: 175px;
    }

    .pp2 {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border-color: #F8961E;
        border-style: solid;
        border-width: 2px;

    }

    .text {
        color: white;
        font-size: 16px;
    }


</style>


<body class="background">
<div class="  top_border row">

    <div class="col">
        <p class="border_text_style">Movie Gamma</p>
    </div>
    <div class="col " style="margin-left: 520px; margin-top: 5px">
        <a href="profilepage.php">
            <img class="pp" src="userspp/<?php echo $pp ?>" >
        </a>
    </div>
</div>


<?php
if (isset($errorMsg)) {
    foreach ($errorMsg as $error) {
        ?>

        <div class="alert alert-secondary" role="alert">
            <strong>WRONG ! <?php echo $error; ?></strong>
        </div>
        <?php
    }
}
if (isset($updateMsg)) {
    ?>
    <div class="alert alert-secondary">
        <strong><?php echo $updateMsg; ?></strong>
    </div>
    <?php
}
?>

<div class="row">
    <div class="col"></div>
    <div class=" col card-body card-body-color text_body editcard">
        <div class="row" style="margin-bottom: 50px">

            <div class="col-sm-3 leftcard">
                <a class="dropdown-item" href="editprofile.php" style="color: white">Edit Profile</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item " href="#" style="color: #F8961E">Change Password</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="#" style="color: white">Privacy and Security</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="privacypolicy.php" style="color: white">Privacy Policy</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="termsofservice.php" style="color: white">Terms of Service</a>
            </div>

            <div class="col-sm-9" style="margin-top: 30px;">
                <form method="post">
                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>

                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">Old Password</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" type="password"  name='txt_oldpassword' value="">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">New Password</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control"type="password"  name='txt_newpassword'
                                   value="">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">Confirm New Password</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" type="password"  name='txt_confirmpassword'
                                   value="">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class="row" style="margin-top: 50px; margin-left: 250px; width: 100px;">
                        <input type="submit" name="btn_submit" class="btn btn-success" value="Submit">
                    </div>
                </form>

            </div>


        </div>
    </div>
    <div class="col"></div>
</div>

</body>