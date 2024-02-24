@extends('layout.admin')

@section('content')
@section('judul')
    Grafik Novsosiaplaze
@endsection
<div>
    <h1>Penjualan</h1>
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>
<div>
    <h1>jumlah Register</h1>
    <canvas id="userChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/sales-chart')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const labels = data.map(entry => entry.month);
                const salesData = data.map(entry => entry.total_sales);
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Sales',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            data: salesData,
                        }],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            })
            .catch(error => console.error('Error fetching sales data:', error));
    });
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/user-chart')
            .then(response => response.json())
            .then(data => {
                console.log(data);

                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                const labels = data.map(entry => monthNames[entry.month - 1]);
                const usersData = data.map(entry => entry.total_users);

                const ctx = document.getElementById('userChart').getContext('2d');

                const datasets = [{
                    label: 'Monthly Unique Users',
                    borderWidth: 1,
                    data: usersData,
                    backgroundColor: [],
                }];
                for (let i = 0; i < datasets[0].data.length; i++) {
                    const backgroundColor = i % 2 === 0 ? 'rgba(75, 192, 192, 0.2)' : 'rgba(255, 99, 132, 0.2)';
                    datasets[0].backgroundColor.push(backgroundColor);
                }

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets,
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1,
                            },
                        },
                    },
                });
            })
            .catch(error => console.error('Error fetching user data:', error));
    });
</script>
@endsection