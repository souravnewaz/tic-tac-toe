<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <style>

        h1 a {
            text-decoration:none;
            color: black;
        }

        .bg-dark-light{
            background-color: rgba(0, 0, 0, 0.2);
        }

        body{
            min-height:100vh;
        }

        .main-content{
            min-height:calc(100vh - 160px);
        }
    </style>

</head>
<body class="bg-light">
    <div class="bg-white text-center p-3 shadow-sm">
        <h1><a href="/">Tic Tac Toe</a></h1>
    </div>
    <div class="container main-content">
        @yield('content')
    </div>
    <footer class="bg-dark-light text-center p-3 shadow-sm pt-auto">
        <span>© 2022 All rights reserved | Rakibul Newaz Sourav</span>
    </footer>
</body>
</html>