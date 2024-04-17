<?php
// Start the session at the very top of the script
session_start();


// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user consented and provided a name
    if (isset($_POST['consent']) && !empty($_POST['firstName'])) {
        // Store the name in a session or cookie
        setcookie('username', $_POST['firstName'], time() + (86400 * 30)); // expires in 30 days
        // Redirect to home page or wherever you want
        header('Location: index.php');
        exit;
    } elseif (!isset($_POST['consent'])) {
        // User did not consent or did not provide a name, set a flag in a session or cookie to not ask again
        setcookie('askForName', 'no', time() + (86400 * 30)); // expires in 30 days
        // Redirect as well
        header('Location: index.php');
        exit;
    }
}

// Include the header
    include 'app/header.php';
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Your Name</title>
    
    <!-- Include other head elements like scripts or additional CSS -->
</head>
<body>



    
    <main>
    <section id="store-name-form">
            <h2>Want your name to be greeted with the daily quote?</h2>
            <p>Consent with the form below</p>
            
            <form action="storeName.php" method="POST" autocomplete="on"> 
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="firstName" required placeholder="Enter First Name"required>
                </div>

                <div class="form-group">
                    <label for="consent">
                        <input type="checkbox" id="consent" name="consent">
                        Do you Consent
                    </label>
                </div>

                <button type="submit" class="submit-button">Submit</button>
            </form>
        </section>
    </main>
    
    <?php include 'app/footer.php'; ?>

</body>
</html>
