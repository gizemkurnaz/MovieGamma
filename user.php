<?php

require_once "dbconnect.php";
session_start();

$username = $_SESSION['s_name'];
//profile
$id = $_SESSION['user_login'];
$select_stmt = $db->prepare("SELECT * FROM user WHERE user_id=:uid");
$select_stmt->execute(array(":uid" => $id));
$rowp = $select_stmt->fetch(PDO::FETCH_ASSOC);
$pp = $rowp["pp"];

//user
$select_stmt = $db->prepare("SELECT * FROM user WHERE username=:uusername");
$select_stmt->execute(array(":uusername" => $username));
$rowu = $select_stmt->fetch(PDO::FETCH_ASSOC);
$nameu = $rowu["name"];
$surnameu = $rowu["lastname"];
$ppu = $rowu["pp"];
$uid = $rowu['user_id'];

if (isset($_REQUEST['search'])) {
    $username = strip_tags($_REQUEST["s_name"]);
    $moviename = strip_tags($_REQUEST["s_name"]);
    $_SESSION['s_name'] = $username;
    if (empty($username)) {
        echo '<script>alert("Please enter name!")</script>';
    } else {
        try {
            $select_stmt = $db->prepare("SELECT * FROM user WHERE username =:uusername");
            $select_stmt->execute(array(':uusername' => $username));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            //movie
            $select_movie = $db->prepare("SELECT * FROM movie WHERE movie_name =:umoviename");
            $select_movie->execute(array(':umoviename' => $moviename));
            $rowmovie = $select_movie->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                if ($username == $row["username"]) {
                    $query = "SELECT * FROM user WHERE username LIKE '%$username%'";
                    header("refresh:3; user.php");
                }
            }

            else if ($select_movie->rowCount() > 0) {
                if ($moviename == $rowmovie["movie_name"]) {
                    $querym = "SELECT * FROM movie WHERE movie_name LIKE '%$moviename%'";
                    header("refresh:8; Movie.php");
                }
            }


            else {
                echo '<script>alert("Not found !")</script>';
            }


        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

//following list
$followinglist = $db->prepare("SELECT * FROM following WHERE user_id = :uid");
if ($followinglist->execute(array(
    ":uid" => $uid))){}
$folllowing_number = $followinglist->rowCount() ;
$rows = $followinglist->fetchAll(PDO::FETCH_ASSOC);

//followers list
$followerslist = $db->prepare("SELECT * FROM following WHERE following_id= :uid");
if ($followerslist->execute(array(
    ":uid" => $uid))){}
$folllowers_number = $followerslist->rowCount() ;
$rows2 = $followerslist->fetchAll(PDO::FETCH_ASSOC);



//follow-unfollow butonu
$deneme = $db->prepare("SELECT following_id FROM following WHERE user_id = :id and following_id = :uid");
if ($deneme->execute(array(
    ":id" => $id,
    ":uid" => $uid))) {
}
if ($deneme->rowCount() == 0 ){
    $fbutton = 'FOLLOW';

}else{
    $fbutton = 'UNFOLLOW';
}
//User follow unfollow
if (isset($_REQUEST['following'])) {

    if ($deneme->rowCount() == 0)   {
        $follow = $db->prepare("INSERT INTO following (user_id,following_id) VALUES (:id,:uid)");
        if ($follow->execute(array(
            ':id' => $id,
            ':uid' => $uid,
        ))) {
            header("refresh:4; user.php");

        }

    }else {
        $unfollow = $db->prepare("DELETE FROM following WHERE user_id = :id and following_id = :uid");
        if ($unfollow->execute(array(
            ':id' => $id,
            ':uid' => $uid,
        ))) {

            header("refresh:4; user.php");
        }
    }

}

//favorite films
$favmovies = $db->prepare("SELECT movie_id FROM favoritemovies WHERE user_id= :uid");
if ($favmovies->execute(array(
    ":uid" => $uid))) {
}

$favrow = $favmovies->fetchAll(PDO::FETCH_ASSOC);

//watchlistu
$watchlistu = $db->prepare("SELECT movie_id FROM watchlist WHERE user_id= :uid");
if ($watchlistu->execute(array(
    ":uid" => $uid))) {
}

$watchlistrow = $watchlistu->fetchAll(PDO::FETCH_ASSOC);

//watchedu
$watchedu = $db->prepare("SELECT movie_id FROM watchedmovies WHERE user_id= :uid");
if ($watchedu->execute(array(
    ":uid" => $uid))) {
}

$watchedrow = $watchedu->fetchAll(PDO::FETCH_ASSOC);
$watcedcount = $watchedu->rowCount();



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<style>
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

    .ppbig {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        margin-top: 2.5px;
        border-color: #F8961E;
        border-style: solid;
        border-width: 3px;
        margin-left: 200px;

    }

    .nameheader {
        color: #F9C74F;
        font-size: 20px;
        font-weight: bold;
        font-family: "Roboto Light";
    }

    .editprofile {
        background-color: #577590;
        color: #2D3A66;
        width: 130px;
        font-family: "Roboto Light";
        font-weight: bold;
        font-size: 14px;
    }

    .stacols {
        color: #577590;
        font-weight: bold;
        font-family: "Roboto Light";
        text-align: center;
    }

    .titles {
        color: #F9C74F;
        font-family: "Roboto Light";
        font-size: 15px;
        margin-left: 120px;
        margin-top: 90px;
    }

    .favoritefilms {
        width: 210px;
        height: 280px;
        border-width: 2px;
        border-color: #84837F;
        border-radius: 5px;
        border-style: solid;
    }

    .watchedfilms {
        width: 120px;
        height: 160px;
        border-width: 2px;
        border-color: #84837F;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-left-style: solid;
        border-right-style: solid;
        border-top-style: solid;

    }

    .wathlistfilms {
        width: 114px;
        height: 165px;
        border-width: 2px;
        border-color: #84837F;
        border-style: solid;
        border-radius: 5px;


    }

    .score {
        border-width: 2px;
        border-color: #84837F;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        background-color: #E3E6E9;
        border-left-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        width: 120px;

    }

    .wscore {
        color: #303F47;
        font-size: 13px;
        text-align: end;
    }

    .wname {
        color: #303F47;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        font-family: "Roboto Light";
        width: 114px;
    }

    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .ppfollowing {

        width: 40px;
        height: 40px;
        border-radius: 50%;
        border-color: #F8961E;
        border-style: solid;
        border-width: 2px;
        margin-left: 50px;

    }

    .namefollowing {
        font-size: 15px;
        font-weight: 500;
        margin-left: 150px;
        color: white;

    }

    .followingbutton {
        background-color: #577590;
        color: white;
        width: 130px;
        font-weight: bold;
        font-size: 14px;
        margin-left: 355px;
    }


</style>


<body class="background">
<nav class="navbar top_border justify-content-between">
    <p class="border_text_style vertical-center" style="top: 50%;left:5%;">Movie Gamma</p>
    <form class="form-inline row vertical-center" method="post" style="top: 50%;
        left: 50%;">
        <input class="form-control mr-sm-2 col" type="search"name="s_name" placeholder="Search" aria-label="Search"
               style="height: 30px;width: 180px; background-color: #373737">
        <button class="btn btn-light my-2 my-sm-0 col" type="submit" name="search" style="background-color: #474747;height: 30px;width: 9px;"><i
                    class="fa fa-search vertical-center"></i></button>
    </form>
    <a href="profilepage.php">
        <img class="pp vertical-center" style="top: 50%;left: 95%;" src="userspp/<?php echo $pp ?>">
    </a>


</nav>


<div class="row" style="margin-top: 70px;  margin-left: 0px;">
    <div class="col">
        <img class="ppbig" src="userspp/<?php echo $ppu ?>">
    </div>
    <div class="col-sm-" style="width: 200px">
        <div class="row" style="text-align: center">
            <p class="nameheader"><?php echo $nameu, "  ", $surnameu ?></p>

        </div>
        <div class="row" style="text-align: center">
            <form>
                <button class=" btn btn-sm  editprofile" type="submit" name="following"><?php echo $fbutton ?></button>
            </form>
        </div>
    </div>


    <div class="col"></div>
    <div class="col"></div>
    <div class="col"></div>


    <div class="col stacols">
        <div class="row"></div>
        <div style="font-size: 26px"><?php echo $watcedcount ?></div>
        <div style="font-size: 14px">Movies</div>
    </div>
    <div class="col stacols">
        <div style="font-size: 26px"><?php echo $folllowing_number ?></div>
        <div style="font-size: 14px" data-toggle="modal" data-target="#exampleModalCenter">Following</div>
    </div>
    <div class="col stacols">
        <div style="font-size: 26px"><?php echo $folllowers_number ?></div>
        <div style="font-size: 14px" data-toggle="modal" data-target="#exampleModalCenter2">Followers</div>
    </div>
    <div class="col"></div>
    <div class="col"></div>
    <div class="col"></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: #292929">
                <div class="modal-header" style=" justify-content: center">
                    <h5 class="modal-title" style="color: white" id="exampleModalCenterTitle">Following</h5>
                </div>
                <div class="modal-body" style="overflow-y: scroll; margin-bottom: 20px">


                    <form action="" method="post" enctype="multipart/form-data"/>


                    <div style="height:350px">

                        <?php
                        foreach ($rows as $row) {

                            $fuserid = $row['following_id'];

                            $followinglistpp = $db->prepare("SELECT pp FROM user WHERE user_id = :fuserid");
                            if ($followinglistpp->execute(array(
                                ":fuserid" => $fuserid))) {
                            }
                            $pprow = $followinglistpp->fetch(PDO::FETCH_ASSOC);


                            $followinglistname = $db->prepare("SELECT name FROM user WHERE user_id = :fuserid");
                            if ($followinglistname->execute(array(
                                ":fuserid" => $fuserid))) {
                            }
                            $namerow = $followinglistname->fetch(PDO::FETCH_ASSOC);

                            $followinglistlastname = $db->prepare("SELECT lastname FROM user WHERE user_id = :fuserid");
                            if ($followinglistlastname->execute(array(
                                ":fuserid" => $fuserid))) {
                            }
                            $lastnamerow = $followinglistlastname->fetch(PDO::FETCH_ASSOC);
                            echo " <div style= 'height: 50px'></div>";

                            ?>

                            <img class="ppfollowing vertical-center" src="userspp/<?php echo $pprow['pp'] ?>">
                            <p class="vertical-center namefollowing"><?php echo $namerow['name'], " ", $lastnamerow['lastname']; ?></p>

                            <?php
                        }
                        ?>
                    </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal2 -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: #292929">
                <div class="modal-header" style=" justify-content: center">
                    <h5 class="modal-title" style="color: white" id="exampleModalCenterTitle">Followers</h5>
                </div>
                <div class="modal-body" style="overflow-y: scroll; margin-bottom: 20px">


                    <form action="" method="post" enctype="multipart/form-data"/>


                    <div style="height:350px">

                        <?php
                        foreach ($rows2 as $row) {

                            $fuserid2 = $row['user_id'];


                            $followerslistpp = $db->prepare("SELECT pp FROM user WHERE user_id = :fuserid");
                            if ($followerslistpp->execute(array(
                                ":fuserid" => $fuserid2))) {
                            }
                            $pprow2 = $followerslistpp->fetch(PDO::FETCH_ASSOC);


                            $followerslistname = $db->prepare("SELECT name FROM user WHERE user_id = :fuserid");
                            if ($followerslistname->execute(array(
                                ":fuserid" => $fuserid2))) {
                            }
                            $namerow2 = $followerslistname->fetch(PDO::FETCH_ASSOC);

                            $followerslistlastname = $db->prepare("SELECT lastname FROM user WHERE user_id = :fuserid");
                            if ($followerslistlastname->execute(array(
                                ":fuserid" => $fuserid2))) {
                            }
                            $lastnamerow2 = $followerslistlastname->fetch(PDO::FETCH_ASSOC);
                            echo " <div style= 'height: 50px'></div>";

                            ?>

                            <img class="ppfollowing vertical-center" src="userspp/<?php echo $pprow2['pp'] ?>">
                            <p class="vertical-center namefollowing"><?php echo $namerow2['name'], " ", $lastnamerow2['lastname']; ?></p>
                            <?php
                        }

                        ?>
                    </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <h1 class="titles">FAVORITE FILMS</h1>

    <div class="row" style="margin-top: 25px">
        <div class="col"></div>
        <?php
        foreach ($favrow as $row) {
            $favmovieid = $row['movie_id'];

            $favposter = $db->prepare("SELECT movie_poster FROM movie WHERE movie_id = :favmovieid");
            if ($favposter->execute(array(
                ":favmovieid" => $favmovieid))) {
            }
            $favposterow = $favposter->fetch(PDO::FETCH_ASSOC);


            ?>
            <div class="col">
                <img src="poster/<?php echo $favposterow['movie_poster'] ?>" class="favoritefilms">
            </div>
            <?php

        }

        ?>
        <div class="col"></div>
    </div>
    <h1 class="titles">WATCHED FILMS</h1>

    <div class="row" style=" margin-top: 25px; margin-left: 20px">
        <div class="col"></div>
        <?php
        foreach ($watchedrow as $row) {
            $watchedmovieid = $row['movie_id'];

            $watchedposter = $db->prepare("SELECT movie_poster,movie_name FROM movie WHERE movie_id = :watchedmovieid");
            if ($watchedposter->execute(array(
                ":watchedmovieid" => $watchedmovieid))) {
            }
            $watchedposterow = $watchedposter->fetch(PDO::FETCH_ASSOC);

            ?>
            <div class="col">
                <img src="poster/<?php echo $watchedposterow['movie_poster']?>"class="watchedfilms">
                <div class="score">
                    <div class=" wname"><?php echo $watchedposterow['movie_name']?></div>
                </div>
            </div>
            <?php

        }

        ?>
        <div class="col"></div>

    </div>
</div>
</div>

<h1 class="titles">WATCHLIST</h1>
<div class="row" style=" margin-top: 25px; margin-left: 20px">
    <div class="col"></div>

    <?php
    foreach ($watchlistrow as $row) {
        $watchlistmovieid = $row['movie_id'];

        $watchlistposter = $db->prepare("SELECT movie_poster FROM movie WHERE movie_id = :watchlistmovieid");
        if ($watchlistposter->execute(array(
            ":watchlistmovieid" => $watchlistmovieid))) {
        }
        $watchlistposterow = $watchlistposter->fetch(PDO::FETCH_ASSOC);

        ?>
        <div class="col">
            <img src="poster/<?php echo $watchlistposterow['movie_poster']?>" class="wathlistfilms">
        </div>
        <?php

    }

    ?>
    <div class="col"></div>

</div>
        <div class="col"></div>
    </div>


    <div style="height: 20px"></div>


</div>


</body>


