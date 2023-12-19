<!DOCTYPE html>
<html>

<head>
  <style>
    th.titulo {
      /*
      border-top: 1px solid black;
      border-collapse: collapse;
      */
      border-bottom: 1px solid black;
      height: 4mm;
      /*margin: 0 auto;*/
    }

    td {
      text-align: center;
      vertical-align: middle;
      height: 10px;
    }

    .logo {
      width: 35mm;
    }

    th.precio,
    td.precio {
      text-align: right;
      font-size: 7px;
      padding: 0px;
      align-content: center;
      height: 10px;
    }

    .linea-top {
      border-top: 0.5px solid black;
      border-collapse: collapse;
      vertical-align: middle;
      align-content: center;
    }

    .linea-bottom {
      border-bottom: 0.5px solid black;
      border-collapse: collapse;
      vertical-align: middle;
      align-content: center;
    }

    th.producto,
    td.producto {
      text-align: left;
      font-size: 7px;
      align-content: center;
      padding: 0px;
      height: 10px;
    }

    .bold {
      font-weight: bold;
    }

    td.cantidad {
      text-align: center;
      font-size: 7px;
      align-content: center;
      padding: 0px;
      height: 10px;
    }

    .centrado {
      text-align: center;
      align-content: center;
    }

    .derecha {
      text-align: right;
      align-content: center;
    }
  </style>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th style="text-align:center;">
          <img src="{{$logo}}" alt="Logo" class="logo" />
        </th>
      </tr>
      <tr>
        <th style="text-align:center; font-size:7px; height: 10mm;">RFC: {{$datos_empresa[0]->value}}
          <br>{{$datos_empresa[1]->value}}
          <br>{{$datos_empresa[2]->value}}
          <br><b style="font-size: 7pt;">Abonos del ticket<br>{{$codigo}}</b><br>
        </th>
      </tr>
    </thead>
  </table>

  <table>
    <tbody>
      <tr>
        <td style="height: 10mm; text-align: left">
          <br><b>Cliente:</b> {{$cliente}}
          <br><b>Vendedor:</b> {{$vendedor}}
          <br><b>Total compra:</b> {{number_format($venta_total, 2)}}
          <br><b>Total abonado:</b> {{number_format($total_pagos, 2)}}
          <br><b>Resta por pagar:</b> {{number_format($venta_total - $total_pagos, 2)}}
        </td>
      </tr>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th colspan="4"></th>
      </tr>
      <tr>
        <th colspan="4" style="font-weight: bold;">
          RELACIÓN DE PAGOS<br>
        </th>
      </tr>
      <tr class="centrado">
        <th style="width: 18mm" class="bold titulo">TIPO PAGO</th>
        <th style="width: 20mm" class="bold titulo">METODO PAGO</th>
        <th style="width: 15mm" class="bold titulo">IMPORTE</th>
        <th style="width: 15mm" class="bold titulo">FECHA</th>
      </tr>
    </thead>
    <tbody>
      <tr style="height: 1mm;">
        <th colspan="4" style="height: 1mm;"></th>
      </tr>
      @if(count($relacion_pagos) > 0)
      @foreach ($relacion_pagos as $detalle)
      <tr class="centrado">
        <td style="width: 18mm;">{{ $detalle->tipo_pago }}</td>
        <td style="width: 20mm;">{{ $detalle->metodo_pago }}</td>
        <td style="width: 15mm;">{{ number_format( ($detalle->monto_tarjeta + $detalle->monto_efectivo),2)}}</td>
        <td style="width: 15mm;">{{ $detalle->created_at }}</td>
      </tr>
      @endforeach
      @else
      <tr>
        <th colspan="4" class="titulo centrado">Sin pagos registrados<br></th>
      </tr>
      @endif
      <tr>
        <th colspan="4"></th>
      </tr>
    </tbody>
  </table>
  <strong class="centrado">¡GRACIAS POR TU PREFERENCIA!</strong>
</html>