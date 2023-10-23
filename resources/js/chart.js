import { toast } from './function.js';

window.addEventListener('DOMContentLoaded', () => {
  try {
    fetch('app/Jobs/process_monthly_sales.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => renderBarChart(data))
  } catch (error) {
    toast('error', error);
  }

  try {
    fetch('app/Jobs/process_brand_statistics.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => renderDonutChart(data.data, data.labels))
  } catch (error) {
    toast('error', error);
  }
})


function renderBarChart(datas) {
  const salesChart = new ApexCharts(document.querySelector('#sales-stats'), {
    chart: {
      animations: {
          enabled: true,
          easing: 'swing'
      },
      foreColor: '#A1A2A9',
      fontFamily: 'Poppins',
      height: '79%',
      stacked: true,
      toolbar: {
          show: false
      },
      type: 'bar',
      width: '100%',
      fontUrl: null
    },
    plotOptions: {
      bar: {
        columnWidth: '20%',
        borderRadius: 4,
        borderRadiusApplication: 'around',
        borderRadiusWhenStacked: 'last',
        hideZeroBarsWhenGrouped: false,
        isDumbbell: false,
        isFunnel: false,
        isFunnel3d: true,
        dataLabels: {
          total: {
            enabled: false,
            offsetX: 0,
            offsetY: 0,
            style: {
              color: '#373d3f',
              fontSize: '12px',
              fontWeight: 600
            }
          }
        }
      },
    },
    colors: ['#FF6452'],
    dataLabels: {
      enabled: false,
    },
    grid: {
      borderColor: 'rgba(236, 238, 255, 0.5)',
      padding: {
        right: 0,
        left: 5
      },
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: false
        }
      }
    },
    legend: {
      show: false
    },
    series: [
      {
        name: 'Montly Sales',
        data: datas
      }
    ],
    stroke: {
      show: false
    },
    tooltip: {
      shared: true,
      intersect: false,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        let seriesName = w.globals.seriesNames[seriesIndex];
        let color = w.globals.colors[seriesIndex];
        return (
          `
          <div class="custom-tooltip">
            <span class="tooltip_seriesname">${seriesName}</span>
            <div class="tooltip-wrapper">
                <div style="background-color: ${color};" class="tooltip-color"></div>
                <span class="tooltip_label">${w.globals.labels[dataPointIndex]} :</span>
                <span class="tooltip_series">₱${series[seriesIndex][dataPointIndex] }</span>
            </div>
            </div>
          `
        );
      }
    },
    xaxis: {
      offsetY: 2,
      labels: {
        trim: true,
        style: {
            fontSize: '10px'
        }
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      tickPlacement: 'between',
      style: {
        fontSize: '10px',
        fontWeight: 500
      },
      tooltip: {
        enabled: false
      },
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yaxis: {
      show: false
    }
  });
  
  salesChart.render();
}

function renderDonutChart(datas, labels){
  const brandChart = new ApexCharts(document.querySelector('#brand-stats'), {
    chart: {
      type: 'donut',
    },
    colors: ['#FF6452', '#ECEEFF', '#B6B9D1', '#A1A2A9', '#000000'],
    series: datas,
    labels: labels,
    dataLabels: {
      enabled: false
    },
    plotOptions: {
      pie: {
        startAngle: -90,
        endAngle: 90,
        customScale: 1,
        donut: {
          size: '60%',
          labels: {
            show: false
          }
        },
      },
    },
    legend: {
      show: false
    },
    stroke: {
      show: false
    },
    tooltip: {
      enabled: true,
      custom: function ({ seriesIndex, w }) {
        let color = w.globals.colors[seriesIndex];
        let label = w.globals.labels[seriesIndex];
        let value = w.globals.series[seriesIndex];
        return (
          `
          <div class="custom-tooltip" style="background-color: ${color};">
            <div class="tooltip-wrapper">
              <span class="tooltip_label">${label} :</span>
              <span class="tooltip_series" style="color: #fff">${value}</span>
            </div>
            </div>
          `
        );
      },
    }
  });
  
  brandChart.render();
}