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


include_once('partials/header.php');
?>


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
        </div> 
                <input type="submit" value="Next" class="next-button">
            </form>

    </div>


    <?php  include_once('partials/footer.php') ?>