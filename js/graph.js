// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// This function will draw the chart using data fetched locally.
function drawChart() {
  fetch('data/scores.json')
    .then(response => response.json())
    .then(jsonData => {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', 'Happiness');
      data.addColumn('number', 'Workload Management');
      data.addColumn('number', 'Anxiety');

      // Transform jsonData into the format expected by Google Charts
      var chartData = jsonData.map(function(entry) {
        return [new Date(entry.date).toLocaleDateString(), entry.happiness, entry.workload, entry.anxiety];
      });

      data.addRows(chartData);

  // Set chart options
  var options = {
    title: 'Your wellbeing scores over time',
    curveType: 'function',
    width: '100%',
    height: 500,
    legend: { position: 'bottom' },
    hAxis: { title: 'Date' },
    vAxis: { title: 'Score' }
  };

  //Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('wellbeing-chart'));
      chart.draw(data, options);
    })
    .catch(error => {
      console.error('Error fetching local JSON data:', error);
    });
}