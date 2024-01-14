<?php

    require_once "conexion.php";

    session_start();
    
    if(!isset($_SESSION['userA'])){
        header("Location: logIn.html");
    }
    else{
        $user = $_SESSION['userA'];
    }

    $sql = mysqli_query($con, "SELECT * FROM administrador WHERE correo='$user'");
    $dataA = mysqli_fetch_assoc($sql);

    $id = $_GET['id'];
    $sqlP = "SELECT * FROM licor WHERE id='".$id."'";
    $result = $con->query($sqlP);
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $precio = $row['precio'];
    $sabor = $row['sabor'];
    $cant = $row['cant_alcohol'];

    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        margin: 20px auto;
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
        <img src="img\logo.png" alt="">
        <h1>PostMortem</h1>
    </header>

    <section>
        <h2>Datos personales</h2>
            <ul> 
                <br>
                <li><span>ADMINISTRADOR:</span></li>
                <li><span>Nombre:</span> <?php echo $dataA['nombre'];?></li>
                <li><span>Correo:</span> <?php echo $dataA['correo']; ?></li>
                <li><span>CEL:</span> <?php echo $dataA['cel']; ?></li>
            </ul>
    </section>

    <table>
        <thead>
            <tr>
                <th>Datos de Compra</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Nombre del Producto:<?php echo $nombre;?></td>
            </tr>
            <tr>
                <td>Sabor:<?php echo $sabor ;?></td>
            </tr>
            <tr>
                <td>Cantidad de Alcohol:<?php echo $cant;?></td>
            </tr>
            <tr>
                <td>Subtotal: <?php echo $precio;?></td>
            </tr>
            <tr>
                <td>Total:<?php echo $precio;?></td>
            </tr>
        </tbody>
    </table>

    <section>
            <p><p>¡Usted es Administrador en Post Mortem! Cualquier duda o aclaración, comuníquese al número 33282303567.</p></p>
    </section>

    <footer></footer>
</body>
</html>

<?php
    $html = ob_get_clean();
    //echo $html;
    require_once 'C:\xampp\htdocs\postmortem\dompdf\vendor\autoload.php';

    include 'correoA.php';

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

    //$dompdf->stream("Recibo.pdf", array("Attachment" => false));
?>