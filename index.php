<?php

require_once('connexion.php');

session_start();
// session_destroy();

if (isset($_SESSION['username'])) {
    header("Location: quiz.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];



    $query = "SELECT * FROM users WHERE username = :username";
    $request = $db->prepare($query);
    $request->execute([
        ':username' => $username,
    ]);
    $user = $request->fetch();

    if ($user === false) {

        $query = "INSERT INTO users (username) VALUES (:username)";
        $request = $db->prepare($query);
        $request->execute([
            ':username' => $username
        ]);
    }


    $_SESSION['username'] = $username;

    header("Location: quiz.php");
    exit();
}
?>

<?php 
include_once('partials/header.php');
?>

        <div id="signin">
        <form method="POST" action="index.php" class="login-form">
            <label for="username" class="login-label">Username:</label>
            <input type="text" id="username" name="username" class="login-input" required>
            <input type="submit" value="Start Quiz" class="login-button">
        </form>
        </div>

        <div id="userlist">
        <h3 class="user-list-heading">User List</h3>

         <table class="user-list-table">
            <tr>
                <th>User</th>
                <th>Best Score</th>
            </tr>
            <?php

            require_once('connexion.php');



            $query = "SELECT username, MAX(score) AS best_score FROM users GROUP BY username";
            $request = $db->query($query);

            while ($row = $request->fetch($db::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['best_score'] . "</td>";
                echo "</tr>";
            }

            ?>
         </table>

        </div>
    </div>


    <?php  include_once('partials/footer.php') ?>