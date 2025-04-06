(function() {
	"use strict";

	// Impression Share
	var options = {
		series: [10],
		chart: {
			height: 150,
			type: 'radialBar',
			offsetY: 0,
			offsetX: 85
		},
		colors: ['#00B69B'],
		plotOptions: {
			radialBar: {
				startAngle: -135,
				endAngle: 135,
				offsetY: -10,
				dataLabels: {
					name: {
						fontSize: '12px',
						offsetY: 60,
						color: '#00B69B',
						offsetY: 40,
					},
					value: {
						offsetY: 76,
						fontSize: '15px',
						fontWeight: 600,
						color: '#5B5B98',
						offsetY: -10,
						formatter: function (val) {
							return val + "%";
						}
					}
				},
				hollow: {
					margin: 0,
					size: "40%",
					background: "#ffffff"
				},
			}
		},
		labels: ['Excellent'],
		responsive: [{
			breakpoint: 475,
			options: {
				chart: {
					offsetY: -15,
					offsetX: 25
				},
			},
		}]
	};
	var chart = new ApexCharts(document.querySelector("#impression_share"), options);
	chart.render();
})();