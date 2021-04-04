<!DOCTYPE html>

<html>

    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width = device-width, initial-scale
              = 1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title> User </title>
    </head>

    <body>
        <?php
        include_once './database/database.php';
        include_once './database/function.php';
       

        if (isLoggedIn() == false) {
            redirect("login.php");
        }

        $person = $_SESSION['person'];
        if ($person->role == "Admin") {        
            if (isset($_POST["fname"])) {
                if (isset($_SESSION["updatedPerson"])) {
                    $p = $_SESSION["updatedPerson"];
                    $p->adminUpdateFromPostArray($_POST);
                    $p->adminUpdateDatabase(get_pdo_conn());
                    unset($_SESSION["updatedPerson"]);
                }
                redirect("admin.php");
            } else if (isset($_POST["email"])) {
                $p = new Person();
                $p->email = $_POST["email"];                
                if ($p->isExisting(get_pdo_conn()) == false) {
                    redirect("admin.php");
                }
                $_SESSION["updatedPerson"] = $p;
                
                include './include/admin_nav.html';
                echo '<div class="container">';
                echo $p->updateAdminForm("update.php");
                echo '</div>';                
            } else {
                redirect("admin.php");
            }           
        } else {
            if (isset($_POST["city"])) {
                $person->updateFromPostArray($_POST);
                $person->updateDatabase(get_pdo_conn());
                redirect("user.php");
            }

            include './include/user_nav.html';
            echo '<div class="container">';
            echo $person->updateForm("update.php");
            echo '</div>';
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>                
    </body>
</html>
