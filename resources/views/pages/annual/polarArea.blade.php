<!-- Extends the base layout -->
@extends('layouts.base')

<!-- Sets the page title -->
@section('title', 'Welcome to SmartEcoSchool')

<!-- Includes a CSS file -->
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

<!-- Content section of the page -->
@section('content')

    <!-- Main content container -->
    <main>

        <!-- Container that renders the graph and allows modifying the resolution of the graph -->
        <canvas id="myChart" width="550" height="150"></canvas>

        <script>
            // Executes when the DOM is fully loaded.
            document.addEventListener('DOMContentLoaded', function() {

                // Retrieves JSON data from PHP variable.
                var sensorMeasurements = @json($resultados);

                // Extracts dates from the data.
                var labels = sensorMeasurements.map(function(measurement) {
                    return measurement.fecha;
                });

                // Extracts consumption values from the data.
                var values = sensorMeasurements.map(function(measurement) {
                    return measurement.consumo;
                });

                // Gets the 2D rendering context for the canvas.
                var ctx = document.getElementById('myChart').getContext('2d');

                // Creates a new Chart.js chart.
                var myChart = new Chart(ctx, {
                    type: 'polarArea',                          // Specifies the chart type.
                    data: {
                        labels: labels,                         // Sets the labels for the chart.
                        datasets: [{
                            label: 'Annual Water Consumption',  // Sets the label for the dataset.
                            data: values,                       // Sets the data values for the dataset.
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                            ],
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
        // To debug code, log JSON data to the console.
        console.log(@json($resultados));

        document.addEventListener('DOMContentLoaded', function() {
            // Redirect to the desired view every 60 seconds.
            setInterval(function() {
                    window.location.href = '{{ route('pages.annual.radar') }}';
                },
                60000); // 60-second interval (60000 milliseconds).
        });
    </script>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
