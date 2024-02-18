@extends('layouts.base')

@section('title', 'Bienvenido a SmartEcoSchool')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

@section('content')

    <main>

        <!-- Container that renders the graph and allows modifying the resolution of the graph -->
        <canvas id="myChart" width="550" height="250"></canvas>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var sensorMeasurements = @json($resultados);

                // Mapear los meses
                var months = {
                    1: 'Ene', 2: 'Feb', 3: 'Mar', 4: 'Abr', 5: 'May', 6: 'Jun',
                    7: 'Jul', 8: 'Ago', 9: 'Sep', 10: 'Oct', 11: 'Nov', 12: 'Dic'
                };

                var labels = sensorMeasurements.map(function(measurement) {
                    return months[measurement.month] + ' ' + measurement.year;
                });

                var values = sensorMeasurements.map(function(measurement) {
                    return measurement.consumo; 
                });

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Valor de Medición',
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            });
        </script>

    </main>

    <script>
        // To debug code.
        console.log(@json($resultados));

        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                    // Redirect to the desired view.
                    window.location.href = '{{ route('pages.monthly.line') }}';
                },
                60000); // 10 second interval (60000 milliseconds).
        });
    </script>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
