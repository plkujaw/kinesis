import Chart from 'chart.js/auto';
import 'chartjs-adapter-moment';

function generateDummyHistoricalData(numDays) {
  const historicalData = [];

  const startDate = new Date();
  startDate.setDate(startDate.getDate() - numDays);

  const graphs = document.querySelectorAll('.graph');

  const symbols = [];

  graphs.forEach((graph) => {
    symbols.push(graph.dataset.symbol);
  });

  symbols.forEach((symbol) => {
    const symbolData = [];
    for (let i = 0; i < numDays; i++) {
      const currentDate = new Date(startDate);
      currentDate.setDate(startDate.getDate() + i);

      const price = Math.random() * (6000 - 500) + 500; // Simulated price within a range
      const dateString = currentDate.toISOString().split('T')[0];

      symbolData.push({ date: dateString, price: price.toFixed(2) });
    }
    historicalData.push({ symbol: symbol, data: symbolData });
  });

  return historicalData;
}

// Function to generate the chart
function generateChart(canvas, data) {
  // console.log(data);
  const dates = data.map((entry) => entry.date);
  const prices = data.map((entry) => entry.price);

  const isIncreasing = prices[prices.length - 1] > prices[0];
  const lineColor = isIncreasing ? 'rgb(89, 185, 165)' : 'rgb(216, 0, 39)'; // Change to red for decreasing trend

  const gradient = canvas.createLinearGradient(0, 0, 0, 45);
  gradient.addColorStop(
    0,
    isIncreasing ? 'rgba(89, 185, 165, 0.4)' : 'rgba(216, 0, 39, 0.4)'
  );
  gradient.addColorStop(
    0.3,
    isIncreasing ? 'rgba(89, 185, 165, 0.2)' : 'rgba(216, 0, 39, 0.2)'
  );
  gradient.addColorStop(
    1,
    isIncreasing ? 'rgba(89, 185, 165, 0)' : 'rgba(216, 0, 39, 0)'
  );

  new Chart(canvas, {
    type: 'line',
    data: {
      labels: dates,
      datasets: [
        {
          label: 'Price',
          data: prices,
          borderColor: lineColor,
          backgroundColor: gradient, // Set gradient as the background
          fill: true,
          pointRadius: 0, // Set point radius to 0 to hide the points
          borderWidth: 1.4, // Set the line width to 1.3 pixel
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          display: false, // Hide x-axis labels
        },
        y: {
          display: false, // Hide y-axis labels
        },
      },
      plugins: {
        legend: {
          display: false, // Hide legend
        },
        tooltip: {
          enabled: false, // Disable tooltips
        },
      },
      layout: {
        padding: {
          top: 0,
          bottom: 0,
          left: 0,
          right: 0,
        },
      },
    },
  });
}

// Generate the dummy data
const numDays = 7;
const dummyData = generateDummyHistoricalData(numDays);

// Attach charts to each cell
const tableRows = document.querySelectorAll('.table__cell.graph');
dummyData.forEach((coinData, index) => {
  const canvas = document.createElement('canvas');
  const canvasId = coinData.symbol;
  canvas.style.height = '45px';
  canvas.id = canvasId;
  tableRows[index].appendChild(canvas);
  const ctx = canvas.getContext('2d');
  generateChart(ctx, coinData.data);
});
