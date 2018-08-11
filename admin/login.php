

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Voting System</title>
        <!-- Bootstrap core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/small-business.css" rel="stylesheet">

        <link rel="stylesheet" href="../css/login.css">
        <script
                src="https://code.jquery.com/jquery-3.3.1.js"
                integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
                crossorigin="anonymous"></script>

    </head>
    <!-- navbar -->
    <body id="LoginForm">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="login.php">Voting System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">Login</a>
                        <span class="sr-only">(current)</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container large-heading-margin-top fixed-min-height1">
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Admin Login</h2>
                    <p>Please enter your username and password</p>
                </div>
                <form id="Login">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputUsername" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                    <div class="forgot">
                        <a href="forgot.php">Forgot password?</a>
                        <br>
                        <span class="text-danger" id="error"></span>
                    </div>
                    <button type="button" class="btn btn-primary" id="login_button">Login</button>
                </form>
            </div>
            <p class="botto-text"></p>
        </div>
    </div>
    <script>
        $("#login_button").click(function () {
            var username = $("#inputUsername").val();
            var password = $("#inputPassword").val();
            var data = {"username": username, "password": password};
            $.ajax({
                type: "GET",
                url: 'function.php?select=login',
                data: data,
                success: function (data) {
                    if (data == 'fails') {
                        $("#error").text("Please enter valid username or password");
                    }
                    else if (data == 'success') {
                        location.assign("index.php");
                    }
                    else {
                        alert("something went wrong");
                    }
                }
            });
        });

    </script>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Voting System 2018</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
    
