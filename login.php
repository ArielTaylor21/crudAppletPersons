<!DOCTYPE html>

<html>

    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width = device-width, initial-scale
              = 1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title> Login  </title>
    </head>

    <body>
        <?php
        include_once './database/function.php';
        include_once './database/database.php';

        if (isLoggedIn()) {
            $person = $_SESSION['person'];
            if ($person->role == "Admin") {
                redirect("admin.php");
            }
            redirect("user.php");
        }
        $error = false;

        if (isset($_POST["inputEmail"]) && isset($_POST["inputPassword"])) {

            $input_email = htmlspecialchars($_POST["inputEmail"]);
            $input_password = htmlspecialchars($_POST["inputPassword"]);


            $person = new Person();
            $person->email = $input_email;

            $pdo = get_pdo_conn();

            if ($person->isExisting($pdo) == true) {
                if (matching($input_password,
                                $person->password_salt,
                                $person->password_hash) == 0) {
                    $_SESSION['person'] = $person;
                    if ($person->role == "Admin") {
                        redirect("admin.php");
                    }
                    redirect("user.php");
                }
            }
            $error = true;
        }
        include './include/login_nav.html';
        ?>        
        <form action="login.php" method="post">            
            <div class="container">
                <?php
                if ($error) {
                    echo ' <div class="alert alert-danger">
    <strong>Error!</strong> Invalid Email or Password </div>';
                }
                ?>
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card card-signin my-5">
                            <div class="card-body">
                                <h5 class="card-title text-center">Sign In</h5>
                                <form class="form-signin">
                                    <div class="form-label-group">
                                        <label for="inputEmail">Email address</label>
                                        <input type="email" id="inputEmail" 
                                               name="inputEmail" 
                                               class="form-control"
                                               placeholder="Email address" 
                                               required autofocus>                                    
                                    </div>
                                    <div class="form-label-group">
                                        <label for="inputPassword">Password</label>
                                        <input type="password" 
                                               id="inputPassword" 
                                               name="inputPassword" 
                                               class="form-control" 
                                               placeholder="Password" required>                                    
                                    </div>

                                    <button 
                                        class="btn btn-lg btn-primary btn-block 
                                        text-uppercase" type="submit">
                                        Sign in</button>
                                    <hr class="my-4">                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>                
    </body>
</html>
