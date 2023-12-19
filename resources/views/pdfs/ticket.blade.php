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
          <br><b style="font-size: 7pt;">{{ $tipo_documento }}<br>{{$codigo}}</b><br>
        </th>
      </tr>
    </thead>
  </table>

  <table>
    <tbody>
      <tr>
        <td style="height: 10mm; text-align: left">
          <br>Fecha compra: {{$creado}}
          <br>Fecha impresion: {{$hoy}}
          <br>Cliente: {{$cliente}}
          <br>Vendedor: {{$vendedor}}
          @if(isset($tipo_pago) && !empty($tipo_pago))
          <br>Tipo venta: {{ ucfirst(mb_strtolower(($tipo_pago == 'ABONO') ? 'A DOMICILIO' : $tipo_pago)) }}
          @endif
          @if(isset($metodo_pago) && !empty($metodo_pago))
          <br>Metodo de pago: {{ ucfirst(mb_strtolower($metodo_pago)) }}
          @endif
        </td>
      </tr>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th colspan="4"></th>
      </tr>
      <tr class="centrado">
        <th style="width: 12mm" class="bold cantidad titulo">CANT</th>
        <th style="width: 26mm" class="bold producto titulo">PRODUCTO</th>
        <th style="width: 15mm" class="bold precio titulo">P/U</th>
        <th style="width: 15mm" class="bold precio titulo">TOTAL</th>
      </tr>
    </thead>
    <tbody>
      <tr style="height: 1mm;">
        <th colspan="4" style="height: 1mm;"></th>
      </tr>
      @foreach ($detalle_venta as $detalle)
      <tr class="centrado">
        <td style="width: 12mm" class="cantidad">{{ number_format( $detalle->cantidad,2)}}</td>
        <td style="width: 26mm" class="producto">{{ $detalle->producto->nombre}}</td>
        <td style="width: 15mm" class="precio">
          {{ number_format($detalle->precio,2)}}
        </td>
        <td style="width: 15mm" class="precio">
          {{ number_format( $detalle->total,2)}}
        </td>
      </tr>
      @endforeach
      @if($venta_descuento)
      <tr>
        <td class="derecha" colspan="3">
          <strong>NETO</strong>
        </td>
        <td class="precio">
          {{ number_format( $venta_neto,2)}}
        </td>
      </tr>
      @endif
      @if($venta_descuento)
      <tr>
        <td class="derecha" colspan="3">
          <strong>DESCUENTO</strong>
        </td>
        <td class="derecha">
          {{ number_format( $venta_descuento,2)}}
        </td>
      </tr>
      @endif
      <tr>
        <td class="derecha" colspan="3">
          <strong>TOTAL</strong>
        </td>
        <td class="precio">
          {{ number_format( $venta_total,2)}}
        </td>
      </tr>
      @if($metodo_pago_id==1)
      <tr class="centrado">
        <td class="derecha" colspan="3">
          <strong>EFECTIVO</strong>
        </td>
        <td class="precio">
          {{ number_format( $monto_efectivo,2)}}
        </td>
      </tr>
      @endif
      @if($metodo_pago_id==2)
      <tr class="centrado">
        <td class="derecha" colspan="3">
          <strong>TARJETA </strong>
        </td>
        <td class="precio">
          {{ number_format( $monto_tarjeta,2)}}
        </td>
      </tr>
      @endif
      @if($metodo_pago_id==3)
      <tr class="centrado">
        <td class="derecha" colspan="3">
          <strong>EFECTIVO</strong>
        </td>
        <td class="precio">
          {{ number_format( $monto_efectivo,2)}}
        </td>
      </tr>
      <tr class="centrado">
        <td class="derecha" colspan="3">
          <strong>TARJETA </strong>
        </td>
        <td class="precio">
          {{ number_format( $monto_tarjeta,2)}}
        </td>
      </tr>
      @endif
      @if($saldo < 0) <tr>
        <td class="derecha" colspan="3">
          <strong>CAMBIO</strong>
        </td>
        <td class="precio">
          {{ number_format( abs($saldo), 2)}}
        </td>
        </tr>
        @endif
        @if($tipo_pago)
        @if($tipo_pago=='ABONO' || $saldo > 0)
        <tr>
          <td class="derecha" colspan="3">
            <strong>SALDO</strong>
          </td>
          <td class="precio">
            {{ number_format( $saldo,2)}}
          </td>
        </tr>
        @endif
        @endif
        <tr>
          <td class="precio" colspan="4" style="text-align: left;">
            <br><strong>Son:</strong> {{$total_literal}} pesos
          </td>
        </tr>
        <tr>
          <td></td>
        </tr>
    </tbody>
  </table>

  <strong class="centrado">¡GRACIAS POR SU COMPRA!</strong>

</html>