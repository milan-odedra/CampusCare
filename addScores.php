<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();  // Start the session at the very beginning

if (!isset($_SESSION['scores'])) {
    $_SESSION['scores'] = [];
}

// Function to calculate the average of an array of values, only if there are exactly three or more
function calculateAverage($values) {
    $count = count($values);
    return $count >= 3 ? array_sum($values) / $count : null;
}

$jsonFilePath = 'data/scores.json';
$scores = [];

if (file_exists($jsonFilePath)) {
    $scores = json_decode(file_get_contents($jsonFilePath), true) ?? [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $happiness = isset($_POST['happiness']) ? intval($_POST['happiness']) : null;
    $workload = isset($_POST['workload']) ? intval($_POST['workload']) : null;
    $anxiety = isset($_POST['anxiety']) ? intval($_POST['anxiety']) : null;

    // Append new scores
    $scores[] = ['date' => date('Y-m-d'), 'happiness' => $happiness, 'workload' => $workload, 'anxiety' => $anxiety];

    file_put_contents($jsonFilePath, json_encode($scores));

    $_SESSION['scores'] = $scores; // Update the session scores

    header('Location: addScores.php');
    exit;
}

$todayScores = $scores[count($scores) - 1] ?? ['happiness' => 'Not set', 'workload' => 'Not set', 'anxiety' => 'Not set'];

$lastThreeScores = array_slice($scores, -3);
$happinessValues = $workloadValues = $anxietyValues = [];

foreach ($lastThreeScores as $score) {
    if (isset($score['happiness'])) $happinessValues[] = $score['happiness'];
    if (isset($score['workload'])) $workloadValues[] = $score['workload'];
    if (isset($score['anxiety'])) $anxietyValues[] = $score['anxiety'];
}

$happinessAverage = calculateAverage($happinessValues);
$workloadAverage = calculateAverage($workloadValues);
$anxietyAverage = calculateAverage($anxietyValues);

$adviceNeeded = ($happinessAverage !== null && $happinessAverage < 1.5) ||
                ($workloadAverage !== null && $workloadAverage < 1.5) ||
                ($anxietyAverage !== null && $anxietyAverage < 1.5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellbeing Scores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'app/header.php'; ?>
    <main class="wellbeing-main-content">
        <div class="wellbeing-form-container">
            <h2>How is your wellbeing today?</h2>
            <form action="addScores.php" method="POST" id="wellbeing-form">
                <div class="question-container">
                    <label>How happy are you?</label>
                    <div class="options">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label><input type="radio" name="happiness" value="<?= $i ?>" <?= $todayScores['happiness'] == $i ? 'checked' : '' ?>><?= $i ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="question-container">
                    <label>How did you manage your work?</label>
                    <div class="options">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label><input type="radio" name="workload" value="<?= $i ?>" <?= $todayScores['workload'] == $i ? 'checked' : '' ?>><?= $i ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="question-container">
                    <label>What is your anxiety level?</label>
                    <div class="options">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label><input type="radio" name="anxiety" value="<?= $i ?>" <?= $todayScores['anxiety'] == $i ? 'checked' : '' ?>><?= $i ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
        <div class="wellbeing-score-container">
            <h2>Today's Wellbeing Scores:</h2>
            <p>Happiness: <?= $todayScores['happiness'] ?>/5</p>
            <p>Workload Management: <?= $todayScores['workload'] ?>/5</p>
            <p>Anxiety Level: <?= $todayScores['anxiety'] ?>/5</p>
        </div>
        <?php if ($adviceNeeded): ?>
        <div class="advice-container">
            <h2>Seek Professional Assistance</h2>
            <p>Your average score in one or more categories is below 1.5. It's advisable to seek professional assistance for your wellbeing.</p>
        </div>
        <?php endif; ?>
        <section class="more-help-section">
            <h2>More Help and Support</h2>
        </section>
    </main>
    <?php include 'app/footer.php'; ?>
</body>
</html>
