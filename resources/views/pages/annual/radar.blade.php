<!-- Extends the base layout -->
@extends('layouts.base')

<!-- Sets the page title -->
@section('title', 'Consumo de Electricidad Anual')

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
            <canvas id="myChart" width="550" height="100"></canvas>

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

                    // Creates a new Chart.js radar chart.
                    var myChart = new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: '2023',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: '2022',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: '2021',
                                    data: values,
                                    backgroundColor: 'rgba(255, 255, 0, 0.2)',
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: '2020',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }
                            ]
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

                <h2>CONSUMO ELÉCTRICO ANUAL</h2>

                <br />

                <div class="sub-content-one">
                    <table>
                        <tbody>
                            <!-- Shows consumption for each year -->
                            @foreach ($sortedResultados as $year => $consumption)
                                <tr>
                                    <td>{{ $year }}:</td>
                                    <td>{{ abs($consumption) }}</td> <!-- Asegura que el valor sea positivo -->
                                    <td>kW⋅h</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div id="content-two">

                <h2>CONSUMO ELÉCTRICO TOTAL</h2>

                <br /><br />

                <img src="{{ asset('assets/images/icons/ray.png') }}" />

                <br />

                <!-- Display the total consumption for all years -->
                <h3>{{ $totalConsumption }} kW⋅h</h2>

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
                                <td>{{ $minConsumption }}</td>
                                <td>kW⋅h</td>
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
                                <td>{{ $maxConsumption }}</td>
                                <td>kW⋅h</td>
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
                window.location.href = '{{ route('pages.monthly.bar') }}';
            }, 60000); // 60-second interval (60000 milliseconds).
        });
    </script>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
