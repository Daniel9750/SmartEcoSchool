@extends('layouts.base')

@section('title', 'Bienvenido a SmartEcoSchool')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

@section('content')
    <main>
        <!-- Container that renders the graph and allows modifying the resolution of the graph -->
        <canvas id="myChart" width="550" height="250"></canvas>
    </main>

    <!-- Load the free Chart.js library from the network using a Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sensorMeasurements = @json($resultados);

            // Definir labels y values aquí, antes de utilizarlos en el objeto myChart
            var labels = sensorMeasurements.map(function(measurement) {
                return measurement.fecha;
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

            // Redirigir cada 60 segundos (60000 milisegundos)
            setInterval(function() {
                window.location.href = '{{ route('pages.monthly.line') }}';
            }, 60000);
        });
    </script>
@endsection
