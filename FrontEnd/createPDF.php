<?php ob_start();?>
<?php
include('../FrontEnd/SendEmail.php');
require_once '../vendor/autoload.php';

//Primer nivel: CUENTAHABIENTES >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function GenerateReports($conn){
    $stylesheet = file_get_contents('../CSS/style.css');
    $cuentaHabientesQuery= "EXEC [dbo].[FILTRAR_CUENTAHABIENTES]";
    $cuentaHabientesResult=sqlsrv_query($conn, $cuentaHabientesQuery);

    while($fila = sqlsrv_fetch_array($cuentaHabientesResult)){
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $nombre = $fila['NOMBRES'];
        $apellido = $fila['APELLIDOS'];
        $documento = $fila['DOCUMENTO'];
        $email = $fila['CORREO'];


        $mpdf->WriteHTML('<h1 style="color:red">Histórico de Movimientos</h1>');

        $mpdf->WriteHTML('<div style="margin-left:20px" align = "left">
            <b>Nombre:</b>'.$nombre.'<br>
            <b>Apellido:</b>'.$apellido.'<br>
            <b>Documento:</b>'.$documento.'<br>
            <b>Correo:</b>'.$email.'<br>');

        $mpdf->WriteHTML('_______________________________________________________________________________________________________<br><br>');

    //Segundo nivel: CUENTAS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            $cuentasQuery = "EXEC [dbo].[CUENTAHABIENTE]
            @DOCUMENTO = N'$documento'";
            $cuentasResult=sqlsrv_query($conn, $cuentasQuery);

            while($fila = sqlsrv_fetch_array($cuentasResult)){ 
                $NUM_CUENTA = $fila['NUM_CUENTA'];
                $TIPO_CUENTA = $fila['TIPO_CUENTA'];
                $SALDO = $fila['SALDO'];
                
                $mpdf->WriteHTML('<div style="margin-left:20px" align = "left">
                    <b>Numero de Cuenta:</b>'.$NUM_CUENTA.'<br>
                    <b>Tipo de Cuenta:</b>'.$TIPO_CUENTA.'<br>
                    <b>Saldo Actual:</b>'.$SALDO.'<br>');
    //Tercer nivel: Movimientos >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

                $mpdf->WriteHTML('
                <table class="blueTable">
                <thead>
                <tr align="center">
                    <th width="100" align="center">Fecha</th>
                    <th width="150" align="center">Tipo de Transacción</th>
                    <th width="100" align="center">Valor</th>
                    <th width="150" align="center">Cuenta de Movimiento</th>
                    <th width="150" align="center">Cuenta Destino</th>
                    <th width="300" align="center">Descripción</th>
                </tr>
                </thead>
                <tbody>');

                $transactionsQuery = "EXEC	[dbo].[PA_TRANSACTIONS_HISTORY]
                @N_CUENTA = N'$NUM_CUENTA'";

                $transactionsResult=sqlsrv_query($conn, $transactionsQuery);

                    while($fila = sqlsrv_fetch_array($transactionsResult)){ 
                        $FECHA = $fila['FECHA'];
                        $TIPO_TRANSACCION = $fila['TIPO_TRANSACCION'];
                        $VALOR = $fila['VALOR'];
                        $DESCRIPCION = $fila['DESCRIPCION'];
                        $CUENTA_ORIGEN = $fila['CUENTA_ORIGEN'];
                        $CUENTA_DESTINO = $fila['CUENTA_DESTINO'];

                        $stringDate = $FECHA->format('Y-m-d H:i:s');

                        $mpdf->WriteHTML(
                            '<tr align="center">
                            <td align="center">'.$stringDate.'</td>
                            <td align="center">'.$TIPO_TRANSACCION.'</td>
                            <td align="center">'.$VALOR.'</td>
                            <td align="center">'.$CUENTA_ORIGEN.'</td>
                            <td align="center">'.$CUENTA_DESTINO.'</td>
                            <td align="center">'.$DESCRIPCION.'</td>
                            </tr>'
                        
                        );
                    }
                $mpdf->WriteHTML(
                '</tbody>
            </table>
        </div>
    </div>');
            $mpdf->WriteHTML('_______________________________________________________________________________________________________<br><br>');
            
            
            
        }
        sendEmail($mpdf,$email);
            // $mpdf->Output();
    }
}
?>
<?php ob_end_flush(); ?>

