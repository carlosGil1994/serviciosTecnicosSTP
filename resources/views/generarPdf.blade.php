<!DOCTYPE html>
<html>
<head>
    <title>BOLETA DE VENTA</title>
    <style type="text/css">
    body{
        font-size: 16px;
        font-family: "Arial";
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
    }
    .tabla2 {
        margin-bottom: 20px;
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
    <div>
        <table width="100%" class="tabla1">
            <tr>
                <td width="73%" align="center"><img id="logo" src="{{ asset('images/logo_dmc.png') }}" alt="" width="255" height="57"></td>
                <td width="27%" rowspan="3" align="center" style="padding-right:0">
                    <table width="100%">
                        <tr>
                            <td height="50" align="center" class="border"><span class="h2">RUC: {{ $orden['id'] }}</span></td>
                        </tr>
                        <tr>
                            <td height="40" align="center" class="border fondo"><span class="h1">BOLETA DE VENTA</span></td>
                        </tr>
                        <tr>
                            <td height="50" align="center" class="border">001- Nº <span class="text">{{ $orden['id'] }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">Jr. Santander Nro. 340 Jesus María - Lima</td>
            </tr>
            <tr>
                <td align="center">Telf.: (01) 364-2547 Cel.: 985-748514</td>
            </tr>
        </table>
        <table width="100%" class="tabla2">
            <tr>
                <td width="11%">Señor (es):</td>
                <td width="37%" class="linea"><span class="text">carlos gil</span></td>
                <td width="5%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
                <td width="7%" align="center" class="border fondo"><strong>DÍA</strong></td>
                <td width="8%" align="center" class="border fondo"><strong>MES</strong></td>
                <td width="7%" align="center" class="border fondo"><strong>AÑO</strong></td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td class="linea"><span class="text">4848646</span></td>
                <td>DNI:</td>
                <td class="linea"><span class="text">123</span></td>
                <td>&nbsp;</td>
                <td align="center" class="border"><span class="text">1</span></td>
                <td align="center" class="border"><span class="text">2</span></td>
                <td align="center" class="border"><span class="text">3</span></td>
            </tr>
        </table>
        <table width="100%" class="tabla3">
            <thead>
                <tr>
                    <th align="center"  class="fondo"><strong>CANT.</strong></th>
                    <th align="center" class="fondo"><strong>ACCIÓN.</strong></th>
                    <th align="center" class="fondo"><strong>EQUIPO/MATERIAL</strong></th>
                    <th align="center" class="fondo"><strong>P. UNITARIO</strong></th>
                </tr>
            </thead>
            @foreach ($orden['actividades'] as $actividad)
                @foreach ($actividad['equipos'] as $equipo)
                    <tr>
                        <td width="7%" align="center"><span class="text">{{$equipo['pivot']['cantidad'] }}</span></td>
                        <td width="16%" align="left"><span class="text">{{$actividad['accion']['nombre']}}</span></td>
                        <td width="16%"><span class="text">{{$equipo['descripcion']}} modelo {{$equipo['modelo']}} </span></td>
                        <td width="16%" align="right"><span class="text">{{ $equipo['precio'] }}</span></td>
                    </tr>
                @endforeach
                @foreach ($actividad['materiales'] as $material)
                    <tr>
                        <td width="7%" align="center"><span class="text">@if($material['pivot']['cantidad']) {{$material['pivot']['cantidad'] }} @else {{$material['pivot']['metros']}}  @endif  </span></td>
                        <td width="16%" align="left"><span class="text">{{$actividad['accion']['nombre']}}</span></td>
                        <td width="16%"><span class="text">{{$material['nombre']}}</span></td>
                        <td width="16%" align="right"><span class="text">{{$material['precio']}}</span></td>
                    </tr>
                @endforeach
            @endforeach
            
            <tr> 
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>TOTAL S/.</strong></td>
                <td align="right"><span class="text">{{ $orden['subtotal'] }}</span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td align="center" style="border:0;">
                    <table width="200" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" class="cancelado">CANCELADO</td>
                        </tr>
                    </table>
                </td>
                <td style="border:0;">&nbsp;</td>
                <td align="center" style="border:0;" class="emisor"><strong>EMISOR</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>