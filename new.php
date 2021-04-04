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

        include './include/admin_nav.html';
        $person = $_SESSION['person'];
        if ($person->role == "Admin") {
            $p = new Person();
            if (isset($_POST["fname"])) {
                $p->newAdminPostArray($_POST);
                $output = $p->validate();
                if (strlen($output) == 0) {
                    $pwd1 = hashing($p->password);
                    $p->password_hash = $pwd1->hashed_password;
                    $p->password_salt = $pwd1->salt;
                    $p->insert(get_pdo_conn());
                    redirect("admin.php");
                } else {
                    echo ' <div class="alert alert-danger">'
                    . '    <strong>Error!</strong> ' . $output . ' </div>';
                }
            }
            echo '<div class="container">';
            echo $p->newForm("new.php");
            echo '</div>';
        } else {
            redirect("user.php");
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>                
    </body>
</html>
