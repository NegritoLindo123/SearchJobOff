<?php

    require_once "../../models/usuarioModel.php";
    require_once "../../models/postulacionModel.php";
    require_once "../../models/calificacionModel.php";
    require_once "../../models/empleoModel.php";

    class UsuarioDosController{

        //Cantidad de usuarios registrados
        public function contarUsuarios(){

            if(isset($_SESSION['admin'])){

                $contar = new UsuarioModel();
                $contado = $contar->contarUsuarios();

                return $contado;

            }

        }

    }