<!-- Extends the base layout -->
@extends('layouts.base')

<!-- Sets the page title -->
@section('title', 'Consumo de Agua Anual')

<!-- Includes a CSS file -->
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

<!-- Content section of the page -->
@section('content')

    <!-- Main content container -->
    <main>

        <div class="graphic">

            <!-- Container that renders the graph and allows modifying the resolution of the graph -->
            <canvas id="myChart" width="550" height="150"></canvas>

            <script>
                // Executes when the DOM is fully loaded.
                document.addEventListener('DOMContentLoaded', function() {

                    // Retrieves JSON data from PHP variable.
                    var sensorMeasurements = @json($sortedResultados);

                    // Extracts dates (years) from the data.
                    var labels = Object.keys(sensorMeasurements);

                    // Extracts consumption values from the data.
                    var values = Object.values(sensorMeasurements);

                    // Gets the 2D rendering context for the canvas.
                    var ctx = document.getElementById('myChart').getContext('2d');

                    // Creates a new Chart.js chart.
                    var myChart = new Chart(ctx, {
                        type: 'polarArea', // Specifies the chart type.
                        data: {
                            labels: labels, // Sets the labels for the chart.
                            datasets: [{
                                label: 'Annual Water Consumption', // Sets the label for the dataset.
                                data: values, // Sets the data values for the dataset.
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

        </div>

        <div class="content">

            <div id="content-one">

                <h3>Consumo de Agua Anual</h3>

                <h4>Desde 2020 hasta 2023</h4>

                <!-- Display the total consumption for all years -->
                <h2>{{ $totalConsumption }}</h2>

                <img src="{{ asset('assets/images/icons/water.png') }}" />

            </div>

            <div id="content-two">
                <h3>Consejo: Cierra bien el grifo</h3>

                <h4>Incluso pequeñas fugas pueden sumar grandes cantidades de agua desperdiciada.</h4>

            </div>

            <div id="content-three">

                <h3>Consumo de Agua Anual</h3>

                <h4>Desde 2020 hasta 2023</h4>

                <!-- Display the total consumption for all years -->
                <h2>{{ $totalConsumption }}</h2>

                <img src="{{ asset('assets/images/icons/water.png') }}" />

            </div>

            <div id="content-four">

                <h3>Más sobre SmartEcoSchool:</h3>
                <img id="qr" src="{{ asset('assets/images/icons/qr.png') }}" />

            </div>

        </div>

    </main>

    <script>
        // To debug code, log JSON data to the console.
        console.log(@json($sortedResultados));

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
