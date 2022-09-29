<?php

    class CalificacionModel{

        //Campos que se usarán en esta clase 
        private $codigo;
        private $usuario;
        private $calificacion;
        private $descripcion;
        private $fecha;
        private $db;

        //Constructor que hará uso de la conexion a la base de datos
        public function __construct()
        {
            $this->db = Conexion::connection();
        }

        //Get y set para codigo
        public function getCodigo(){
            return $this->codigo;
        }

        public function setCodigo($codigo){
            $this->codigo = $codigo;
        }

        //Get y set para usuario
        public function getUsuario(){
            return $this->usuario;
        }

        public function setUsuario($usuario){
            $this->usuario = $usuario;
        }

        //Get y set para calificacion
        public function getCalificacion(){
            return $this->calificacion;
        }

        public function setCalificacion($calificacion){
            $this->calificacion = $calificacion;
        }

        //Get y set para descripcion
        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        //Get y set para fecha
        public function getFecha(){
            return $this->fecha;
        }

        public function setFecha($fecha){
            $this->fecha = $fecha;
        }

        //Funciones para consultar a la base de datos
        //Conseguir todas las calificaciones
        public function conseguirCalificaciones(){
            //Consulta para sacar todos los registros
            $sql = "SELECT ca.*, us.nombre as 'nombre_usuario', us.apellido FROM calificacion as ca
            INNER JOIN usuario as us
            ON ca.usuario = us.id
            ORDER BY ca.codigo DESC";
            $calificacion = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($calificacion){
                //Almacenar los datos en la variable a retornar
                $validar = $calificacion;
            }
            //Retorno del resultado
            return $validar;

        }
        //Conseguir las calificaciones de un usuario en concreto
        public function conseguirCalificacionesUsuario(){
            //Consulta para sacar todos los registros según el usuario
            $sql = "SELECT ca.*, us.nombre as 'nombre_usuario', us.apellido, us.id FROM calificacion as ca
            INNER JOIN usuario as us
            ON ca.usuario = us.id
            WHERE us.id = '{$this->getUsuario()}'
            ORDER BY ca.codigo DESC";
            $calificacion = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($calificacion){
                //Almacenar los datos en la variable a retornar
                $validar = $calificacion;
            }
            //Retorno del resultado
            return $validar;

        }
        //Guardar una calificación
        public function guardarCalificacion(){

            $sql = "INSERT INTO calificacion VALUES(NULL,'{$this->getUsuario()}',{$this->getCalificacion()},
            '{$this->getDescripcion()}',NOW())";
            $guardar = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($guardar){
                //Almacenar true en la variable a retornar
                $validar = true;
            }
            //Retorno del resultado
            return $validar;

        }
        //eliminar una calificación
        public function eliminarCalificacion(){

            $sql = "DELETE FROM calificacion WHERE codigo = {$this->getCodigo()}";
            $borrar = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($borrar){
                //Almacenar true en la variable a retornar
                $validar = true;
            }
            //Retorno del resultado
            return $validar;

        }

    }