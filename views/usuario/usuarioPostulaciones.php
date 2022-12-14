<?php 
    session_start();
    require_once "../../config/conexion.php";
    require_once "../../helpers/utils.php";
    require_once "../../autoload.php";
    if(!isset($_SESSION['empleado'])){
        header("Location: ../../index.php");
    }

?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Mouse+Memoirs&family=Roboto&family=Source+Code+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/icons/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>Mis Postulaciones</title>
    <style>

        :root{
            --primario: rgb(105, 183, 185);
            --secundario: #f5f2f2;
            --gris: #B8B8B8;
            --blanco: #FFFFFF;
            --negro: #000000;

            --FuentePpal: 'Dancing Script', cursive;
        }

        body{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container-postulados{
            width: 100%;
        }

        .container-postulados .details {
            margin: 2rem auto;
            text-align: center;
            width: 95%;
        }

        .container-postulados .details table{
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
            margin: 2rem auto;
        }

        .container-postulados .details table tr td, th{
            border: 1px solid #000;
            border-collapse: collapse;
            caption-side: bottom;
            padding: 0.5rem;
            text-align: left;
            vertical-align: top;
        }

        .container-postulados .details table tr th{
            background: var(--primario);
            border: none;
            color: #fff;
            letter-spacing:1px;
            padding: 1rem;
            text-align: center;
        }

        .container-postulados .details table tr td{ 
            align-items:center;
            border: none;
            justify-content:center;
            padding:1rem 1rem;
            text-align:center;
        }

        .container-postulados .details table tr td a.eliminar{
            background: var(--primario);
            border-radius:5px;
            color: #fff;
            letter-spacing:1px;
            padding: 0.6rem;
            text-decoration:none;
        }

        .postular {
            background: var(--primario);
            border-radius:5px;
            color: #fff;
            font-weight:bold;
            letter-spacing:2px;
            margin: 2rem;
            padding: 0.6rem 1.5rem;
            text-decoration:none;
        }

        .empleo {
            border-radius:5px;
            color: #000;
            letter-spacing:1px;
            font-weight: bold;
            padding: 0.6rem;
            text-decoration:none;
        }

        .container-postulados .details .pdf{
            background: red;
            border-radius:5px;
            color: #fff;
            font-weight:bold;
            letter-spacing:2px;
            margin: 1rem;
            padding: 0.6rem 1.5rem;
            text-decoration:none;
        }

        .aviso{
            background: rgba(235, 40, 40, 1);
            border-radius: 4px;
            color: #fff;
            display: block;
            margin: 1rem;
            padding: 0.5rem;
        }

        .icono-volver {
            background: var(--primario);
            border-radius: 50%;
            color: var(--blanco);
            padding: 1rem;
            position: absolute;
            left: 1rem;
            text-decoration: none;
            top: 1rem;
        }

    </style>
</head>
<body>
    
    <div class="container-postulados">
        <a href="indexUsuario.php" class="icono-volver"><span class="icon-undo2"></span></a>
        <div class="details">
            <?php 
                //Instancia que trae todas las postulaciones de un usuario
                $postulaciones = new PostulacionDosController();
                $post = $postulaciones->obtenerPostulaciones();
        
            ?>
            <h2>Tus Postulaciones</h2>
            <!-----Condici??n que evalua si existe una sesi??n de fallo o exito-------->
            <?php   if(isset($_SESSION['complete']) && $_SESSION['complete'] == 'Complete'): ?>
                        
                        <strong>Postulaci??n borrada de forma exitosa</strong>
                
            <?php   elseif(isset($_SESSION['fail']) && $_SESSION['fail'] == 'Fail'):  ?>

                        <strong>Error al intentar borrar la postulaci??n</strong>

            <?php   endif; ?>
            <p>
                Hola de nuevo <b><?=$_SESSION['empleado']->nombre?> <?=$_SESSION['empleado']->apellido?></b>!,
                en esta sesi??n puedes encontrar todas las postulaciones que has realizado, adem??s de
                poder ver toda la informaci??n del empleo al que te postulaste solo dando click
                sobre su nombre. Puedes tambi??n eliminar tu postulaci??n al mismo por X o Y motivo.
            </p>
            <span class="aviso">
                <span class="icon-notification"></span> 
                Si en alg??n momento notas que desapareci?? alguna postulaci??n que tu hayas 
                realizado, es debido a que fuiste rechazado
            </span>
            <table  cellspacing="0" cellpadding="0" >
                <tr>
                    <th>Nombre Empleo</th>
                    <th>Funci??n</th>
                    <th>Vacantes</th>
                    <th>Descripci??n</th>
                    <th>Estado de la postulaci??n</th>
                    <th>Fecha</th>
                    <th>Eliminar</th>
                </tr>
                <!-----condicion que valida que exista almenos un registro-------->
                <?php if($post->num_rows >= 1): ?>
                <!-----ciclo que muestra todos los datos de la postulaci??n-------->
                    <?php while($postulaciones = $post->fetch_object()): ?>
                <tr>
                    <td>
                        <a href="../empleo/verEmpleo.php?id=<?=$postulaciones->codigo?>&aut=tgfgdh&ret=1" class="empleo"><?=$postulaciones->nombre ?></a>
                    </td>
                    <td><?=$postulaciones->funcion ?></td>
                    <td><?=$postulaciones->vacantes ?></td>
                    <!-----Cortar la descripcion a 80 caracteres maximo-------->
                    <td><?php echo substr($postulaciones->descripcion,0,80)."..."; ?></td>
                    <td><?=$postulaciones->estado ?></td>
                    <td><?=$postulaciones->fecha ?></td>
                    <td>
                    <!-----Link para eliminar una postulaci??n-------->
                    <a href="../../execute.php?controller=postulacion&action=eliminarPostulacion&usuario=<?=$_SESSION['empleado']->id ?>&empleo=<?=$postulaciones->codigo ?>" onclick="return ConfirmDelete()" class="eliminar">Eliminar</a>
                    </td>
                </tr>
                    <?php endwhile; ?>
                <!-----En caso de que el usuario no tenga ninguna postulaci??n-------->
                <?php else: ?>
                    <p>A??n no te has postulado a ning??n empleo!</p>
                    <a href="empleosBuscar.php" class="postular">Hazlo Ahora!</a>
                <?php endif; ?>
            </table>
            <!---Verificar que hayan registros para generar el PDF-->
            <?php if($post->num_rows >= 1 && isset($_POST)): ?>
                <a href="generarPdfPostulaciones.php" class="pdf" target="_blank">Generar Reporte</a>
            <?php endif; ?>
            <!-----funciones para borrar las sesiones existentes-------->
            <?php borrarSesion('complete'); borrarSesion('fail'); ?>
        </div>
    </div>
    <!-- Scrip que confirma la eliminaci??n del empleo-->
    <script type="text/javascript">
        function ConfirmDelete()
        {
            var respuesta = confirm("??Est?? seguro que desea eliminar este empleo?");

            if (respuesta == true){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</body>
</html>