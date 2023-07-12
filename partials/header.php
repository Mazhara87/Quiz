<!DOCTYPE html>
<html>

<head>
    <title>Quiz - Quiz</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <script src="assets/script.js"></script>
</head>

<body>
    <header id="header">
        <div>
            <h1 class="title"><img src="./assets/image/IMG_2853.jpg" height="100px"></h1>
        </div>
        <div class="container">
            <?php if (isset($_SESSION['username'])) {  ?>
                <p>Hello, <?php echo $_SESSION['username'] ?>!</p>

                <form action="process/process_deconnexion.php" method="post">
                    <button type="submit">Sign out</button>
                </form>

            <?php } ?>
        </div>

    </header>