<?php

require_once('connexion.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$isCorrect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    // Обработка ответа пользователя
    $username = $_SESSION['username'];

    $query = 'SELECT * FROM `users` WHERE `username` = :username ';
    $request = $db->prepare($query);
    $request->execute([
        ':username' => $username,
    ]);
    $user = $request->fetch();
    // var_dump($user);

    if(isset($_POST['correct_answer'])){
        $selectedAnswer = $_POST['correct_answer'];
        $isCorrect = true;
    }
    if(isset($_POST['wrong1'])){
        $selectedAnswer = $_POST['wrong1'];
    }
    if(isset($_POST['wrong2'])){
        $selectedAnswer = $_POST['wrong2'];
    }
    if(isset($_POST['wrong3'])){
        $selectedAnswer = $_POST['wrong3'];
    }
    $questionId = $_POST['question_id'];


    
    

    // Сохранение ответа пользователя в базе данных
    $query = "INSERT INTO answers (user_id, question_id, selected_answer) VALUES (:userId, :questionId, :selectedAnswer)";
    $request = $db->prepare($query);
    $request->execute([
        ':userId' => $user['user_id'],
        ':questionId' => $questionId,
        ':selectedAnswer' => $selectedAnswer,
    ]);


    if ($isCorrect) {
        $score = $user['score'] + 1;
        $query = "UPDATE users SET score = :score WHERE user_id = :userId";
        $request = $db->prepare($query);
        $request->execute([
            ':score' => $score,
            ':userId' => $user['user_id']
        ]);
    }

    header('Location: quiz_alt.php?question=' . $selectedAnswer);
}


// Получение вопросов из базы данных
$query = "SELECT * FROM questions ORDER BY RAND()";
$request = $db->query($query);
$currentQuestion = $request->fetch();
// var_dump($currentQuestion);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Quiz - Quiz</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <script src="assets/script.js"></script>
</head>

<body>
    <div class="container">
        <?php if(isset($_SESSION['username'])){  ?>
            <p>pseudo : <?php echo $_SESSION['username'] ?></p>

            <form action="process/process_deconnexion.php" method="post">
                <button type="submit">deconnexion</button>
            </form>

            <?php } ?>

        <h1 class="title">Quiz</h1>
        <div class="quiz">
            <h2 class="question"><?php echo $currentQuestion['question_text']; ?></h2>
            <form method="POST" action="quiz.php" class="answer-form">
                <input type="hidden" name="question_id" value="<?php echo $currentQuestion['question_id']; ?>">
                <?php
                // var_dump(array_keys($currentQuestion));

                $tabAnswersTemp = array_keys($currentQuestion);
                $tabAnswers = [
                    $tabAnswersTemp[4] => $currentQuestion['correct_answer'],
                    $tabAnswersTemp[6] => $currentQuestion['wrong1'],
                    $tabAnswersTemp[8] => $currentQuestion['wrong2'],
                    $tabAnswersTemp[10] => $currentQuestion['wrong3'],
                ];

                foreach ($tabAnswers as $key => $answer) { 
                    ?>

                    <input type="submit" name="<?php echo $key ?>" value="<?php echo $answer ?>">

                <?php } ?>
                <!-- <input type="submit" value="Next" class="next-button" disabled> -->
            </form>
        </div>
    </div>
</body>

</html>