fetch('data/scores.json')
  .then(response => response.json())
  .then(jsonData => {
    //  jsonData is an array of arrays? = [['01/03/2024', 3, 2, 1], ...]
    data.addRows(jsonData);
    // Finish the with the rest of the chart drawing logic here.
  })
  .catch(error => {
    console.error('Error fetching local JSON data:', error);
  });
