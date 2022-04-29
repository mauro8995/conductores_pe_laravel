<html>
  <head>
  </head>
  <body>
    <div>
        <h3><b>Estimado Cliente,</b></h3>
        <h3><b>Sr(es). {{ $nombre." ".$apellido }}</b></h3>
        <h3><b>DNI: {{ $dni }}</b></h3>
        <br>
        <p>Ha recibido un comprobante de pago electrónico:</p>
        <p><b style="color: #1a5189;">Tipo              :</b>  Ticket</p>
        <p><b style="color: #1a5189;">Numero            :</b>  {{ $codticket }}</p>
        <p><b style="color: #1a5189;">Tipo de pago      :</b>  {{ $pay }}</p>
        <p><b style="color: #1a5189;">Fecha de emisión  :</b>  {{ $dateemi }}</p>
        <br>
        <p>Reciba un cordial saludo,</p>
        <h3>WIN TECNOLOGIES INC S.A. </h3>
        <p>20603216246</p>
        <img src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4" alt="Logotipo" style="width: 10% !important">
    </div>
  </body>
</html>
