@extends('layouts.menu')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
@section('contenido')
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
        @slot('mostrarBoton', $mostrarBoton)
    @endcomponent
    <br>
    <div class="card">
            <div class="card-header">
                    Busqueda por fecha
            </div>
            <div class="card-body">
                <div class="container">
                     <div class="form-group">
                    <div class="row">
                        <div class="input-group input-daterange" id="datepicker">
                                <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                            <input type="text" class="input-sm form-control" name="start" id="start"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            <div class="input-group-addon border">Hasta:</div>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            <input type="text" class="input-sm form-control" name="end" id="end" />
                            <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                        </div>
                    </div>
                </div>    
                <div class="form-group">
                    <div class="row justify-content-md-center">
                         <button class=" btn btn-primary" id="buscarFecha" name="buscarFecha">Buscar</button>
                    </div>
                </div>
                </div>
               
            </div>
        </div>
    <br>

    <canvas id="canvas" height="280" width="600"></canvas>
    <br>
 
    <script>
        var ctx = document.getElementById("canvas").getContext('2d');
        let myChart= new Chart(ctx);
           $('.input-daterange').datepicker({
            format: "yy-mm-dd",
            clearBtn: true,
            orientation: "bottom auto",
            todayHighlight: true
        });
        $('#buscarFecha').on('click',function(e){
            let start= $('#start').val();
            let end= $('#end').val();
            let fechas=[];
            fechas['start']=start;
            fechas['end']=end;
            console.log(fechas);
            var url = "{{url('PagoServicios/montoServicios')}}";
        var servicios = new Array();
        var coloR = [];
        var montos = new Array();
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };
            $.ajax({
                        url: url,
                        data: "&_token={{ csrf_token()}}",
                        type:'POST',
                        data:{fechaInicio:fechas['start'],fechaFinal:fechas['end']},
                    }).done(function(data){ 
                        myChart.destroy();
                            data.servicios.forEach(function(servicio){
                                servicios.push(servicio.descripcion);
                                //Labels.push(data.stockName);
                                montos.push(servicio.monto);
                                coloR.push(dynamicColors());
                            });
                            var ctx = document.getElementById("canvas").getContext('2d');
                            myChart = new Chart(ctx, {
                            type: 'horizontalBar',
                            data: {
                                labels:servicios,
                                datasets: [{
                                    data: montos,
                                    borderWidth: 1,
                                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
                                    borderColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero:true
                                        }
                                    }]
                                },
                                legend: {
                                    labels: {
                                        generateLabels: function(chart) {
                                        var labels = chart.data.labels;
                                        var dataset = chart.data.datasets[0];
                                        var legend = labels.map(function(label, index) {
                                            return {
                                                datasetIndex: 0,
                                                text: 'BS.S por '+label,
                                                fillStyle: dataset.backgroundColor[index],
                                                strokeStyle: dataset.borderColor[index],
                                                lineWidth: 1
                                            }
                                        });
                                        return legend;
                                        }
                                    }
                                }
                            }
                        });

                    });
        });
     </script>
   
@endsection