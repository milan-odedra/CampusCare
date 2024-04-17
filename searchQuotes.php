
<?php
header('Content-Type: application/json');  // Ensures the output is treated as JSON

$searchTerm = $_GET['search'] ?? ''; // Safely get the search term
$quotesData = json_decode(file_get_contents('data/quotes.json'), true);  // Make sure this path is correct
$filteredQuotes = [];

foreach ($quotesData['quotes'] as $quote) {
    if (stripos($quote['quote'], $searchTerm) !== false || stripos($quote['author'], $searchTerm) !== false) {
        $filteredQuotes[] = $quote; // Add matching quotes to results
    }
}

echo json_encode($filteredQuotes);  // Encode results as JSON
?>
