<?php

require_once "dbconnect.php";

session_start();

$id = $_SESSION['user_login'];


$select_stmt = $db->prepare("SELECT * FROM user WHERE user_id=:uid");
$select_stmt->execute(array(":uid" => $id));

$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

$namep = $row["name"];
$surnamep = $row["lastname"];
$pp = $row["pp"];
$usernamep = $row["username"];
$emailp = $row["email"];
$idp = $row["user_id"];


if (isset($_REQUEST['btn_submit'])) {
    $name = strip_tags($_REQUEST["txt_name"]);
    $lastname = strip_tags($_REQUEST['txt_lastname']);
    $email = strip_tags($_REQUEST['txt_email']);
    $username = strip_tags($_REQUEST['txt_username']);

    $pp = strip_tags($_REQUEST['image']);

    if(empty($pp)){
        $pp = $row["pp"];
    }

    if (empty($name)) {
        $errorMsg[] = "Please enter name";
    }
    if (empty($lastname)) {
        $errorMsg[] = "Please enter last name";
    } else if (empty($email)) {
        $errorMsg[] = "Please enter email";
    } else if (empty($username)) {
        $errorMsg[] = "Please enter username";


    } else {
        try {
            if (!isset($errorMsg)) {

                $insert_stmt = $db->prepare("UPDATE user set name =:uname, lastname =:ulastname,username = :uusername,email = :uemail, pp = :upp where user_id = $idp");

                if ($insert_stmt->execute(array(
                    ':uname' => $name,
                    ':ulastname' => $lastname,
                    ':uusername' => $username,
                    ':uemail' => $email,
                    ':upp' => $pp,
                ))) {

                    $updateMsg = "Update Successfully....";
                    header("refresh:2; profilepage.php");
                }
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
    <title>Edit Profile</title>

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
    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }


</style>


<body class="background">
<div class="  top_border row">

    <div class="col">
        <p class="border_text_style">Movie Gamma</p>
    </div>

    <div class="col " style="margin-left: 520px; margin-top: 5px">
        <a href="profilepage.php">
            <img class="pp" src="userspp/<?php echo $pp ?>">
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
                <a class="dropdown-item" href="#" style="color: #F8961E">Edit Profile</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item " href="changepassword.php" style="color: white">Change Password</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="#" style="color: white">Privacy and Security</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="privacypolicy.php" style="color: white">Privacy Policy</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="termsofservice.php" style="color: white">Terms of Service</a>
            </div>

            <div class="col-sm-9" style="margin-top: 30px;">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <img class="pp2 " src="userspp/<?php echo $pp ?>"/>
                        </div>
                        <div class="col-sm-5" >
                            <input id="Upload" type="file" multiple="multiple" name="image" style="visibility: hidden">

                            <label class="btn btn-primary  vertical-center">
                                <i class="fa fa-image"></i> Change Profile Photo<input type="file" style="display: none;" name="image">
                            </label>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>

                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">Name</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" style="background-color: #373737;color: white" name='txt_name' value="<?php echo $namep; ?>">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">Last Name</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" style="background-color: #373737;color: white" type="text" name='txt_lastname'
                                   value="<?php echo $surnamep; ?>">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">User Name</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" style="background-color: #373737;color: white" name='txt_username'
                                   value="<?php echo $usernamep; ?>">

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4" style="margin-top: 5px">
                            <label class="text" style="justify-content: center">Email</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" style="background-color: #373737;color: white"type="text" name='txt_email' value="<?php echo $emailp; ?>">
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
<button class="btn" style="background-color: #F8961E; margin-left: 1000px; margin-top: 20px; margin-bottom: 20px" >
    <a style="color: #373737" href="logout.php">Logout</a>
</button>
</body>

<script>
    var res = "success";
    inputElement = document.getElementById('file')
    labelElement = document.getElementById('file-name')
    inputElement.onchange = function (event) {
        var path = inputElement.value;
        if (path) {
            labelElement.innerHTML = path.split(/(\\|\/)/g).pop()
        } else {
            labelElement.innerHTML = 'Bla bla'
        }
    }
</script>