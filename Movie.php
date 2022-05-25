<?php
require_once "dbconnect.php";
session_start();
//user-profile
$id = $_SESSION['user_login'];
$select_u = $db->prepare("SELECT * FROM user WHERE user_id=:uid");
$select_u->execute(array(":uid" => $id));
$rowp = $select_u->fetch(PDO::FETCH_ASSOC);
$pp = $rowp["pp"];
$namep = $rowp["name"];
$lastnamep = $rowp["lastname"];

//movie
$moviename = $_SESSION['s_name'];
$select_m = $db->prepare("SELECT * FROM movie WHERE movie_name=:umoviename");
$select_m->execute(array(":umoviename" => $moviename));
$rowm = $select_m->fetch(PDO::FETCH_ASSOC);

$namem = $rowm["movie_name"];
$duration = $rowm["movie_duration"];
$year = $rowm['movie_year'];
$description = $rowm['movie_description'];
$category = $rowm['movie_category'];
$director = $rowm['Director'];
$imdb = $rowm['IMDB'];
$poster = $rowm['movie_poster'];
$movieid = $rowm['movie_id'];


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
            } else if ($select_movie->rowCount() > 0) {
                if ($moviename == $rowmovie["movie_name"]) {
                    $querym = "SELECT * FROM movie WHERE movie_name LIKE '%$moviename%'";
                    header("refresh:8; Movie.php");
                }
            } else {
                echo '<script>alert("Not found !")</script>';
            }


        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

//watchlist
$watclist = $db->prepare("SELECT movie_id FROM watchlist WHERE user_id = :id and movie_id = :mid");

if ($watclist->execute(array(
    ":id" => $id,
    ":mid" => $movieid))) {
}
if ($watclist->rowCount() == 0) {
    $wbutton = 'Watchlist';
} else {
    $wbutton = 'Remove';
}

if (isset($_REQUEST['watchlist'])) {

    $watclist = $db->prepare("SELECT movie_id FROM watchlist WHERE user_id = :id and movie_id = :mid");

    if ($watclist->execute(array(
        ":id" => $id,
        ":mid" => $movieid))) {
    }
    if ($watclist->rowCount() == 0) {

        try {

            $watch = $db->prepare("INSERT INTO watchlist (movie_id,user_id) VALUES (:mid,:id)");
            if ($watch->execute(array(
                ':mid' => $movieid,
                ':id' => $id,

            ))) {
                header("refresh:16; Movie.php");

            }


        } catch (PDOException $e) {
            $e->getMessage();
        }
    } else {
        $remove = $db->prepare("DELETE FROM watchlist WHERE user_id = :id and movie_id = :mid");
        if ($remove->execute(array(
            ':id' => $id,
            ':mid' => $movieid,
        ))) {

            header("refresh:17; Movie.php");
        }


    }


}

//comment

if (isset($_REQUEST['comment'])) {
    $review = strip_tags($_REQUEST["review"]);
    if (empty($review)) {
        echo '<script>alert("Please enter your comment!")</script>';
    } else {
        try {

            $watch = $db->prepare("INSERT INTO review (user_id,movie_id,review) VALUES (:id,:mid,:review)");
            if ($watch->execute(array(
                ':id' => $id,
                ':mid' => $movieid,
                ':review' => $review
            ))) {
                header("refresh:15; Movie.php");

            }


        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}


//watch butonu


$deneme = $db->prepare("SELECT movie_id FROM watchedmovies WHERE user_id = :id and movie_id = :mid");

if ($deneme->execute(array(
    ":id" => $id,
    ":mid" => $movieid))) {
}
if ($deneme->rowCount() == 0) {
    $fbutton = 'Watch';

} else {
    $fbutton = 'Watched';
}

if (isset($_REQUEST["watched"])) {

    if ($deneme->rowCount() == 0) {
        $watch = $db->prepare("INSERT INTO watchedmovies (user_id,movie_id) VALUES (:id,:mid)");
        if ($watch->execute(array(
            ':id' => $id,
            ':mid' => $movieid,
        ))) {
            header("refresh:9; Movie.php");

        }

    } else {
        $watched = $db->prepare("DELETE FROM watchedmovies WHERE user_id = :id and movie_id = :mid");
        if ($watched->execute(array(
            ':id' => $id,
            ':mid' => $movieid,
        ))) {

            header("refresh:10; Movie.php");
        }
    }

}


//rate
$r = $db->prepare("SELECT rate FROM watchedmovies WHERE user_id = :id and movie_id = :mid");
if ($r->execute(array(
    ":id" => $id,
    ":mid" => $movieid))) {
}
$rowrate = $r->fetch(PDO::FETCH_ASSOC);


if (isset($rowrate)) {
    if (empty($rowrate)) {
        $rating = '?';
    } else {
        if ($rowrate['rate'] == '') {
            $rating = '?';
        } else
            $rating = $rowrate['rate'];

    }

} else {
    $rating = '?';
}


if (isset($_REQUEST["savechanges"])) {
    if ($deneme->rowCount() == 0) {
        echo '<script>alert("You can not give rate because firstly you should watch this movie!")</script>';

    } else {

        $myrate = strip_tags($_REQUEST['txt_myrate']);

        if (empty($myrate)) {
            $errorMsg[] = "Please enter rate";
        } else if ($myrate < 1 and $myrate > 10) {
            $errorMsg[] = "Please enter rate between 1-10";
        } else {
            if ($rowrate['rate'] == 0) {
                $watch = $db->prepare("UPDATE watchedmovies set  rate = :rate WHERE  user_id = :id and movie_id = :mid ");
                if ($watch->execute(array(
                    ':rate' => $myrate,
                    ':id' => $id,
                    ':mid' => $movieid,
                ))) {
                    $rating = $rowrate['rate'];
                    header("refresh:12; Movie.php");

                }

            } else {
                $watch = $db->prepare("UPDATE watchedmovies set  rate = :rate  WHERE user_id = :id and movie_id = :mid");


                if ($watch->execute(array(
                    ':rate' => $myrate,
                    ':id' => $id,
                    ':mid' => $movieid,

                ))) {
                    $rating = $rowrate['rate'];
                    header("refresh:11; Movie.php");
                }
            }

        }


    }


}






//favorite butonu


$favorite = $db->prepare("SELECT movie_id FROM favoritemovies WHERE user_id = :id and movie_id = :mid");

if ($favorite->execute(array(
    ":id" => $id,
    ":mid" => $movieid))) {
}
if ($favorite->rowCount() == 0) {
    $favbutton = 'Favorite';

} else {
    $favbutton = 'Favorited';
}

if (isset($_REQUEST["favorite"])) {

    if ($favorite->rowCount() == 0) {

        $f2 = $db->prepare("SELECT movie_id FROM favoritemovies WHERE user_id = :id ");

        if ($f2->execute(array(
            ":id" => $id,
            ))) {
        }
        if ($f2->rowCount() < 4) {

            $f3 = $db->prepare("INSERT INTO favoritemovies (user_id,movie_id) VALUES (:id,:mid)");
            if ($f3->execute(array(
                ':id' => $id,
                ':mid' => $movieid,
            ))) {
                header("refresh:30; Movie.php");

            }
        }else{
            echo '<script>alert("You cannot add more than 4 favorite movies.")</script>';
        }

    } else {
        $f4 = $db->prepare("DELETE FROM favoritemovies WHERE user_id = :id and movie_id = :mid");
        if ($f4->execute(array(
            ':id' => $id,
            ':mid' => $movieid,
        ))) {

            header("refresh:31; Movie.php");
        }
    }

}


//castandcrew

$select_cast = $db->prepare("SELECT * FROM cast WHERE movie_id=:umovieid");
$select_cast->execute(array(":umovieid" => $movieid));
$rowcast = $select_cast->fetchAll(PDO::FETCH_ASSOC);

//photos

$select_photos = $db->prepare("SELECT * FROM photos WHERE movie_id=:umovieid");
$select_photos->execute(array(":umovieid" => $movieid));
$rowphotos = $select_photos->fetchAll(PDO::FETCH_ASSOC);

//reviews

$select_reviews = $db->prepare("SELECT * FROM review WHERE movie_id=:umovieid");
$select_reviews->execute(array(":umovieid" => $movieid));
$rowreviews = $select_reviews->fetchAll(PDO::FETCH_ASSOC);

//morelike

$selectist = $db->prepare("SELECT movie_id FROM movie ORDER BY Rand() LIMIT 4");
if ($selectist->execute(array())) {
}

$rowmore = $selectist->fetchAll(PDO::FETCH_ASSOC);
$moreid1 = $rowmore[0]["movie_id"];
$moreid2 = $rowmore[1]["movie_id"];
$moreid3 = $rowmore[2]["movie_id"];
$moreid4 = $rowmore[3]["movie_id"];

$select_more = $db->prepare("SELECT * FROM movie WHERE movie_id=:umovieid");
$select_more->execute(array(":umovieid" => $moreid1));
$rowmore1 = $select_more->fetch(PDO::FETCH_ASSOC);
$morename1 = $rowmore1['movie_name'];
$moreyear1 = $rowmore1['movie_year'];
$moreimdb1 = $rowmore1['IMDB'];
$moreposter1 = $rowmore1['movie_poster'];

$select_more = $db->prepare("SELECT * FROM movie WHERE movie_id=:umovieid");
$select_more->execute(array(":umovieid" => $moreid2));
$rowmore2 = $select_more->fetch(PDO::FETCH_ASSOC);
$morename2 = $rowmore2['movie_name'];
$moreyear2 = $rowmore2['movie_year'];
$moreimdb2 = $rowmore2['IMDB'];
$moreposter2 = $rowmore2['movie_poster'];

$select_more = $db->prepare("SELECT * FROM movie WHERE movie_id=:umovieid");
$select_more->execute(array(":umovieid" => $moreid3));
$rowmore3 = $select_more->fetch(PDO::FETCH_ASSOC);
$morename3 = $rowmore3['movie_name'];
$moreyear3 = $rowmore3['movie_year'];
$moreimdb3 = $rowmore3['IMDB'];
$moreposter3= $rowmore3['movie_poster'];

$select_more = $db->prepare("SELECT * FROM movie WHERE movie_id=:umovieid");
$select_more->execute(array(":umovieid" => $moreid4));
$rowmore4 = $select_more->fetch(PDO::FETCH_ASSOC);
$morename4 = $rowmore4['movie_name'];
$moreyear4 = $rowmore4['movie_year'];
$moreimdb4 = $rowmore4['IMDB'];
$moreposter4 = $rowmore4['movie_poster'];

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>

    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"></script>

    <script data-require="jquery@*" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link data-require="fontawesome@*" data-semver="4.5.0" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js"></script>

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

    .ppmovie {
        width: 250px;
        height: 330px;
        margin-left: 100px;


    }

    .favoritefilms {
        width: 260px;
        height: 280px;
        border-width: 2px;
        border-color: #84837F;
        border-radius: 5px;
        border-style: solid;
    }

    .watchedfilms {
        width: 230px;
        height: 310px;
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
        height: 160px;
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
        background-color: #0F0B0B;
        border-left-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        width: 230px;
        height: 80px;
    }

    .wscore {
        color: #FFFFFF;
        font-size: 13px;
        text-align: end;
        margin-right: 5px;
    }

    .wname {
        color: #FFFFFF;
        font-size: 15px;
        text-align: center;

    }

    .headerText {
        font-weight: bold;
        color: #F9C74F;
        font-size: 24px;
    }

    .bioText {
        color: #FFF8D6;
        font-size: 15px;
    }

    .movieTable {
        background-color: #577590;
        width: 350px;
        height: 300px;
        border-radius: 10px;
        margin-left: 70px;
        margin-right: 50px;
        text-align: center;

    }

    .tableText1 {
        color: #ffffff;
        font-size: 13px;
        font-weight: bold;
        text-align: center;

    }

    .tableText2 {
        color: #ffffff;
        font-size: 12px;
        text-align: center;
    }

    .castpp {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border-color: #84837F;
        border-style: solid;
        border-width: 2px;
    }

    .photos {
        width: 220px;
        height: 220px;
        border-color: #84837F;
        border-style: solid;
        border-width: 2px;
        border-radius: 10px;
    }

    .videos {
        width: 190px;
        height: 120px;
        border-color: #84837F;
        border-style: solid;
        border-width: 2px;
        border-radius: 10px;
    }

    .reviewpp {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-top: 2.5px;
        border-color: #C4C4C4;
        border-style: solid;
        border-width: 1px;
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
        width: 230px;
        height: 300px;
        border-width: 2px;
        border-color: #84837F;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;

    }

    .watchedfilms {
        width: 114px;
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
        height: 160px;
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

    }

    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .containera {
        width: 240em;
        overflow-x: scroll;
        white-space: nowrap;
    }


</style>

<body class="background">
<nav class="navbar top_border justify-content-between">
    <p class="border_text_style vertical-center" style="top: 50%;left:5%;">Movie Gamma</p>
    <form class="form-inline row vertical-center" method="post" style="top: 50%;
        left: 50%;">
        <input class="form-control mr-sm-2 col" type="search" name="s_name" placeholder="Search" aria-label="Search"
               style="height: 30px;width: 180px; background-color: #373737; color: white">
        <button class="btn btn-light my-2 my-sm-0 col" type="submit" name="search"
                style="background-color: #474747;height: 30px;width: 9px;"><i
                    class="fa fa-search vertical-center"></i></button>
    </form>
    <a href="profilepage.php">
        <img class="pp vertical-center" style="top: 50%;left: 95%;" src="userspp/<?php echo $pp ?>">
    </a>


</nav>

<div class="row" style="margin-top: 75px; ">
    <div class="col">
        <img class="ppmovie" src="poster/<?php echo $poster ?>">
    </div>
    <div class="col">
        <div class="headerText"> <?php echo $namem ?></div>
        <div class="row">
            <div class="col bioText">Directed by <?php echo $director ?></div>
            <div class=" col bioText"><?php echo $year ?></div>
        </div>
        <div class="bioText" style="margin-top: 8px"><?php echo $description ?></div>
    </div>


    <div class=" col">
        <div class="movieTable">
            <div class="row ">
                <div class="col" style="margin-top: 10px">
                    <i class="bi bi-tv " style="color: #90CE5F"></i>

                    <form>
                        <button class=" col btn tableText2" name="watched"><?php echo $fbutton ?> </button>
                    </form>
                </div>


                <div class="col " style="margin-top: 10px">
                    <div style="color: #F8961E;font-weight: bold"><?php echo $rating ?></div>
                    <div class=" tableText2" data-toggle="modal"
                         data-target="#ratemovie" style="margin-top: 6px">Your Rate
                    </div>
                </div>

                <div class="col" style="margin-top: 10px">
                    <i class="bi bi-stopwatch "></i>
                    <form>
                    <button name='watchlist' class="btn tableText2"><?php echo $wbutton ?></button>
                    </form>
                </div>

                <div class="col" style="margin-top: 10px">
                    <img src="icons/hearticon.png" style="height: 15px;width: 15px">

                    <form>
                        <button class="btn tableText2" name="favorite"><?php echo $favbutton ?> </button>
                    </form>
                </div>

            </div>


            <div class="row">

            </div>

            <div class="row" style="margin-top: 5px">
                <hr style="border-width: 1px">
            </div>

            <div class="row">
                <div class="col" style="margin-left: 30px">

                    <div class="row tableText1">IMDB Rating</div>
                    <div class="row tableText2"><?php echo $imdb ?>/10</div>
                </div>
                <div class="col" style="margin-left: 30px">
                    <i class="bi bi-bar-chart-fill" style="font-size: 2rem"></i>
                </div>
            </div>

            <div class="row" style="margin-top: 5px">
                <hr style="border-width: 1px">
            </div>


            <div class="row">
                <div class="col" style="margin-left: 30px">
                    <div class="row tableText1">Duration</div>
                    <div class="row tableText2"><?php echo $duration ?> minute</div>
                </div>
                <div class="col">
                    <i class="bi bi-clock-history" style="font-size: 2rem"></i>
                </div>
            </div>
            <div class="row" style="margin-top: 5px">
                <hr style="border-width: 1px">
            </div>

            <div class="row">
                <div class="col" style="margin-left: 30px">
                    <div class="row tableText1">Category</div>
                    <div class="row tableText2"> <?php echo $category ?></div>
                </div>
                <div class="col">
                    <i class="bi bi-film" style="font-size: 2rem"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ratemovie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="justify-content: center">
                <h5 class="modal-title " id="exampleModalCenterTitle">Your Rating</h5>

            </div>
            <form method="post">
                <div class="modal-body row">
                    <label class="col"> Please select your movie rate</label>
                    <select class="form-select col" aria-label="Default select example" name='txt_myrate'>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>

                   <!-- <form>
                        <input type="number" name="rating" id="rating-input"  />
                    </form>


                    <div class="rating" role="optgroup" >
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-1" data-rating="1" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-2" data-rating="2" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-3" data-rating="3" tabindex="0" role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-4" data-rating="4" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-5" data-rating="5" tabindex="0" role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-6" data-rating="6" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-7" data-rating="7" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-8" data-rating="8" tabindex="0" role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-9" data-rating="9" tabindex="0"  role="radio"></i>
                        <i class="fa fa-star-o fa-2x rating-star" id="rating-10" data-rating="10" tabindex="0" role="radio"></i>
                    </div>-->


                </div>
                <div class="modal-footer">

                    <form>
                        <button name='savechanges' class="btn btn-primary" type="submit">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>


<div style="margin-top: 50px; margin-left: 20px ;">
    <div style="color: #F9C74F ; margin-bottom: 20px">CAST & CREW</div>
</div>


<div class="row" style="margin-right: 10px ;margin-left: 10px">


    <?php
    foreach ($rowcast as $row) {

        $actid = $row['act_id'];
        $role = $row['role'];
        $actname = $row['act_name'];
        $actpp = $row['act_pp'];


        ?>
        <div class="col" style="text-align: center">
            <img class="castpp" src="castandcrewpp/<?php echo $actpp ?>">
            <div style="color: #F8961E;align-self: center"><?php echo $actname ?></div>
            <div style="color: #84837F;align-self: center; font-size: 12px"><?php echo $role ?></div>
        </div>
        <?php
    }


    ?>


    <div style="margin-top: 50px">
        <div style="color: #F9C74F ; margin-left: 10px ; margin-bottom: 20px">PHOTOS</div>
    </div>

    <div class="row" style="margin-left: 10px;height: 220px;overflow-x: auto; overflow-y:hidden;white-space:nowrap ">
        <?php
        foreach ($rowphotos as $row) {

            $photo = $row['photo'];

            ?>
            <div class="col" style="display:inline-block">
                <img class="photos" src="moviephotos/<?php echo $photo ?>">
            </div>
            <?php
        }
        ?>

    </div>


    <div style="margin-top: 50px">
        <div style="color: #F9C74F ; margin-left: 10px ; margin-bottom: 20px">MORE LIKE</div>
    </div>
    <div class="row" style="margin-left: 20px">
        <div class="col">
            <img src="poster/<?php echo $moreposter1?>"class="favoritefilms">
            <div class="score">
                <div class=" wscore"><?php echo $moreimdb1?>/10</div>
                <div class="wname"><?php echo $morename1?> (<?php echo $moreyear1?>)</div>
            </div>
        </div>
        <div class="col">
            <img src="poster/<?php echo $moreposter2?>" class="favoritefilms">
            <div class="score">
                <div class=" wscore"><?php echo $moreimdb2?>/10</div>
                <div class="wname"><?php echo $morename2?> (<?php echo $moreyear2?>)</div>
            </div>
        </div>
        <div class="col">
            <img src="poster/<?php echo $moreposter3?>" class="favoritefilms">
            <div class="score">
                <div class=" wscore"><?php echo $moreimdb3?>/10</div>
                <div class="wname"><?php echo $morename3?> (<?php echo $moreyear3?>)</div>
            </div>
        </div>
        <div class="col">
            <img src="poster/<?php echo $moreposter4?>" class="favoritefilms">
            <div class="score">
                <div class=" wscore"><?php echo $moreimdb4?>/10</div>
                <div class="wname"><?php echo $morename4?> (<?php echo $moreyear4?>)</div>
            </div>
        </div>
    </div>


    <div class="col" style="color: #F9C74F ;margin-top: 50px;margin-bottom: 20px; margin-left: 50px">REVIEWS</div>
    <div>

        <?php
        foreach ($rowreviews as $row) {

            $review = $row['review'];
            $useridr = $row['user_id'];
            $movieidr = $row['movie_id'];

            $select_reviwer = $db->prepare("SELECT * FROM user WHERE user_id=:uuserid");
            $select_reviwer->execute(array(":uuserid" => $useridr));
            $rowreviwer = $select_reviwer->fetch(PDO::FETCH_ASSOC);

            $select_reviwer = $db->prepare("SELECT * FROM user WHERE user_id=:uuserid");
            $select_reviwer->execute(array(":uuserid" => $useridr));
            $rowreviwer = $select_reviwer->fetch(PDO::FETCH_ASSOC);

            $select_reviwer_rate = $db->prepare("SELECT * FROM watchedmovies WHERE user_id=:uuserid and movie_id =:umovieid");
            $select_reviwer_rate->execute(array(":uuserid" => $useridr,
                ":umovieid" => $movieidr
            ));
            $rowreviwerrate = $select_reviwer_rate->fetch(PDO::FETCH_ASSOC);


            ?>

            <div class="col" style="margin-left: 200px;margin-right: 200px">

                <div class="row">
                    <div class="col-sm-1">
                        <img src="userspp/<?php echo $rowreviwer['pp'] ?>" class="reviewpp">
                    </div>
                    <div class="col-sm-3"
                         style="color: #f4f1de; font-weight: bold ;margin-top :10px"><?php echo $rowreviwer['name'], ' ', $rowreviwer['lastname'] ?></div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="row">
                    <div style="color:#86BBD8;margin-top: 10px"><?php echo $review ?></div>
                </div>
            </div>
            <div class="row" style="justify-content: center">
                <hr style="border-width: 1px; color: #86BBD8; margin-top: 10px; width: 950px">

            </div>
            <?php
        }
        ?>

    </div>

    <div style="margin-top: 50px;margin-left: 200px">
        <div class="row">
            <div class="col-sm-1">
                <img src="userspp/<?php echo $pp ?>" class="reviewpp">
            </div>
            <div class="col-sm-3"
                 style="color: #f4f1de; font-weight: bold ;margin-top :10px"><?php echo $namep, ' ', $lastnamep ?></div>
            <div class="col-sm-7"></div>
        </div>
    </div>
    <form>

    <textarea placeholder="Enter your comment"
              style="height: 180px ;width: 900px;margin-left: 200px;margin-top: 30px;margin-bottom: 10px;background-color: #373737;color: white"
              class="form-control"
              type="description" id="description" name="review"></textarea>

        <button name='comment' class="btn btn-success"
                style="height: 40px; width: 100px; margin-left: 1000px ;margin-bottom: 50px; background-color: #F9C74F; color:#272727; font-weight: bold ">
            Comment
        </button>
    </form>

</body>

<script>
    $(document).ready(function () {

        function setRating(rating) {
            $('#rating-input').val(rating);
            // fill all the stars assigning the '.selected' class
            $('.rating-star').removeClass('fa-star-o').addClass('selected');
            // empty all the stars to the right of the mouse
            $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('selected').addClass('fa-star-o');
        }

        $('.rating-star')
            .on('mouseover', function(e) {
                var rating = $(e.target).data('rating');
                // fill all the stars
                $('.rating-star').removeClass('fa-star-o').addClass('fa-star');
                // empty all the stars to the right of the mouse
                $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('fa-star').addClass('fa-star-o');
            })
            .on('mouseleave', function (e) {
                // empty all the stars except those with class .selected
                $('.rating-star').removeClass('fa-star').addClass('fa-star-o');
            })
            .on('click', function(e) {
                var rating = $(e.target).data('rating');
                setRating(rating);
            })
            .on('keyup', function(e){
                // if spacebar is pressed while selecting a star
                if (e.keyCode === 32) {
                    // set rating (same as clicking on the star)
                    var rating = $(e.target).data('rating');
                    setRating(rating);
                }
            });
    });
</script>