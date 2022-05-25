<?php

require_once "dbconnect.php";

session_start();

$id = $_SESSION['user_login'];

$select_stmt = $db->prepare("SELECT * FROM user WHERE user_id=:uid");
$select_stmt->execute(array(":uid" => $id));

$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
$pp = $row["pp"];

?>


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
        height: 36px;

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

<div class="row">
    <div class="col"></div>
    <div class=" col card-body card-body-color text_body editcard">
        <div class="row" style="margin-bottom: 50px">

            <div class="col-sm-3 leftcard">
                <a class="dropdown-item" href="editprofile.php" style="color: white">Edit Profile</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item " href="#" style="color: white">Change Password</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="#" style="color: white">Privacy and Security</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="privacypolicy.php" style="color: white">Privacy Policy</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="#" style="color: #F8961E">Terms of Service</a>
            </div>


            <div class="col" style="margin-top: 50px" >

                <h3 style="color: white; text-align: center">Terms of Service</h3>


                <h5 style="color: white; margin-top: 20px">1. Terms</h5>
                <p style="color: white">By accessing this Website, accessible from www.MovieGamma.com , you are agreeing to be bound by these Website Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials contained in this Website are protected by copyright and trade mark law.</p>

                <h5 style="color: white" >2. Use License</h5>
                <p style="color: white">Permission is granted to temporarily download one copy of the materials on MovieGamma's Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:

                    modify or copy the materials;
                    use the materials for any commercial purpose or for any public display;
                    attempt to reverse engineer any software contained on MovieGamma's Website;
                    remove any copyright or other proprietary notations from the materials; or
                    transferring the materials to another person or "mirror" the materials on any other server.
                    This will let MovieGamma to terminate upon violations of any of these restrictions. Upon termination, your viewing right will also be terminated and you should destroy any downloaded materials in your possession whether it is printed or electronic format. These Terms of Service has been created with the help of the Terms Of Service Generator.</p>

                <h5 style="color: white">3. Disclaimer</h5>

                <p style="color: white">All the materials on MovieGamma’s Website are provided "as is". MovieGamma makes no warranties, may it be expressed or implied, therefore negates all other warranties. Furthermore, MovieGamma does not make any representations concerning the accuracy or reliability of the use of the materials on its Website or otherwise relating to such materials or any sites linked to this Website.</p>

                <h5 style="color: white">4. Limitations</h5>
                <p style="color: white">MovieGamma or its suppliers will not be hold accountable for any damages that will arise with the use or inability to use the materials on MovieGamma’s Website, even if MovieGamma or an authorize representative of this Website has been notified, orally or written, of the possibility of such damage. Some jurisdiction does not allow limitations on implied warranties or limitations of liability for incidental damages, these limitations may not apply to you.</p>

                <h5 style="color: white">5. Revisions and Errata</h5>
                <p style="color: white">The materials appearing on MovieGamma’s Website may include technical, typographical, or photographic errors. MovieGamma will not promise that any of the materials in this Website are accurate, complete, or current. MovieGamma may change the materials contained on its Website at any time without notice. MovieGamma does not make any commitment to update the materials.</p>

                <h5 style="color: white">6. Links</h5>
                <p style="color: white">MovieGamma has not reviewed all of the sites linked to its Website and is not responsible for the contents of any such linked site. The presence of any link does not imply endorsement by MovieGamma of the site. The use of any linked website is at the user’s own risk.
                </p>

                <h5 style="color: white">7. Site Terms of Use Modifications</h5>

                <p style="color: white">MovieGamma may revise these Terms of Use for its Website at any time without prior notice. By using this Website, you are agreeing to be bound by the current version of these Terms and Conditions of Use.</p>

                <h5 style="color: white"> 8. Your Privacy</h5>
                <p style="color: white">Please read our Privacy Policy.</p>

                <h5 style="color: white">9. Governing Law</h5>
                <p style="color: white">Any claim related to MovieGamma's Website shall be governed by the laws of af without regards to its conflict of law provisions.
                </p>
            </div>


        </div>


    </div>

    <div class="col"></div>
</div>


