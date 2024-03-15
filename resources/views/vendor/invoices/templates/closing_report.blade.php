<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de cierre</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 3px;
    }
    th {
        text-align: center;
    }
    td {
        text-align: right;
    }
</style>
<body>

    {{-- Header --}}
    @if($invoice->logo)
        <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
    @endif

    <center>
        <h2>Reporte de servicios</h2>
    </center>

    <h3><b>Proveedor</b> - {{ $invoice->buyer->provider }}</h3>
    <hr>
    <h4><b>Total gral. en metros:</b> {{ $invoice->buyer->meters }}</h4>
    <h4><b>Total gral. en pesos generado:</b> {{ number_format($invoice->buyer->total, 2) }}</h4>
    <h4><b>Balance pendiente:</b> {{ number_format($invoice->buyer->pending, 2) }}</h4>

    <table class="table" style="width:100%">
        <caption><h4>Lista de servicios realizados</h4></caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col" style="width:30%">Lugar</th>
            <th scope="col">Metros</th>
            <th scope="col">Pesos</th>
            <th scope="col">Sub total</th>
            <th scope="col">Fecha</th>
          </tr>
        </thead>
        <tbody>

          @foreach($invoice->buyer->services as $key => $value)
            <tr>
              <td style="text-align: center;">{{ $key+1 }}</td>
              <td>{{ $value["place"] }}</td>
              <td>{{ $value["meters"]." mt" }}</td>
              <td>{{ number_format($value["do"], 2) }}</td>
              <td>{{ number_format($value["total"], 2) }}</td>
              <td>{{ date('d-m-Y', strtotime($value["date"])) }}</td>
            </tr>
          @endforeach

        </tbody>
      </table>


    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
            $text = "{{ __('invoices::invoice.page') }} {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>

</body>
</html>
