<?php

require_once "dbconnect.php";
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("location: login_admin.php");
}


$id = $_SESSION['admin_login'];


$select_stmt = $db->prepare("SELECT * FROM admin WHERE id_a=:uid");
$select_stmt->execute(array(":uid" => $id));

$row1 = $select_stmt->fetch(PDO::FETCH_ASSOC);

$pp = $row1["pp_a"];


//user number
$userlist = $db->prepare("SELECT * FROM user");
if ($userlist->execute(array())) {
}
$user_number = $userlist->rowCount();

//film number
$filmlist = $db->prepare("SELECT * FROM movie");
if ($filmlist->execute(array())) {
}
$film_number = $filmlist->rowCount();

$selectist = $db->prepare("select movie_id, COUNT(movie_id) as sayi from watchedmovies group by movie_id having COUNT(movie_id) > 0  order by sayi DESC ");
if ($selectist->execute(array())) {
}


//most watched film
$rowist = $selectist->fetchAll(PDO::FETCH_ASSOC);
$watched1 = $rowist[0]["movie_id"];
$watched2 = $rowist[1]["movie_id"];
$watched3 = $rowist[2]["movie_id"];
$watched4 = $rowist[3]["movie_id"];
$watched5 = $rowist[4]["movie_id"];


$watched2number = $rowist[1]["sayi"];
$watched1number = $rowist[0]["sayi"];
$watched3number = $rowist[2]["sayi"];
$watched4number = $rowist[3]["sayi"];
$watched5number = $rowist[4]["sayi"];

$select_m = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m->execute(array(":umovieid" => $watched1));
$rowm = $select_m->fetch(PDO::FETCH_ASSOC);
$movie1 = $rowm['movie_name'];

$select_m2 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m2->execute(array(":umovieid" => $watched2));
$rowm2 = $select_m2->fetch(PDO::FETCH_ASSOC);
$movie2 = $rowm2['movie_name'];

$select_m3 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m3->execute(array(":umovieid" => $watched3));
$rowm3 = $select_m3->fetch(PDO::FETCH_ASSOC);
$movie3 = $rowm3['movie_name'];

$select_m4 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m4->execute(array(":umovieid" => $watched4));
$rowm4 = $select_m4->fetch(PDO::FETCH_ASSOC);
$movie4 = $rowm4['movie_name'];

$select_m5 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m5->execute(array(":umovieid" => $watched5));
$rowm5 = $select_m5->fetch(PDO::FETCH_ASSOC);
$movie5 = $rowm5['movie_name'];



//most favorited


$selectist = $db->prepare("select movie_id, COUNT(movie_id) as sayi from favoritemovies group by movie_id having COUNT(movie_id) > 0  order by sayi DESC ");
if ($selectist->execute(array())) {
}
$rowistf = $selectist->fetchAll(PDO::FETCH_ASSOC);
$favorite1 = $rowistf[0]["movie_id"];
$favorite2 = $rowistf[1]["movie_id"];
$favorite3 = $rowistf[2]["movie_id"];
$favorite4 = $rowistf[3]["movie_id"];
$favorite5 = $rowistf[4]["movie_id"];


$favorite2number = $rowistf[1]["sayi"];
$favorite1number = $rowistf[0]["sayi"];
$favorite3number = $rowistf[2]["sayi"];
$favorite4number = $rowistf[3]["sayi"];
$favorite5number = $rowistf[4]["sayi"];

$select_m = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m->execute(array(":umovieid" => $favorite1));
$rowm = $select_m->fetch(PDO::FETCH_ASSOC);
$movief1 = $rowm['movie_name'];

$select_m2 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m2->execute(array(":umovieid" => $favorite2));
$rowm2 = $select_m2->fetch(PDO::FETCH_ASSOC);
$movief2 = $rowm2['movie_name'];

$select_m3 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m3->execute(array(":umovieid" => $favorite3));
$rowm3 = $select_m3->fetch(PDO::FETCH_ASSOC);
$movief3 = $rowm3['movie_name'];

$select_m4 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m4->execute(array(":umovieid" => $favorite4));
$rowm4 = $select_m4->fetch(PDO::FETCH_ASSOC);
$movief4 = $rowm4['movie_name'];

$select_m5 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m5->execute(array(":umovieid" => $favorite5));
$rowm5 = $select_m5->fetch(PDO::FETCH_ASSOC);
$movief5 = $rowm5['movie_name'];


//most added watchlist


$selectist = $db->prepare("select movie_id, COUNT(movie_id) as sayi from watchlist group by movie_id having COUNT(movie_id) > 0  order by sayi DESC ");
if ($selectist->execute(array())) {
}
$rowistw = $selectist->fetchAll(PDO::FETCH_ASSOC);
$watchlist1 = $rowistw[0]["movie_id"];
$watchlist2 = $rowistw[1]["movie_id"];
$watchlist3 = $rowistw[2]["movie_id"];
$watchlist4 = $rowistw[3]["movie_id"];
$watchlist5 = $rowistw[4]["movie_id"];


$watchlist2number = $rowistw[1]["sayi"];
$watchlist1number = $rowistw[0]["sayi"];
$watchlist3number = $rowistw[2]["sayi"];
$watchlist4number = $rowistw[3]["sayi"];
$watchlist5number = $rowistw[4]["sayi"];

$select_m = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m->execute(array(":umovieid" => $watchlist1));
$rowm = $select_m->fetch(PDO::FETCH_ASSOC);
$moview1 = $rowm['movie_name'];

$select_m2 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m2->execute(array(":umovieid" => $watchlist2));
$rowm2 = $select_m2->fetch(PDO::FETCH_ASSOC);
$moview2 = $rowm2['movie_name'];

$select_m3 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m3->execute(array(":umovieid" => $watchlist3));
$rowm3 = $select_m3->fetch(PDO::FETCH_ASSOC);
$moview3 = $rowm3['movie_name'];

$select_m4 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m4->execute(array(":umovieid" => $watchlist4));
$rowm4 = $select_m4->fetch(PDO::FETCH_ASSOC);
$moview4 = $rowm4['movie_name'];

$select_m5 = $db->prepare("SELECT movie_name FROM movie WHERE movie_id=:umovieid");
$select_m5->execute(array(":umovieid" => $watchlist5));
$rowm5 = $select_m5->fetch(PDO::FETCH_ASSOC);
$moview5 = $rowm5['movie_name'];









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
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

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


    .vertical-center {
        margin: 0;
        position: absolute;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }


    .cardstyle1 {
        height: 200px;
        background-color: #577590;
    }

    .cardstyle2 {
        height: 200px;
        background-color: #f28482;
    }


</style>


<body class="background">
<nav class="navbar top_border justify-content-between">
    <p class="border_text_style vertical-center" style="top: 50%;left:5%;">Movie Gamma</p>
    <a href="adminprofile.php">
        <img class="pp vertical-center" style="top: 50%;left: 95%;" src="adminpp/<?php echo $pp ?>">
    </a>

</nav>

<div class="row" style="margin-top: 70px">
    <div class="col-sm-2"></div>

    <button class="col-sm-3 btn" onclick="direct_1()">

        <div class="card  cardstyle1">
            <div style="color: white; font-size: 80px;font-weight: bold; align-self: center"><?php echo $user_number ?></div>
            <div style="color: white; font-size: 40px;font-weight: bold;align-self: center">Users</div>
        </div>
    </button>

    <div class="col-sm-2"></div>
    <button class="col-sm-3 btn" onclick="direct_2()">
        <div class="card cardstyle2 ">
            <div style="color: white; font-size: 80px;font-weight: bold; align-self: center"><?php echo $film_number ?></div>
            <div style="color: white; font-size: 40px;font-weight: bold;align-self: center">Films</div>
        </div>
    </button>

    <div class="col-sm-2"></div>
</div>


<canvas id="myChart" style="background-color: #494949;border-radius:10px
;width:100%;max-width:800px;margin-left: 300px ;margin-top: 70px"></canvas>

<script>
    var xValues = ["<?php echo $movie1?>","<?php echo $movie2?>","<?php echo $movie3?>", "<?php echo $movie4?>", "<?php echo $movie5?>"];
    var yValues = ["20","<?php echo $watched2number?>","<?php echo $watched3number?>", "<?php echo $watched4number?>", "<?php echo $watched5number?>"];
    var barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
                text: "Most Watched Movies"
            }
        }
    });
</script>

<div class="row" style="margin-left: 20px">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">

    <canvas id="myChart2"
            style="background-color: #494949;border-radius:10px;max-width:500px ;margin-bottom: 50px; margin-top: 70px"></canvas>

    <script>
        var xValues = ["<?php echo $movief1?>", "<?php echo $movief2?>", "<?php echo $movief3?>", "<?php echo $movief4?>", "<?php echo $movief5?>"];
        var yValues = ["<?php echo $favorite1number?>", "<?php echo $favorite2number?>", "<?php echo $favorite3number?>", "<?php echo $favorite4number?>", "<?php echo $favorite5number?>"];
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9",
            "#1e7145"
        ];

        new Chart("myChart2", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Most Favorited Movies"
                }
            }
        });
    </script>
    </div>

    <div class="col-sm-5">

        <canvas id="myChart3"
                style="background-color: #494949;border-radius:10px;max-width:500px ;margin-bottom: 50px; margin-top: 70px"></canvas>

        <script>
            var xValues = ["<?php echo $moview1?>", "<?php echo $moview2?>", "<?php echo $moview3?>", "<?php echo $moview4?>", "<?php echo $moview5?>"];
            var yValues = ["<?php echo $watchlist1number?>", "<?php echo $watchlist2number?>", "<?php echo $watchlist3number?>", "<?php echo $watchlist4number?>", "<?php echo $watchlist5number?>"];
            var barColors = [
                "#ffc300",
                "#5f0f40",
                "#41ead4",
                "#008000",
                "#fcaa67"
            ];

            new Chart("myChart3", {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: "Most Added Watchlist"
                    }
                }
            });
        </script>
    </div>
    <div class="col-sm-1"></div>

</div>


<script>
    function direct_1() {
        window.location.href = "admin_user.php";
    }

    function direct_2() {
        window.location.href = "admin_movie.php";
    }
</script>


</body>