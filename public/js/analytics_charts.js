// Analytics Dashboard Charts

document.addEventListener('DOMContentLoaded', function () {
    // User Role Distribution Chart
    if (document.getElementById('userRoleChart')) {
        const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
        const userRoleChart = new Chart(userRoleCtx, {
            type: 'doughnut',
            data: {
                labels: ['Admin', 'Parent', 'Child', 'Ambassador'],
                datasets: [{
                    data: [
                        document.getElementById('adminCount').value,
                        document.getElementById('parentCount').value,
                        document.getElementById('childCount').value,
                        document.getElementById('ambassadorCount').value
                    ],
                    backgroundColor: [
                        '#6c5ce7',
                        '#00b894',
                        '#fdcb6e',
                        '#e84393'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'User Role Distribution',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }

    // Book Status Distribution Chart
    if (document.getElementById('bookStatusChart')) {
        const bookStatusCtx = document.getElementById('bookStatusChart').getContext('2d');
        const bookStatusChart = new Chart(bookStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Available', 'Swapped', 'Sold'],
                datasets: [{
                    data: [
                        document.getElementById('availableBooks').value,
                        document.getElementById('swappedBooks').value,
                        document.getElementById('soldBooks').value
                    ],
                    backgroundColor: [
                        '#00b894',
                        '#0984e3',
                        '#d63031'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Book Status Distribution',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }

    // Transaction Type Distribution Chart
    if (document.getElementById('transactionTypeChart')) {
        const transactionTypeCtx = document.getElementById('transactionTypeChart').getContext('2d');
        const transactionTypeChart = new Chart(transactionTypeCtx, {
            type: 'bar',
            data: {
                labels: ['Swap', 'Sell'],
                datasets: [{
                    label: 'Transaction Count',
                    data: [
                        document.getElementById('swapTransactions').value,
                        document.getElementById('sellTransactions').value
                    ],
                    backgroundColor: [
                        '#0984e3',
                        '#6c5ce7'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Transaction Type Distribution',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // Transaction Status Chart
    if (document.getElementById('transactionStatusChart')) {
        const transactionStatusCtx = document.getElementById('transactionStatusChart').getContext('2d');
        const transactionStatusChart = new Chart(transactionStatusCtx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Completed'],
                datasets: [{
                    label: 'Status Count',
                    data: [
                        document.getElementById('pendingTransactions').value,
                        document.getElementById('approvedTransactions').value,
                        document.getElementById('completedTransactions').value
                    ],
                    backgroundColor: [
                        '#fdcb6e',
                        '#00b894',
                        '#6c5ce7'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Transaction Status',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
});