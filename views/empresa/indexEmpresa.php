<?php

    session_start();
    require_once "../../config/conexion.php";
    if(!isset($_SESSION['empresa'])){
        header('Location: ../../index.php');
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
    <title>Postúlate al empleo</title>
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root{
            --primario: rgb(105, 183, 185);
            --secundario: #f5f2f2;
            --gris: #B8B8B8;
            --blanco: #FFFFFF;
            --negro: #000000;

            --FuentePpal: 'Dancing Script', cursive;
        }
        .caja{
            display: flex;
            flex-direction: row;
        }

        .caja-izquierda{
            background-color: #69b7b9;
            height: 100vh;
            width: 25%;
        }
        .caja-izquierda .caja-izquierda-uno{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .caja-izquierda .caja-izquierda-uno h1{
            color: var(--blanco);
            font-family: var(--FuentePpal);
            font-size: 4rem;
            font-weight: bold;
            margin: 10px;
        }
        .caja-izquierda img{
            border-radius:50%;
            margin: 10px;
            width: 70%;
        }
        .caja-izquierda div.caja-izquierda-uno h2{
            color: var(--blanco);
            font-family:Verdana, Geneva, Tahoma, sans-serif ;
            margin-top: 3rem;
        }
        .caja .caja-izquierda .caja-izquierda-dos{
            height: 5rem;
            margin-top: 5rem;


            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
        }
        .caja .caja-izquierda .caja-izquierda-dos a {
            color: var(--blanco);
            text-decoration: none;

        }
        .caja .caja-izquierda .caja-izquierda-dos .caja-izquierda-dos-a{
            display: flex;
            flex-direction: column;

            font-family:Arial, Helvetica, sans-serif;
            font-size: 2rem;
            
        }
        .caja .caja-izquierda .caja-izquierda-dos .caja-izquierda-dos-a a{
            margin: .4rem;
        }
        .caja .caja-izquierda .caja-izquierda-dos .caja-izquierda-dos-aa {
            display: flex;
            flex-direction: column;
            align-items: center;

            margin-top:5rem;
        }
        .caja .caja-izquierda .caja-izquierda-dos .caja-izquierda-dos-aa a{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2rem;
            margin-top:.4rem;
        }

        .caja .caja-derecha{
            width: 75%;

            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
        }

        .caja .caja-derecha .caja-derecha-details h1{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 4.5rem;
        }
        .caja .caja-derecha .caja-derecha-details p{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2rem;
            margin: 2rem;
        }
    </style>
</head>
<body>
    <div class="caja">
        <div class="caja-izquierda">
            <div class="caja-izquierda-uno">
                <h1>SearchJob</h1>
                <?php

                    if(is_null($_SESSION['empresa']->imagen)){
                        $url_imagen = "../../uploads/usuarios_perfil/usuario.png";
                    }else{
                        $url_imagen = "../../uploads/usuarios_perfil/".$_SESSION['empresa']->imagen;
                    }

                ?>
                <img src="<?=$url_imagen?>" alt="">
                <h2><?=$_SESSION['empresa']->nombre ?></h2>
            </div>
            <div class="caja-izquierda-dos">
                <div class="caja-izquierda-dos-a"> 
                    <form action="postulados.php" method="post">
                        <input type="hidden" value="<?=$_SESSION['empresa']->id ?>" name="empresa">
                        <input type="submit" value="Postulados"><span class="icon-paste"></span> 
                    </form>
                    <a href="registrarEmpleo.php"> Publicar Empleo  <span class="icon-folder-upload"></span></a>
                    <a href="empleosPublicados.php"> Empleos Publicados  <span class="icon-folder-upload"></span></a>
                </div>
                <div class="caja-izquierda-dos-aa">
                    <a href="#">Datos Personales <span class="icon-address-book"></span></a>   
                    <a href="../../execute.php?controller=empresa&action=logout">Cerrar Sesión <span class="icon-exit"></span></a>   
                </div>    
            </div>
        </div>
        <div class="caja-derecha">
            <div class="caja-derecha-details">
                <h1>Bienvenido <?=$_SESSION['empresa']->nombre ?></h1>
                <p>En esta sesión podrás encontrar varias funcionalidades que te harán los procesos mucho mas cortos y cómodos, navega y esperamos
                    que sea de tu gusto</p>
            </div>
        </div>
    </div>
    
</body>
</html>