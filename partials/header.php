<!DOCTYPE html>
<html>

<head>
    <title>Quiz - Quiz</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <header id="header">
        <div class="container container-header">
            <div>
                <h1 class="title"><img src="./assets/image/ImageLogo.jpg" height="100px"></h1>
            </div>
            <div>
                <?php if (isset($_SESSION['username'])) {  ?>
                    <p>Hello, <?php echo $_SESSION['username'] ?>!</p>

                    <form action="process/process_deconnexion.php" method="post">
                        <button type="submit">Sign out</button>
                    </form>

                <?php } ?>
            </div>
        </div>

    </header>