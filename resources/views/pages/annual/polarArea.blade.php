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

                <h2>CONSUMO DE AGUA ANUAL</h2>

                <br />

                <div class="sub-content-one">
                    <table>
                        <tbody>
                            <!-- Shows consumption for each year -->
                            @foreach ($sortedResultados as $year => $consumption)
                                <tr>
                                    <td>{{ $year }}:</td>
                                    <td>{{ abs($consumption) }}</td>
                                    <td>m3</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div id="content-two">

                <h2>CONSUMO TOTAL DE AGUA</h2>

                <br /><br />

                <img class="logo-content-two" src="{{ asset('assets/images/icons/water.png') }}" />

                <br />

                <!-- Display the total consumption for all years -->
                <h3>{{ $totalConsumption }} m3</h2>

            </div>

            <div id="content-three">

                <h2>RESUMEN</h2>

                <br />

                <div class="sub-content-one">
                    <!-- Shows consumption for each year -->
                    @php
                        $worstYear = null;
                        $bestYear = null;
                        $minConsumption = null;
                        $maxConsumption = null;
                    @endphp

                    @foreach ($sortedResultados as $year => $consumption)
                        @if ($maxConsumption === null || $consumption > $maxConsumption)
                            @php
                                $maxConsumption = $consumption;
                                $worstYear = $year;
                            @endphp
                        @endif

                        @if ($minConsumption === null || $consumption < $minConsumption)
                            @php
                                $minConsumption = $consumption;
                                $bestYear = $year;
                            @endphp
                        @endif
                    @endforeach
                    <table>
                        <thead>
                            <tr>
                                <td colspan="3" class="summary">MEJOR AÑO 😎</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $bestYear }}</td>
                                <td class="summary2">{{ $minConsumption }}</td>
                                <td class="summary2">m3</td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <table>
                        <thead>
                            <tr>
                                <td colspan="3" class="summary">PEOR AÑO 😇</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $worstYear }}</td>
                                <td class="summary2">{{ $maxConsumption }}</td>
                                <td class="summary2">m3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div id="content-four">

                <img id="logo-container" src="{{ asset('assets/images/logos/SmartEcoSchool.png') }}" />

                <div id="qr-container">
                    <img id="qr" src="{{ asset('assets/images/icons/qr.png') }}" />
                </div>

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
