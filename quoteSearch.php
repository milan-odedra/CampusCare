<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for Quotes</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include 'app/header.php'; ?>

    <main class="quote-search-main">
        <h1>Search Inspirational Quotes</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Type a keyword or author" aria-label="Search quotes">
            <button id="search-button">Search</button>
        </div>
        <div id="quote-results">
            <!-- Results will be displayed here -->
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#search-button').click(function(event) {
                event.preventDefault();  // Prevent default form submission
                var searchText = $('#search-input').val().trim();
                $('#quote-results').html(''); // Clear previous results

                if (!searchText) {
                    $('#quote-results').html('<p>Please enter a keyword or author name.</p>');
                    return;
                }

                $.ajax({
                    url: 'searchQuotes.php',
                    type: 'GET',
                    data: {search: searchText},
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(function(quote) {
                                $('#quote-results').append(`<div class="quote"><p>"${quote.quote}" <strong>— ${quote.author}</strong></p></div>`);
                            });
                        } else {
                            $('#quote-results').html('<p>No quotes found matching your criteria.</p>');
                        }
                    },
                    error: function() {
                        $('#quote-results').html('<p>An error occurred while searching.</p>');
                    }
                });
            });
        });
    </script>

    <?php include 'app/footer.php'; ?>
</body>
</html>
