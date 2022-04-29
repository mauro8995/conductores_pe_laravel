<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .page-break {
            page-break-after: always;
        }
        .important{
font-size: 25px;
letter-spacing: 1.2px;
word-spacing: 2.4px;
color: #FF0000;
font-weight: 700;
text-decoration: underline solid rgb(68, 68, 68);
font-style: normal;
font-variant: normal;
text-transform: uppercase;
        }
        th {
  background-color: #4CAF50;
  color: white;
}
        </style>
</head>

<body>
    <div class="hoja">
        <div class="head">

        </div>
            <div class="body">

                <div class="contendor">

                    <div>
                        <center><h1 class="important">
                            CONFIDENCIAL
                        </h1></center>
                    </div>
                    <hr>
                    <div>
                        <h2>
                            INFORME POLICIAL
                        </h2>
                    </div>

                    <table style="width:100%">
                        <tr>
                          <th>NOMBRE</th>
                          <th>APELLIDO</th>
                          <th>DNI</th>
                        </tr>
                        <tr>
                          <td>{{($customer->last_name)}}</td>
                          <td>{{($customer->first_name)}}</td>
                          <td>{{($dni)}}</td>
                        </tr>
                      </table>
                    <p><strong>cantidad:</strong> {{count($data)}}</p>
                    <p><strong>fecha de que se genero este documento:</strong> {{date("Y-m-d H:i:s")}}</p>
                      <hr>
                      @foreach ($data as $item)
                        <div class="denuncia">
                            <h3>INFORME</h3>
                            <p><strong>TIPO: </strong>{{$item->datos->tipificacion}}</p>
                            <p><strong>SITUACION: </strong>{{$item->datos->situacion}}</p>
                            <p><strong>FECHA DE ECHO: </strong> {{$item->datos->fecha_hecho}}</p>
                            <p><strong>COMISARIA: </strong> {{$item->datos->comisaria}}</p>
                            <p><strong>ATESTADO: </strong> {{$item->atestado->result->descripcion}}</p>
                        </div>
                        <hr>
                      @endforeach


                </div>

            </div>
        <div class="footer">

        </div>
    </div>
</body>
</html>
