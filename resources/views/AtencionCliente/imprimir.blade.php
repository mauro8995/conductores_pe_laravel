

      <p style="position: absolute; left: 100px; top: 120px; font-size: 15px; font-family: arial !important;">{{ strtoupper($idticket)}}</p>
      <p style="position: absolute; left: 60px; top: 130px; font-size: 15px; font-family: arial !important;  font-weight: bold;">{{ strtoupper($area)}}</p>
      <p style="position: absolute; left: 5px; top: 150px; font-size: 15px; font-family: arial !important;">{{ strtoupper($cliente)}}</p>
      <p style="position: absolute; left: 70px; top: 170px; font-size: 15px; font-family: arial !important;">{{ strtoupper($fecha)}}</p>

      <?php
            $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
            $base64 = 'data:image/png;base64,' . base64_encode($data);
        ?>
    <img src="{{$base64}}" alt="Logotipo">
