<?php
// Start the session at the beginning of the script
session_start();

// Initialize greeting and link variables
$greeting = ''; // Default empty greeting
$askForNameLink = "<a href='storeName.php'>Want to be greeted by your name?</a>"; // Default link to store name

// Check if the username cookie is set and prepare greeting message
if (isset($_COOKIE['username'])) {
    $greeting = "Hello " . htmlspecialchars($_COOKIE['username']);
    $askForNameLink = ''; // Don't show the link if we have the username
} elseif (!isset($_COOKIE['askForName']) || $_COOKIE['askForName'] !== 'no') {
    $greeting = '';
}




// Load JSON quote data
$quotesData = json_decode(file_get_contents('./data/quotes.json'), true);
if ($quotesData === null) {
    die("Error loading or decoding JSON data.");
}

$quotesCount = count($quotesData['quotes']);

// Initialize quote index if not set
if (!isset($_SESSION['quoteIndex'])) {
    $_SESSION['quoteIndex'] = date('z') % $quotesCount;
}

// Debug: Uncomment the next line to check the session-stored quote index before any action
// var_dump($_SESSION['quoteIndex']);

// Check for navigation actions and update session-stored quote index accordingly
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'next') {
        $_SESSION['quoteIndex'] = ($_SESSION['quoteIndex'] + 1) % $quotesCount;
    } elseif ($_GET['action'] == 'prev') {
        $_SESSION['quoteIndex'] = ($_SESSION['quoteIndex'] - 1 + $quotesCount) % $quotesCount;
    }
    // Redirect to the same page without the action parameter
    header('Location: index.php');
    exit;
    
    // Debug: Uncomment the next line to check the session-stored quote index after an action
    // var_dump($_SESSION['quoteIndex']);
}

// Use the session-stored quote index
$quoteIndex = $_SESSION['quoteIndex'];
$quote = $quotesData['quotes'][$quoteIndex];

// Debug: Uncomment the next line to see the current quote data
// var_dump($quote);

include 'app/header.php';

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Care: Well-being and Support</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@400;700&family=Bebas+Neue&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <span id="greeting"><?= $greeting; ?></span> <!-- Display greeting if username is set -->
        <?= $askForNameLink; ?> <!-- Link to store name page if no greeting available -->

        <section id="daily-quote">
            <blockquote>
                <p><?= htmlspecialchars($quote['quote']); ?></p>
                <p>— <?= htmlspecialchars($quote['author']); ?></p>
            </blockquote>

            <div id="quote-nav">
                <a href="?action=prev">Previous Quote</a>
                <a href="?action=next">Next Quote</a>
            </div>
        </section>


        <section id="welcome-message">
        <h1>Supporting Student and Staff Wellbeing</h1>
        <p>Promoting wellbeing among student and staff is crucial for fostering a mentally supportive environment within education. It plays a significant role in enhancing staff retention, motivation, and consequently, student wellbeing and achievement.</p>
    </section>

    <section id="wellbeing-for-students-staff">
        <h2>Enhancing Wellbeing for Students and Staff</h2>
        <p>Wellbeing encompasses the complete spectrum of physical and emotional health. Achieving a high level of wellbeing means finding life balance, managing daily challenges effectively, and maintaining motivation and engagement. It’s about being resilient, bouncing back from difficulties, and thriving in both personal and academic pursuits.</p>
        <br></br>
        <p>For our educators and staff, juggling numerous tasks and pressures requires a robust support system that addresses both emotional and practical needs. This, in turn, empowers them to provide the best possible support to our students.</p>
        <br></br>
        <p>Prioritizing the wellbeing of both staff and students not only fosters a positive and supportive school culture but also improves performance, satisfaction, and engagement across the board. It leads to reduced turnover and absenteeism among staff, while promoting an environment where students and staff alike can flourish.</p>
    </section>




    </main>

    <?php include 'app/footer.php'; ?>
</body>
</html>
