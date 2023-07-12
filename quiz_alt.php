<?php
require_once('connexion.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$selectedAnswer = $_GET['question'];
$resultAnswer = $_GET['result'];
$idQuestion = $_GET['idQuestion'];

// Получение вопроса и правильного ответа из базы данных
$query = "SELECT * FROM questions WHERE question_id = :idQuestion";
$request = $db->prepare($query);
$request->execute([
    ':idQuestion' => $idQuestion
]);
$currentQuestion = $request->fetch();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Quiz - Quiz</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>

<body>
    <div class="container">
        <?php if (isset($_SESSION['username'])) { ?>
            <p>pseudo: <?php echo $_SESSION['username'] ?></p>

            <form action="process/process_deconnexion.php" method="post">
                <button type="submit">deconnexion</button>
            </form>
        <?php } ?>

        <h1 class="title">Quiz</h1>
        <div class="quiz">
            <h2 class="question"><?php echo $currentQuestion['question_text']; ?></h2>
            <form method="get" action="quiz.php" class="answer-form">
                <input type="hidden" name="question_id" value="<?php echo $currentQuestion['question_id']; ?>">
                <?php
                $tabAnswersTemp = array_keys($currentQuestion);
                $tabAnswers = [
                    $tabAnswersTemp[4] => $currentQuestion['correct_answer'],
                    $tabAnswersTemp[6] => $currentQuestion['wrong1'],
                    $tabAnswersTemp[8] => $currentQuestion['wrong2'],
                    $tabAnswersTemp[10] => $currentQuestion['wrong3'],
                ];

                foreach ($tabAnswers as $key => $answer) {

                    if ($key === 'correct_answer') {
                        echo '<input type="submit" value="' . $answer . '" class="correct" disabled>';
                    } else {
                        echo '<input type="submit" value="' . $answer . '" class="wrong" disabled>';
                    }
                }
                ?>
                <input type="submit" value="Next" class="next-button">
            </form>
        </div>
    </div>
</body>

</html>