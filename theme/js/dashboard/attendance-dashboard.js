(function ($) {
    "use strict";

    // "utils" function to format time
    function formatTime(date) {
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    // "utils" function to generate random data
    function generateRandomData(count, min, max) {
        return Array.from({ length: count }, () => Math.floor(Math.random() * (max - min + 1) + min));
    }

    // "utils" function to generate dates for the last 30 days
    function generateDates(count) {
        const dates = [];
        for (let i = count - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            dates.push(date.toISOString().split('T')[0]);
        }
        return dates;
    }

    // update quantity blocks { later derive from db data }
    $('#totalEmployees').text('500');
    $('#presentToday').text('450');
    $('#absentToday').text('50');
    $('#avgDailyAttendance').text('480');
    $('#avgPunchInTime').text('10:45 AM');
    $('#avgPunchOutTime').text('06:30 PM');
    $('#totalWorkingHours').text('3,840');
    $('#avgWorkingHours').text('7.68');

    // Daily Attendance Trend
    new Chart(document.getElementById('dailyAttendanceTrend'), {
        type: 'line',
        data: {
            labels: generateDates(30),
            datasets: [{
                label: 'Employees Present',
                data: generateRandomData(30, 400, 500),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    // Punch-in Times Histogram
    new Chart(document.getElementById('punchInHistogram'), {
        type: 'bar',
        data: {
            labels: ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30'],
            datasets: [{
                label: 'Punch-in Count',
                data: generateRandomData(6, 10, 100),
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Punch-out Times Histogram
    new Chart(document.getElementById('punchOutHistogram'), {
        type: 'bar',
        data: {
            labels: ['17:00', '17:30', '18:00', '18:30', '19:00', '19:30'],
            datasets: [{
                label: 'Punch-out Count',
                data: generateRandomData(6, 10, 100),
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Weekly Working Hours
    new Chart(document.getElementById('weeklyWorkingHours'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Average Working Hours',
                data: generateRandomData(7, 6, 9),
                borderColor: '#20c997',
                backgroundColor: 'rgba(32, 201, 151, 0.1)',
                pointBackgroundColor: '#20c997',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#20c997',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                        beginAtZero: false
                    }
            }
        }
    });

    // Late Arrivals
    new Chart(document.getElementById('lateArrivals'), {
        type: 'bar',
        data: {
            labels: generateDates(7),
            datasets: [{
                label: 'Late Arrivals',
                data: generateRandomData(7, 5, 30),
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Early Departures
    new Chart(document.getElementById('earlyDepartures'), {
        type: 'bar',
        data: {
            labels: generateDates(7),
            datasets: [{
                label: 'Early Departures',
                data: generateRandomData(7, 5, 30),
                backgroundColor: 'rgba(255, 205, 86, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Punctuality Rate
    new Chart(document.getElementById('punctualityRate'), {
        type: 'doughnut',
        data: {
            labels: ['On Time', 'Late'],
            datasets: [{
                data: [85, 15],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Punctuality Rate: 85%'
                }
            }
        }
    });

    // Overtime Analysis
    new Chart(document.getElementById('overtimeAnalysis'), {
        type: 'bar',
        data: {
            labels: generateDates(7),
            datasets: [{
                label: 'Overtime Hours',
                data: generateRandomData(7, 0, 5),
                backgroundColor: 'rgba(153, 102, 255, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Populate Top 10 Employees Table
    function populateTopEmployeesTable() {
        const tableBody = document.getElementById('topEmployeesTable');
        for (let i = 1; i <= 10; i++) {
            const row = tableBody.insertRow();
            row.insertCell(0).textContent = i;
            row.insertCell(1).textContent = `EMP${1000 + i}`;
            row.insertCell(2).textContent = `Employee ${i}`;
            row.insertCell(3).textContent = `${95 + Math.floor(Math.random() * 5)}%`;
            row.insertCell(4).textContent = `${7 + Math.random().toFixed(1)}`;
        }
    }

    populateTopEmployeesTable();

})(jQuery);