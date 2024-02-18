@extends('layouts.base')

@section('title', 'Bienvenido a SmartEcoSchool')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

@section('content')

    <main>

        <!-- Container that renders the graph and allows modifying the resolution of the graph -->
        <canvas id="myChart" width="550" height="150"></canvas>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var sensorMeasurements = @json($resultados);

                var labels = sensorMeasurements.map(function(measurement) {
                    return measurement.fecha;
                });

                var values = sensorMeasurements.map(function(measurement) {
                    return measurement.consumo; 
                });

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'polarArea',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Consumo de Agua Anual',
                            data: values,
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
        console.log(@json($resultados));
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                    // Redirect to the desired view.
                    window.location.href = '{{ route('pages.annual.radar') }}';
                },
                60000); // 10 second interval (60000 milliseconds).
        });
    </script>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
