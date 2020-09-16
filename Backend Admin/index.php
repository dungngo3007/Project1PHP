<?php
include_once("functions/functions.php");


$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["name"])) {
        $err["name"] = "Enter admin name";
    }

    if (empty($_POST["psw"])) {
        $err["psw"] = "Enter password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url("Background/background-login.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }

        .form-login {
            position: absolute;
            top: 15%;
            right: 25%;
            background-color: whitesmoke;
            border-radius: 8px;
            width: 50%;
            box-shadow: 5px 5px;
            padding: 30px;
        }

        #Login {
            border-radius: 10px;
            position: relative;
            left: 17%;
            margin: auto;
        }

        #name,
        #psw {
            border-radius: 10px;
            position: relative;
            left: 25%;
            margin: auto;
        }

        #remember {
            text-align: center;
        }

        span {
            color: red;
            position: relative;
            left: 17%;
            margin: auto;
        }

        .label-admin {
            position: relative;
            left: 25%;
            margin: auto;
        }

        #Header-Login {
            text-align: center;
            font-size: 35px;
            font-family: 'Times New Roman', Times, serif;
        }

        #validate-login{
            position: absolute;
            left:35%;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="form-login">
            <h2 id="Header-Login">Login Admin</h2>
            <br><br>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8 col-xs-10 col-sm-8">
                        <label for="name" class="label-admin">Name</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="Admin Name" value="<?php echo !empty($err) ? $_POST['name'] : "" ?>">
                    </div>
                </div>
                <span>
                    <?php echo isset($err['name']) ? $err['name'] : ""; ?>
                </span>
                <br><br>
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8 col-xs-10 col-sm-8">
                        <label for="psw" class="label-admin">Password</label>
                        <input id="psw" type="password" class="form-control" name="psw" placeholder="Admin Password">
                    </div>
                </div>
                <span>
                    <?php echo isset($err['psw']) ? $err['psw'] : "" ?>
                </span><br><br>
                <div class="form-group" id="remember">
                    <label for="rememberME">Remember Me</label>
                    <input type="checkbox" name="remember" id="rememberME">
                </div>
                <br>
                <div class="row">
                    <input id="Login" type="submit" value="Login" name="submit" class="btn btn-success col-md-8 col-lg-8 col-xs-10 col-sm-8">
                </div>
            </form>

            <?php

            if (isset($_POST["name"])) {
                $Admin = Select_Name_Admin($_POST['name']);

                if ($Admin == null && $err == []) {
                    echo "<br><span id='validate-login'>Username or password wrong</span><br>";
                }

                if (isset($_POST['submit']) && $err == [] && isset($Admin['Name']) && isset($Admin['Password'])) {
                    if ($_POST['name'] == $Admin['Name'] && sha1($_POST['psw']) == $Admin['Password']) {
                        $_SESSION['admin'] = $Admin['Name'];
                        if (isset($_POST['remember'])) {
                            setcookie("username", $_POST["name"], time() + 86400, "/");
                        }
                        redirect_to("Home Admin/IndexAdmin.php");
                    } else {
                        echo "<br><span id='validate-login'>Username or password wrong</span><br>";
                    }
                }
            }

            if (isset($_COOKIE['username'])) {
                $_SESSION['admin'] = $_COOKIE['username'];
                redirect_to("Home Admin/IndexAdmin.php");
            }
            ?>
        </div>

    </div>
</body>

</html>


<?php
db_disconnect($cn);
?>