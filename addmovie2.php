<?php
session_start();

require_once "dbconnect.php";

$id = $_SESSION['admin_login'];


$select_stmt = $db->prepare("SELECT * FROM admin WHERE id_a=:uid");
$select_stmt->execute(array(":uid" => $id));

$row1 = $select_stmt->fetch(PDO::FETCH_ASSOC);

$pp = $row1["pp_a"];

$select = $db->prepare("select movie_id from movie order by movie_id DESC ");
$select->execute(array());

$rowm = $select->fetch(PDO::FETCH_ASSOC);
$addedmovie =  $rowm['movie_id'];

if (isset($_REQUEST['btn_submit'])) {
    $actname1 = strip_tags($_REQUEST['txt_actname1']);
    $actname2 = strip_tags($_REQUEST['txt_actname2']);
    $actname3 = strip_tags($_REQUEST['txt_actname3']);
    $actname4 = strip_tags($_REQUEST['txt_actname4']);
    $actname5 = strip_tags($_REQUEST['txt_actname5']);
    $actname6 = strip_tags($_REQUEST['txt_actname6']);
    $actname7 = strip_tags($_REQUEST['txt_actname7']);
    $actname8 = strip_tags($_REQUEST['txt_actname8']);

    $actrole1 = strip_tags($_REQUEST['txt_actrole1']);
    $actrole2 = strip_tags($_REQUEST['txt_actrole2']);
    $actrole3 = strip_tags($_REQUEST['txt_actrole3']);
    $actrole4 = strip_tags($_REQUEST['txt_actrole4']);
    $actrole5 = strip_tags($_REQUEST['txt_actrole5']);
    $actrole6 = strip_tags($_REQUEST['txt_actrole6']);
    $actrole7 = strip_tags($_REQUEST['txt_actrole7']);
    $actrole8 = strip_tags($_REQUEST['txt_actrole8']);

    $actphoto1 = strip_tags($_REQUEST['actphoto1']);
    $actphoto2 = strip_tags($_REQUEST['actphoto2']);
    $actphoto3 = strip_tags($_REQUEST['actphoto3']);
    $actphoto4 = strip_tags($_REQUEST['actphoto4']);
    $actphoto5 = strip_tags($_REQUEST['actphoto5']);
    $actphoto6 = strip_tags($_REQUEST['actphoto6']);
    $actphoto7 = strip_tags($_REQUEST['actphoto7']);
    $actphoto8 = strip_tags($_REQUEST['actphoto8']);


    $mphoto1 = strip_tags($_REQUEST['mphoto1']);
    $mphoto2 = strip_tags($_REQUEST['mphoto2']);
    $mphoto3 = strip_tags($_REQUEST['mphoto3']);
    $mphoto4 = strip_tags($_REQUEST['mphoto4']);
    $mphoto5 = strip_tags($_REQUEST['mphoto5']);



    if (empty($actname1)) {
        $errorMsg[] = "Please enter movie name";
    }
    if (empty($actname2)) {
        $errorMsg[] = "Please enter category name";
    } else if (empty($actname3)) {
        $errorMsg[] = "Please enter all actor name";
    } else if (empty($actname4)) {
        $errorMsg[] = "Please enter all actor name";
    } else if (empty($actname5)) {
        $errorMsg[] = "Please enter all actor name";
    } else if (empty($actname6)) {
        $errorMsg[] = "Please enter all actor name";
    } else if (empty($actname7)) {
        $errorMsg[] = "Please enter all actor name";
    } else if (empty($actname8)) {
        $errorMsg[] = "Please enter all actor name";

    } else if (empty($actrole1)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole2)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole3)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole4)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole5)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole6)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole7)) {
        $errorMsg[] = "Please enter all role name";
    } else if (empty($actrole8)) {
        $errorMsg[] = "Please enter all role name";

    } else if (empty($actphoto1)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto2)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto3)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto4)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto5)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto6)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto7)) {
        $errorMsg[] = "Please enter all actor photo";
    } else if (empty($actphoto8)) {
        $errorMsg[] = "Please enter all actor photo";

    } else if (empty($mphoto1)) {
        $errorMsg[] = "Please enter movie  photo";
    } else if (empty($mphoto2)) {
        $errorMsg[] = "Please enter movie  photo";
    } else if (empty($mphoto3)) {
        $errorMsg[] = "Please enter movie  photo";
    } else if (empty($mphoto4)) {
        $errorMsg[] = "Please enter movie  photo";
    } else if (empty($mphoto5)) {
        $errorMsg[] = "Please enter movie  photo";
    } else {
        try {

            $insert1 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert1->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole1,
                ':actname' => $actname1,
                ':actpp' => $actphoto1,
               ))) {
            }
            $insert2 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert2->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole2,
                ':actname' => $actname2,
                ':actpp' => $actphoto2,
            ))) {
            }
            $insert3= $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert3->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole3,
                ':actname' => $actname3,
                ':actpp' => $actphoto3,
            ))) {
            }
            $insert4 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert4->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole4,
                ':actname' => $actname4,
                ':actpp' => $actphoto4,
            ))) {
            }
            $insert5 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert5->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole5,
                ':actname' => $actname5,
                ':actpp' => $actphoto5,
            ))) {
            }
            $insert6 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert6->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole6,
                ':actname' => $actname6,
                ':actpp' => $actphoto6,
            ))) {
            }
            $insert7 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert7->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole7,
                ':actname' => $actname7,
                ':actpp' => $actphoto7,
            ))) {
            }
            $insert8 = $db->prepare("INSERT INTO `cast`( `movie_id`, `role`, `act_name`, `act_pp`) VALUES (:movieid,:role,:actname,:actpp)");

            if ($insert8->execute(array(
                ':movieid' => $addedmovie,
                ':role' => $actrole8,
                ':actname' => $actname8,
                ':actpp' => $actphoto8,
            ))) {
            }
            $insert9= $db->prepare("INSERT INTO photos(movie_id,photo) VALUES (:movieid,:photo)");        //sql insert query

            if ($insert9->execute(array(
                ':movieid' => $addedmovie,
                ':photo' => $mphoto1,
            ))) {
            }
            $insert10= $db->prepare("INSERT INTO photos(movie_id,photo) VALUES (:movieid,:photo)");        //sql insert query

            if ($insert10->execute(array(
                ':movieid' => $addedmovie,
                ':photo' => $mphoto2,
            ))) {
            }
            $insert11= $db->prepare("INSERT INTO photos(movie_id,photo) VALUES (:movieid,:photo)");        //sql insert query

            if ($insert11->execute(array(
                ':movieid' => $addedmovie,
                ':photo' => $mphoto3,
            ))) {
            }
            $insert12= $db->prepare("INSERT INTO photos(movie_id,photo) VALUES (:movieid,:photo)");        //sql insert query

            if ($insert12->execute(array(
                ':movieid' => $addedmovie,
                ':photo' => $mphoto4,
            ))) {
            }
            $insert13= $db->prepare("INSERT INTO photos(movie_id,photo) VALUES (:movieid,:photo)");        //sql insert query

            if ($insert13->execute(array(
                ':movieid' => $addedmovie,
                ':photo' => $mphoto5,
            ))) {

                header("refresh:21;adminhome.php");
            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


</head>

<style>

    .card {
        margin: 0 auto;
        float: none;
        margin-bottom: 50px;

    }

    .top_border {
        margin-top: 0px;
        background-color: #6d6875;
        width: available;
        height: 45px;

    }


    .text_color {

        font-weight: bold;
        font-family: "Berlin Sans FB Demi";
    }

    .card_style {
        background-color: #292929;
        color: #E3E6E9;
        margin-top: 50px;
        width: 80rem;
        border-radius: 30px;
        border-width: 5px;
        border-color: #F8961E;
    }


    .card {
        margin: 0 auto;
        float: none;
        margin-bottom: 50px;

    }

    .top_border {
        margin-top: 0px;
        background-color: #6d6875;
        width: available;
        height: 30px;

    }


    .top_border {
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

    .background {
        overflow-x: hidden;
        background-color: #292929;
        background-repeat: no-repeat, repeat;
        background-size: cover;

    }


    .pp {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border-color: #F8961E;
        border-style: solid;
        margin-left: 320px;
        border-width: 2px;
    }


    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

</style>

<body class="background">
<nav class="navbar top_border justify-content-between">
    <p class="border_text_style vertical-center" style="top: 50%;left:5%;">Movie Gamma</p>
    <img class="pp vertical-center" style="top: 50%;left: 95%;" src="adminpp/<?php echo $pp ?>">
</nav>


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
if (isset($registerMsg)) {
    ?>
    <div class="alert alert-secondary">
        <strong><?php echo $registerMsg; ?></strong>
    </div>
    <?php
}
?>


<div class="card card_style" id="add_card" style="display: block">

    <div class="card-header card-header-color  text_color" align="center">
        <H4>ADD NEW MOVIE</H4>
        <p class="mb-0"> You have to fiil inputs to add new movie.</p>
    </div>

    <div class="card-body card-body-color">
        <form method="post">

            <label style="font-size: 16px;margin-bottom: 15px">Cast & Crew</label>

            <div class="row">
                <div class="col" style="border-right: white;  border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname1">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole1">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto1">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style=" border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname2">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole2">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto2">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style="border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname3">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole3">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto3">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style="border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname4">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole4">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto4">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row " style="margin-top: 20px">
                <div class="col" style="border-right: white; border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname5">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole5">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto5">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style="border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname6">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole6">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto6">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style="border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname7">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole7">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto7">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col" style="border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #F8961E;">
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actname8">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Role Name</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_actrole8">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Photo</label>
                        <div class="custom-file">
                            <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                                   id="customFile" name="actphoto8">
                            <label class="custom-file-label" for="customFile"></label>
                        </div>
                    </div>
                </div>

            </div>

            <label style="margin-top: 20px; font-size: 16px">Photos</label>
            <div class="row">
                <div class="form-group col " style="font-weight: bold">
                    <label>Photo 1</label>
                    <div class="custom-file">
                        <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                               id="customFile" name="mphoto1">
                        <label class="custom-file-label" for="customFile"></label>
                    </div>
                </div>
                <div class="form-group col " style="font-weight: bold">
                    <label>Photo 2</label>
                    <div class="custom-file">
                        <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                               id="customFile" name="mphoto2">
                        <label class="custom-file-label" for="customFile"></label>
                    </div>
                </div>
                <div class="form-group col " style="font-weight: bold">
                    <label>Photo 3</label>
                    <div class="custom-file">
                        <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                               id="customFile" name="mphoto3">
                        <label class="custom-file-label" for="customFile"></label>
                    </div>
                </div>
                <div class="form-group col  " style="font-weight: bold">
                    <label>Photo 4</label>
                    <div class="custom-file">
                        <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                               id="customFile" name="mphoto4">
                        <label class="custom-file-label" for="customFile"></label>
                    </div>
                </div>
                <div class="form-group col " style="font-weight: bold">
                    <label>Photo 5</label>
                    <div class="custom-file">
                        <input type="file" style="background-color: #373737;color: white" class="custom-file-input"
                               id="customFile" name="mphoto5">
                        <label class="custom-file-label" for="customFile"></label>
                    </div>
                </div>


            </div>


            <div align="center">
                <button class="btn btn-primary " type="submit" name="btn_submit">SUBMIT</button>
            </div>
        </form>
    </div>

</div>
</div>
</body>
