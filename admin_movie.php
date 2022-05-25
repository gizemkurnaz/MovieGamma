<?php

session_start();


require_once 'dbconnect.php';


$id = $_SESSION['admin_login'];


$select_stmt = $db->prepare("SELECT * FROM admin WHERE id_a=:uid");
$select_stmt->execute(array(":uid" => $id));

$row1 = $select_stmt->fetch(PDO::FETCH_ASSOC);

$pp = $row1["pp_a"];


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"></script>


</head>

<style>

    .card_style {
        background-color: #292929;
        color: #E3E6E9;
        margin-top: 50px;
        width: 100rem;
        height: 50rem;
        border-radius: 30px;
        border-width: 5px;
        border-color: #F8961E;
    }


    .card {
        margin: 0 auto;
        float: none;
        margin-bottom: 20px;

    }

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


    .ppuser {
        width: 50px;
        height: 60px;
        border-color: #F8961E;
        border-style: solid;
        border-width: 1px;
        margin-top: 5px;
        margin-bottom: 5px;

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
    <a href="adminhome.php">
        <p class="border_text_style vertical-center" style="top: 50%;left:5%;">Movie Gamma</p>
    </a>
    <form class="form-inline row vertical-center" method="post" style="top: 50%;
        left: 50%;">
        <input class="form-control mr-sm-2 col" type="search" name="s_name" placeholder="Search" aria-label="Search"
               style="height: 30px;width: 180px; background-color: #373737; color: white">
        <button class="btn btn-light my-2 my-sm-0 col" type="submit" name="search"
                style="background-color: #474747;height: 30px;width: 9px;"><i
                    class="fa fa-search vertical-center"></i></button>
    </form>
    <a href="adminprofile.php">
        <img class="pp vertical-center" style="top: 50%;left: 95%;" src="adminpp/<?php echo $pp ?>">
    </a>
</nav>


<div class="container" style="margin-top: 50px"></div>

<div class="row">
    <div class="col"></div>
    <div class="col">


        <div class="view_product_box card card_style" align="center" ">

            <div class="card-header ">
                <h2>Movies</h2>
            </div>


            <div class=" card-body card-body-color border_bottom" ></div>

            <form action="" method="post" style="overflow-y:scroll"  enctype="multipart/form-data"/>

            <table width="80%" align="center" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Poster</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Director</th>
                    <th>Year</th>
                    <th>Duration</th>
                    <th>IMDB</th>


                    <th></th>
                    <th></th>
                </tr>
                </thead>

                <?php
                if (isset($_REQUEST['search'])) {
                    $moviename = strip_tags($_REQUEST["s_name"]);
                    if (empty($moviename)) {
                        echo '<script>alert("Please enter movie name!")</script>';
                    } else {
                        try {
                            $select_stmt = $db->prepare("SELECT * FROM movie WHERE movie_name =:uname");
                            $select_stmt->execute(array(':uname' => $moviename));
                            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

                            if ($select_stmt->rowCount() > 0) {
                                if ($moviename == $row["movie_name"]) {
                                    $all_users = mysqli_query($connect, "SELECT * FROM movie WHERE movie_name LIKE '%$moviename%'");
                                }


                            } else {
                                echo '<script>alert("Movie no found !")</script>';
                            }
                        } catch (PDOException $e) {
                            $e->getMessage();
                        }
                    }
                }

                $all_users = mysqli_query($connect, "select * from movie order by movie_id ASC ");

                while ($row = mysqli_fetch_array($all_users)) {
                    ?>

                    <tbody>
                    <tr>
                        <td><?php echo $row['movie_id']; ?></td>
                        <td><img src="poster/<?php echo $row['movie_poster']; ?>" class="ppuser"/></td>
                        <td><?php echo $row['movie_name']; ?></td>
                        <td><?php echo $row['movie_category']; ?></td>
                        <td><?php echo $row['Director']; ?></td>
                        <td><?php echo $row['movie_year']; ?></td>
                        <td><?php echo $row['movie_duration']; ?></td>
                        <td><?php echo $row['IMDB']; ?></td>
                        <td><a href="admin_movie.php?action=view_pro&delete_movie=<?php echo $row['movie_id']; ?>">Delete</a>
                        </td>
                        <td><a href="editmovie.php?action=edit_pro&id=<?php echo $row['movie_id']; ?>">Edit</a></td>

                    </tr>
                    </tbody>

                <?php } ?>
            </table>


            </form>
        <div class="card-footer " style="margin-top: 15px"></div>

        </div>
        <button style="margin-left: 90rem; height: 35px; width: 100px ;background-color: #F8961E;font-weight: bold"
                class="btn" onclick="direct()">
            Add Movie
        </button>
    </div>

    <div class="col">


    </div>

    <?php

    if (isset($_GET['delete_movie'])) {
        $delete_movie = mysqli_query($connect, "delete from movie where movie_id='$_GET[delete_movie]' ");

        if ($delete_movie) {
            echo "<script>alert('Movie has been deleted successfully!')</script>";

            echo "<script>window.open('admin_user.php?action=view_pro','_self')</script>";

        }
    }
    ?>


</div>
</body>

<script>
    function direct() {
        window.location.href = "addmovie.php";
    }
</script>
