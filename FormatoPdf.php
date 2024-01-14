<?php

    require_once "conexion.php";

    session_start();
    
    if(!isset($_SESSION['user'])){
        header("Location: logIn.html");
    }
    else{
        $user = $_SESSION['user'];
    }

    $sql = mysqli_query($con, "SELECT * FROM usuario WHERE correo='$user'");
    $data = mysqli_fetch_assoc($sql);

    $sqlV = mysqli_query($con, "SELECT * FROM ventas WHERE usuario='$user'");

    $Total = $_POST['total'];
    $SubTotal = $_POST['subtotal'];

    /*
    $sqlP = "SELECT * FROM ventas WHERE id='".$id."'";

    $result = $con->query($sqlP);
    $row = $result->fetch_assoc();
    */

    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="Styles/buySummaryStyle.css">!-->
    <!--<link rel="stylesheet" href="localhost/GlobalWeb/Styles/buySummaryStyle.css">!-->
    <title>Post Mortem - Detalles de Compra</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Dosis', sans-serif;
        }

        body {
        font-family: 'Arial', sans-serif;
        background-color: #000;
        color: #fff;
        margin: 0;
        padding: 0;
        }

        header {
        background-color: #000;
        color: #ffd700; /* Dorado */
        text-align: center;
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        font-family: 'Gothic', sans-serif;
        }

        section {
        background-color: #000;
        color: #fff;
        font-family: 'Gothic', sans-serif;
        padding: 20px;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
        }

        h2 {
        color: #ffd700; /* Dorado */
        border-bottom: 2px solid #ffd700; /* Línea dorada bajo el encabezado */
        padding-bottom: 10px;
        }

        ul {
        list-style-type: none;
        padding: 0;
        }

        li {
        margin-bottom: 10px;
        }

        span {
        font-weight: bold;
        }

        /* Estilo para los enlaces */
        a {
        color: #ffd700;
        text-decoration: none;
        border-bottom: 1px solid #ffd700;
        transition: border-bottom 0.3s;
        }

        a:hover {
        border-bottom: 2px solid #ffd700;
        }

        table {
        width: 80%;
        margin: 3em auto;
        border-collapse: collapse;
        }

        th, td {
        border: 1px solid #fff;
        padding: 10px;
        text-align: left;
        }

        th {
        background-color: #ffd700; /* Dorado */
        }

        tr:nth-child(even) {
        background-color: #333;
        }

        footer {
        background-color: #000;
        color: #ffd700; /* Dorado */
        text-align: center;
        padding: 20px;
        font-size: 16px;
        font-family: 'Gothic', sans-serif;
        }
    </style>
</head>
<body>
    <header>
        <!--<img src="img\logo.png" alt="">-->
        <h1>PostMortem</h1>
    </header>

    <section>
        <h2>Datos personales</h2>
            <ul>
                <br>
                <li><span>Nombre:</span> <?php echo $data['nombre'];?></li>
                <li><span>Correo:</span> <?php echo $data['correo']; ?></li>
                <li><span>Edad:</span> <?php echo $data['edad']; ?></li>
                <li><span>Ciudad:</span> <?php echo $data['ciudad']; ?></li>
                <li><span>Estado:</span> <?php echo $data['estado']; ?></li>
                <li><span>Direccion:</span> <?php echo $data['direccion']; ?></li>
                <li><span>CEL:</span> <?php echo $data['cel']; ?></li>
            </ul>
    </section>

    <?php
        $c = 1;
        while ($dataV = mysqli_fetch_assoc($sqlV)) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Datos de Compra:<?php echo $c?></th>
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <td>Nombre del Producto:<?php echo $dataV['nombre_p'];?></td>
                    </tr>
                    <tr>
                        <td>Sabor:<?php echo $dataV['sabor'];?></td>
                    </tr>
                    <tr>
                        <td>Cantidad de Alcohol:<?php echo $dataV['cant_alcohol'];?></td>
                    </tr>
                    <tr>
                        <td>Precio: MXN $<?php echo $dataV['precio'];?></td>
                    </tr>
                </tbody>
            
        </table>
    <?php $c++; } ?>

    <table>
        <thead>
            <tr>
                <th>PAGO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Subtotal: MXN $<?php echo $SubTotal;?></td>
            </tr>
            <tr>
                <td>Total:MXN $<?php echo $Total;?></td>
            </tr>
        </tbody>

    </table>

    <section>
            <p><p>¡Gracias por comprar en Post Mortem! Cualquier duda o aclaración, comuníquese al número 33282303567.</p></p>
    </section>

    <footer></footer>
</body>
</html>

<?php
    $html = ob_get_clean();
    //echo $html;
    require_once 'C:\xampp\htdocs\postmortem\dompdf\vendor\autoload.php';

    include 'correo.php';

    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnable' => true));

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $pdfsalida = $dompdf->output();
    $pdfnombre = 'Recibo.pdf';
    file_put_contents($pdfnombre, $pdfsalida);
    
    mandar_correo($pdfnombre);

    header('Location: productos.php');

    //$dompdf->stream("Recibo.pdf", array("Attachment" => false));
?>