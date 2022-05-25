<?php
session_start();

require_once "dbconnect.php";

$id = $_SESSION['admin_login'];


$select_stmt = $db->prepare("SELECT * FROM admin WHERE id_a=:uid");
$select_stmt->execute(array(":uid" => $id));

$row1 = $select_stmt->fetch(PDO::FETCH_ASSOC);

$pp = $row1["pp_a"];


$edit_movie = mysqli_query($connect, "select * from movie where movie_id='$_GET[id]' ");

$fetch_edit = mysqli_fetch_array($edit_movie);
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
if (isset($updateMsg)) {
    ?>
    <div class="alert alert-secondary">
        <strong><?php echo $updateMsg; ?></strong>
    </div>
    <?php
}
?>


<div class="card card_style" id="add_card" style="display: block">

    <div class="card-header card-header-color  text_color" align="center">
        <H4>EDIT MOVIE</H4>
        <p class="mb-0"> You can change inputs to update product</p>
    </div>

    <div class="card-body card-body-color">
        <form method="post">
            <div class="row">

                <div class="col-sm-6">

                    <div class="form-group" style="font-weight: bold;">
                        <label for="name">Name</label>
                        <input class="form-control" style="background-color: #373737 ;color: white" type="name"
                               id="name"
                               name="txt_name"
                               value="<?php echo $fetch_edit['movie_name'] ?>">
                    </div>

                    <div class="form-group " style="font-weight: bold">
                        <label>Category</label>
                        <input class="form-control" style="background-color: #373737;color: white" name="txt_cat"
                               value="<?php echo $fetch_edit['movie_category'] ?>">
                    </div>


                    <div class="form-group " style="font-weight: bold">
                        <label for="price">Director</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_dir" value="<?php echo $fetch_edit['Director'] ?>">
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea style="height: 180px ; background-color: #373737;color: white" class="form-control"
                                  type="description" id="description"
                                  name="txt_des"><?php echo $fetch_edit['movie_description'] ?></textarea>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group " style="font-weight: bold">
                        <label for="price">Year</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_year"
                               value="<?php echo $fetch_edit['movie_year'] ?>">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">Duration</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_dur"
                               value="<?php echo $fetch_edit['movie_duration'] ?>">
                    </div>
                    <div class="form-group" style="font-weight: bold">
                        <label for="price">IMDB</label>
                        <input class="form-control" style="background-color: #373737;color: white" id="price"
                               name="txt_imdb" value="<?php echo $fetch_edit['IMDB'] ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group "  style="font-weight: bold">
                        <div>Poster</div>


                        <input id="Upload" type="file" multiple="multiple" name="image" style="visibility: hidden">

                        <label class="btn">
                            <i class="fa fa-image"></i> <input type="file" style="display: none;" name="poster">
                            <img class="fa fa-image"src="poster/<?php echo $fetch_edit['movie_poster']; ?>" width="150" height="200"/>
                        </label>


                    </div>

                </div>
            </div>


            <div align="center">
                <button class="btn btn-primary " name="edit_movie"type="submit">SAVE</button>
            </div>

        </form>
    </div>

</div>
</div>

<?php

if (isset($_REQUEST['edit_movie'])) {
    $name = strip_tags($_REQUEST['txt_name']);
    $description = strip_tags($_REQUEST['txt_des']);
    $poster = strip_tags($_REQUEST['poster']);
    $cat = strip_tags($_REQUEST['txt_cat']);
    $director = strip_tags($_REQUEST['txt_dir']);
    $year = strip_tags($_REQUEST['txt_year']);
    $duration = strip_tags($_REQUEST['txt_dur']);
    $imdb = strip_tags($_REQUEST['txt_imdb']);

    if(empty($poster)){
        $poster = $fetch_edit['movie_poster'];
        echo 'boş';
    }

    if (empty($name)) {
        $errorMsg[] = "Please enter movie name";
    }
    if (empty($cat)) {
        $errorMsg[] = "Please enter category name";
    } else if (empty($description)) {
        $errorMsg[] = "Please enter description";
    } else if (empty($director)) {
        $errorMsg[] = "Please enter director";
    } else if (empty($poster)) {
        $errorMsg[] = "Please select image";
    } else if (empty($year)) {
        $errorMsg[] = "Please enter year";
    } else if (empty($duration)) {
        $errorMsg[] = "Please enter duration";
    } else if (empty($imdb)) {
        $errorMsg[] = "Please enter imdb";
    } else {
        try {
            if (!isset($errorMsg)) {

                $change = $db->prepare("UPDATE movie set movie_name =:uname,movie_duration=:udur,movie_year=:uyear,movie_description=:udescription,movie_category=:ucat,Director=:udirector,movie_poster=:uposter,IMDB=:uimdb where movie_id = :id");        //sql insert query

                if ($change->execute(array(
                    ':uname' => $name,
                    ':udur' => $duration,
                    ':uyear' => $year,
                    ':udescription' => $description,
                    ':ucat' => $cat,
                    ':udirector' => $director,
                    ':uposter' => $poster,
                    ':uimdb' => $imdb,
                    ':id' => $id))) {

                }

            }

            if($change){
                echo "<script>alert('Product was updated successfully!')</script>";
                echo "<script>window.open(window.location.href,'_self')</script>";
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>
</body>