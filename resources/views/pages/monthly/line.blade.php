<!-- Extends the base layout -->
@extends('layouts.base')

<!-- Sets the page title -->
@section('title', 'Consumo de Electricidad Mensual')

<!-- Includes a CSS file -->
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

<!-- Content section of the page -->
@section('content')

    <!-- Main content container -->
    <main>
        
        <!-- Container that renders the bar graph -->
        <canvas id="myBarChart" width="550" height="250"></canvas>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var sensorMeasurements = @json($resultados);

                // Mapear los meses.
                var months = {
                    1: 'Ene',
                    2: 'Feb',
                    3: 'Mar',
                    4: 'Abr',
                    5: 'May',
                    6: 'Jun',
                    7: 'Jul',
                    8: 'Ago',
                    9: 'Sep',
                    10: 'Oct',
                    11: 'Nov',
                    12: 'Dic'
                };

                var labels = sensorMeasurements.map(function(measurement) {
                    return months[measurement.month] + ' ' + measurement.year;
                });

                var values = sensorMeasurements.map(function(measurement) {
                    return measurement
                        .consumo_total; // Ajusta la propiedad según la estructura real de tus datos
                });

                var ctxBar = document.getElementById('myBarChart').getContext('2d');
                var myBarChart = new Chart(ctxBar, {
                    type: 'line',
                    data: {
                        labels: labels,
                        responsive: true,
                        datasets: [{
                            label: 'Valores de las Mediciones',
                            data: values,
                            backgroundColor: 'rgba(255, 255, 0, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 1000
                            }
                        }
                    }
                });
            });
        </script>

    </main>

    <script>
        // To debug code, log JSON data to the console.
        console.log(@json($resultados));

        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                    // Redirect to the desired view.
                    window.location.href = '{{ route('pages.monthly.line') }}';
                },
                60000); // 60-second interval (60000 milliseconds).
        });
    </script>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
