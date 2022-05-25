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
                <a class="dropdown-item" href="#" style="color: #F8961E">Privacy Policy</a>
                <div style="height: 5px"></div>
                <a class="dropdown-item" href="termsofservice.php" style="color: white">Terms of Service</a>
            </div>


            <div class="col" style="margin-top: 50px" >

                <h3 style="color: white; text-align: center">Privacy Policy of Movie Gamma</h3>

                <p style="color: white;margin-top: 20px">MovieGamma operates the www.MovieGamma.com website, which provides the SERVICE.</p>

                <p style="color: white">This page is used to inform website visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service, the MovieGamma website.

                    If you choose to use our Service, then you agree to the collection and use of information in relation with this policy. The Personal Information that we collect are used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy. Our Privacy Policy was created with the help of the Privacy Policy Template Generator.

                    The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at www.MovieGamma.com, unless otherwise defined in this Privacy Policy.</p>

                    <h5 style="color: white">Information Collection and Use</h5>
                <p style="color: white">For a better experience while using our Service, we may require you to provide us with certain personally identifiable information, including but not limited to your name, phone number, and postal address. The information that we collect will be used to contact or identify you.</p>

                <h5 style="color: white" >Log Data</h5>
                <p style="color: white">We want to inform you that whenever you visit our Service, we collect information that your browser sends to us that is called Log Data. This Log Data may include information such as your computer’s Internet Protocol ("IP") address, browser version, pages of our Service that you visit, the time and date of your visit, the time spent on those pages, and other statistics.</p>

                <h5 style="color: white">Cookies</h5>
                    <p style="color: white">Cookies are files with small amount of data that is commonly used an anonymous unique identifier. These are sent to your browser from the website that you visit and are stored on your computer’s hard drive.

                <p style="color: white"> Our website uses these "cookies" to collection information and to improve our Service. You have the option to either accept or refuse these cookies, and know when a cookie is being sent to your computer. If you choose to refuse our cookies, you may not be able to use some portions of our Service.

                        For more general information on cookies, please read "Cookies" article from the Privacy Policy Generator. </p>

                <h5 style="color: white">Service Providers</h5>
                    <p style="color: white">We may employ third-party companies and individuals due to the following reasons:<p>

                <p style="color: white">To facilitate our Service;</p>
                <p style="color: white">To provide the Service on our behalf;</p>
                <p style="color: white">To perform Service-related services; or</p>
                <p style="color: white">To assist us in analyzing how our Service is used.</p>
                <p style="color: white">We want to inform our Service users that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>>

                <h5 style="color: white">Security</h5>
                    <p style="color: white">We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.

                    <h5 style="color: white">Links to Other Sites</h5>
                <p style="color: white">Our Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over, and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>

                        <h5 style="color: white">Children's Privacy</h5>

                <p style="color: white">Our Services do not address anyone under the age of 13. We do not knowingly collect personal identifiable information from children under 13. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do necessary actions.

                <h5 style="color: white"> Changes to This Privacy Policy</h5>
                <p style="color: white">We may update our Privacy Policy from time to time. Thus, we advise you to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately, after they are posted on this page.</p>

                            <h5 style="color: white">Contact Us</h5>
                <p style="color: white">If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us.</p>
            </div>


        </div>


    </div>

    <div class="col"></div>
</div>


