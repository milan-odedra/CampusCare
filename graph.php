<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellbeing graph</title>
    
    <!-- Load Google Charts API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Include other head elements like scripts or additional CSS-->
</head>
<body>

    <?php include 'app/header.php'; ?>


    <main class="graph-main">
        <h1>Your wellbeing scores over time</h1>
        <div id="wellbeing-chart"></div>
    </main>
    

    <script src="js/graph.js"></script> <!-- Include your graph.js file -->
   
    
    
    <?php include 'app/footer.php'; ?>

</body>
</html>
