<?php
include_once("../functions/functions.php");
if (isset($_POST["name"]) && isset($_POST["email"])) {
    $NameAd = Select_Name_Admin($_POST['name']);
    $EmailAd = Select_Email_Admin($_POST['email']);
}

if (!isset($_SESSION['admin'])) {
    redirect_to('../index.php');
}

$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["name"])) {
        $err["name"] = "Enter your name";
    }

    if (strlen($_POST["psw"]) != 8) {
        $err["psw"] = "Password needs at least 8 characters";
    }

    if (empty($_POST["psw"])) {
        $err["psw"] = "Enter password";
    }

    if (empty($_POST["email"])) {
        $err["email"] = "Enter your email";
    }

    if (empty($_POST["pswCf"])) {
        $err["pswCf"] = "Please Confirm password";
    }

    if ($_POST['psw'] != $_POST['pswCf']) {
        $err['pswCf'] = "The passwords do not match";
    }


    if (isset($NameAd['Name'])) {
        if ($NameAd['Name'] == $_POST['name']) {
            $err['name_conf'] = "Username is identical";
        }
    }

    if (isset($EmailAd['Email'])) {
        if ($EmailAd['Email'] == $_POST['email']) {
            $err['email_conf'] = "Email is identical";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url("../Background/background-login.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }

        .form-login {
            position: absolute;
            top: 10%;
            right: 30%;
            left: 30%;
            background-color: whitesmoke;
            border-radius: 8px;
            width: 40%;
            /* height: auto; */
            box-shadow: 5px 5px;
            padding: 30px;
        }

        #Login {
            border-radius: 10px;
            position: relative;
            top: 20%;
            left: 20%;
            margin: auto;
        }

        .sign-up {
            border-radius: 10px;
            position: relative;
            /* top: 30%; */
            left: 25%;
            right: 30%;
            margin: auto;
        }

        span {
            color: red;
            position: relative;
            /* top: 30%; */
            left: 25%;
            margin: auto;
        }

        .label-admin {
            position: relative;
            /* top: 30%; */
            left: 25%;
            margin: auto;
        }

        #Header-signup {
            text-align: center;
            font-size: 35px;
            font-family: 'Times New Roman', Times, serif;
        }

        .button {
            position: relative;
            left: 35%;
            display: inline;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="form-login">
            <h2 id="Header-signup">Sign up Form</h2><br>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="row">
                    <div class="col-md-8 col-lg-8 col-xs-10 col-sm-8">
                        <div class="form-group">
                            <label class="label-admin" for="name">Name: </label>
                            <input class="sign-up form-control" type="text" id="name" name="name" placeholder="Enter your name" value=<?php echo !empty($err) ? $_POST['name'] : "" ?>>
                            <span style='color:red;'>
                                <?php echo isset($err['name']) ? $err['name'] : "";
                                echo isset($err['name_conf']) ? $err['name_conf'] : ""
                                ?>
                            </span><br>
                        </div>
                        <div class="form-group">
                            <label class="label-admin" for='email'>Email: </label>
                            <input class="sign-up form-control" type="email" id="email" name="email" placeholder="Enter your email" value=<?php echo !empty($err) ? $_POST['email'] : ""; ?>>
                            <span style='color:red;'>
                                <?php echo isset($err['email']) ? $err['email'] : "";
                                echo isset($err['email_conf']) ? $err['email_conf'] : "" ?>
                            </span><br>
                        </div>
                        <div class="form-group">
                            <label class="label-admin" for="psw">Password: </label>
                            <input class="sign-up form-control" id="psw" type="password" name="psw" placeholder="Password">
                            <span style='color:red;'>
                                <?php echo isset($err['psw']) ? $err['psw'] : "" ?>
                            </span><br>
                        </div>
                        <div class="form-group">
                            <label class="label-admin" for="pswcf">Confirm Password: </label>
                            <input class="sign-up form-control" type="password" id="pswcf" name="pswCf" placeholder="Password">
                            <span style='color:red;'>
                                <?php echo isset($err['pswCf']) ? $err['pswCf'] : "" ?>
                            </span><br><br><br>
                        </div>
                        <div class="button">
                            <div class='row'>
                                <input class="col-md-5 col-lg-5 col-xs-5 col-sm-5 btn btn-success" type="submit" name="submit" value="Sign up">
                                <a href='../Home Admin/StatisticalAdmin.php' class='col-md-5 col-lg-5 col-xs-5 col-sm-5 btn btn-danger'>Cancel</a>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['psw'])) {
                            $admin = [];
                            $admin['name'] = $_POST['name'];
                            $admin['email'] = $_POST['email'];
                            $admin['psw'] = sha1($_POST['psw']);
                        }
                        if (isset($_POST['submit']) && $err == []) {
                            Create_Admin($admin);
                            echo "<div style='color:green; position:relative; left:40%;'>" . "Create account successfully" . "</div>";
                        }

                        ?>
                    </div>
                </div>
            </form>

        </div>
    </div>




</body>

</html>

<?php
db_disconnect($cn);
?>