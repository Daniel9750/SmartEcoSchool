@extends('layout.base')

@section('title', 'Bienvenido a SmartEcoSchool')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/graphics.css') }}" />
@endsection

@section('disconnect')
    @include('components.disconnect')
@endsection

@section('content')

    <!-- Muestra el valor de la clave success que está almacenado en una sesión flash -->
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    <main>

        <!-- Contenedor que renderiza el gráfico y permite modificar la resolución del gráfico -->
        <canvas id="myChart" width="350" height="150"></canvas>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var sensorMeasurements = @json($sensorMeasurements);

                var labels = sensorMeasurements.map(function(measurement) {
                    return measurement.fecha_medicion + ' ' + measurement.hora_medicion;
                });

                var values = sensorMeasurements.map(function(measurement) {
                    return measurement.valor_medicion;
                });

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
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
        document.addEventListener('DOMContentLoaded', function() 
        {
            setInterval(function() 
                {
                    // Redireccionar a la vista deseada.
                    window.location.href = '{{ route('graphics.table') }}';
                }, 
            60000); // Intervalo de 10 segundos (60000 milisegundos).
        });
    </script>

    <!-- Carga la biblioteca gratuita Chart.js desde la red mediante un Content Delivery Network -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
