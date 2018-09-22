<html>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 10cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0.5cm;
                right: 0.5cm;
                height: 10cm;

                /** Extra personal styles **/
    
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 8cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }
            table{
        border-collapse: collapse;
    }
    td{
        padding: 6px 5px;
        font-size: 15px;
    }
    .h1{
        font-size: 21px;
        font-weight: bold;
    }
    .h2{
        font-size: 18px;
        font-weight: bold;
    }
    .tabla1{
        margin-bottom: 20px;
        margin-right: 0.5cm;
    }
    .tabla2 {
        margin-bottom: 20px;
    }
    .tabla4 {
        margin-bottom: 35px;
    }
    .tabla3{
        margin-top: 15px;
    }
    .tabla3 td{
        border: 1px solid #000;
    }
    .tabla3 .cancelado{
        border-left: 0;
        border-right: 0;
        border-bottom: 0;
        border-top: 1px dotted #000;
        width: 200px;
    }
    .emisor{
        color: red;
    }
    .linea{
        border-bottom: 1px dotted #000;
    }
    .border{
        border: 1px solid #000;
    }
    .fondo{
        background-color: #dfdfdf;
    }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
                <table  width="100%" class="tabla1">
                    <tr>
                        <td width="73%" align="left"><img id="logo" src="{{asset('img/stp.png')}}" alt="" width="300" height="100"></td>
                        <td width="27%"  align="center" style="padding-right:0">
                             <!--<table width="100%">
                                <tr>
                                    <td  align="center" class=" fondo"><span class="h1">Presupuesto</span></td>
                                </tr>
                                <tr>
                                    <td  align="center" class="">Orden Nº <span class="text">{{ $orden['id'] }}</span></td>
                                </tr>
                            </table>-->
                            <table style="margin-top: 1cm;" width="100%" class="tabla4" >
                                <tr>
                                        <td width="13%">&nbsp;</td>
                                        <td width="4%">&nbsp;</td>
                                        <td width="7%" align="center" class="border fondo"><strong>DÍA</strong></td>
                                        <td width="8%" align="center" class="border fondo"><strong>MES</strong></td>
                                        <td width="7%" align="center" class="border fondo"><strong>AÑO</strong></td>
                                </tr>
                                <tr>
                                       
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="center" class="border"><span class="text">{{$orden['fecha'][0]}}</span></td>
                                        <td align="center" class="border"><span class="text">{{$orden['fecha'][1]}}</span></td>
                                        <td align="center" class="border"><span class="text">{{$orden['fecha'][2]}}</span></td>
                                </tr>
                                   
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  align="center">Telf.:0286-9231435</td>
                    </tr>
                    <tr>
                        <td  align="center">Correo.: stpseguridad@hotmail.com</td>
                        <td width="27%"  align="center" style="padding-bottom:5px">
                                <table width="100%">
                                        <tr>
                                            <td  align="center" class=" fondo"><span class="">Presupuesto</span></td>
                                        </tr>
                                        <tr>
                                            <td  align="center" class="">Orden Nº <span class="text">{{ $orden['id'] }}</span></td>
                                        </tr>
                                    </table>
                        </td>
                    </tr>
                </table>
                    <table width="100%" class="tabla2">
                        <tr>
                            <td width="5%" >Cliente:</td>
                            <td width="35%" class=""><span class="text">{{$orden['cliente']->nombre}}</span></td>
                            <td>&nbsp;</td>
                            <td width="5%">Tipo:</td>
                            <td class=""><span class="text">{{$orden['cliente']->tipo}}</span></td>
                        </tr>
                        <tr>
                            <td>Dirección:</td>
                            <td width="35%" class="">{{$orden['cliente']->direccion}}</td>
                            <td>&nbsp;</td>
                            @if($orden['cliente']['riff'])
                            <td>RIFF:</td>
                            <td width="35%" class="">{{$orden['cliente']['riff']}}</td>
                            @endif
                        </tr>
                </table>

                
        </header>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
                <table width="100%" class="tabla3">
                        <thead style="position:fixed;">
                            <tr>
                                <th align="center" class="fondo"><strong>DESCRIPCIÓN</strong></th>
                                <th align="center"  class="fondo"><strong>CANT.</strong></th>
                                <th align="center" class="fondo"><strong>P. UNITARIO</strong></th>
                                <th align="center" class="fondo"><strong>TOTAL</strong></th>
                            </tr>
                        </thead>
                        @foreach ($orden['actividades'] as $actividad)
                            @foreach ($actividad['equipos'] as $equipo)
                                <tr>
                                    <td width="20%" align="left"><span class="text">{{$actividad['accion']['nombre']}} {{$equipo['descripcion']}} modelo {{$equipo['modelo']}}</span></td>
                                    <td width="7%" align="center"><span class="text">{{$equipo['pivot']['cantidad'] }}</span></td>
                                    <td width="16%" align="right"><span class="text">{{ $equipo['precio']  }}</span></td>
                                    <td width="16%" align="right"><span class="text">{{ $equipo['totalEquipo'] }}</span></td>
                                </tr>
                            @endforeach
                            @foreach ($actividad['materiales'] as $material)
                                <tr>
                                    <td width="50%" align="left"><span class="text"> Instalacion {{$material['nombre']}}</span></td>
                                    <td width="7%" align="center"><span class="text">@if($material['pivot']['cantidad']) {{$material['pivot']['cantidad'] }} @else {{$material['pivot']['metros']}} Metros  @endif  </span></td>
                                    <td width="16%" align="right"><span class="text">{{$material['precio']}}</span></td>
                                    <td width="16%" align="right"><span class="text">{{ $material['totalMaterial'] }}</span></td>
                                </tr>
                            @endforeach
                        @endforeach
                        
                        <tr>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border-left:1px solid #000;; border-right:0; border-bottom:0"align="right"><strong>SUBTOTAL BS.S.</strong></td>
                            <td style="border-bottom:0; border-left:0; " align="right"><span class="text">{{ $orden['subtotal'] }}</span></td>
                        </tr>
                        <tr>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-right:0; border-top:0; border-bottom:0" align="right"><strong>IVA(16%)</strong></td>
                            <td style="border-bottom:0; border-left:0; border-top:0;"align="right"><span class="text">{{ $orden['iva'] }}</span></td>
                        </tr>
                        <tr>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border:0;">&nbsp;</td>
                            <td style="border-left:1px solid #000;; border-right:0; border-top:0;" align="right"><strong>TOTAL BS.S.</strong></td>
                            <td style="border-left:0; border-top:0;" align="right"><span class="text">{{ $orden['total'] }}</span></td>
                        </tr>
                       
                    </table>
                   
        </main>
    </body>
</html>