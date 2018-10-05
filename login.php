<?php
    if(isset($_POST['login'])) {
        // Function to validate data
        function validateFormData($formData) {
            $formData = trim(stripslashes(htmlspecialchars($formData)));
            return $formData;
        }
        
        // create variables
        // wrap the data with the function
        $formUser = validateFormData($_POST['username']);
        $formPass = validateFormData($_POST['password']);
        
        // Connect to the DB
        include('connection.php');
        
        // Create SQL query
        $query = "SELECT username, email, password FROM users WHERE username='$formUser'";
        
        // Store the result
        $result = mysqli_query($conn, $query);
        
        // Verify if the result is returned
        if(mysqli_num_rows($result) > 0) {
            // store basic user data in variables
            while($row = mysqli_fetch_assoc($result)) {
                $user = $row['username'];
                $email = $row['email'];
                $hashedPass = $row['password'];
                
            }
            
            // Verify hashed password with typed password
            if(password_verify($formPass, $hashedPass)) {
                // Correct login details
                // Start the session
                session_start();
                
                // Store data in SESSION variables
                $_SESSION['loggedInUser'] = $user;
                $_SESSION['loggedInEmail'] = $email;
                
                header("Location: profile.php");
            } else {
                // hashed password didn't verify
                // Error message
                $loginError = "<div class='alert alert-danger'>Wrong Username/Password combination. Try again.</div>";
            }
        } else {
            // No results in DB
            $loginError = "<div class='alert alert-danger'>No such user in database. Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        
        // Close the SQL connection
        mysqli_close($conn);
    }
?>




    <!DOCTYPE html>

    <html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            <h1>Login</h1>
            <p class="lead">
                Use this form to log into your account
            </p>
            <?php
                echo $loginError;
            ?>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="login-username" class="sr-only">
                  Username  
                </label>
                        <input type="text" class="form-control" id="login-username" name="username" placeholder="username">
                    </div>

                    <div class="form-group">
                        <label for="login-password" class="sr-only">
                  Password  
                </label>
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="password">
                    </div>
                    <button type="submit" class="btn btn-default" name="login">
                Login
            </button>
                </form>
        </div>

        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>

    </html>
