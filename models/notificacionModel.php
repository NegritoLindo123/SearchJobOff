<?php

    class NotificacionModel{
        //Campos que se usan en la clase
        private $codigo;
        private $usuario;
        private $asunto;
        private $cuerpo;
        private $fecha;
        private $fecha_final;
        private $estado;
        private $empresa;
        //Variable que hace uso de la conexión a la base de datos
        private $db;

        //Constructor que hace uso de la conexión a la base de datos
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

        //Get y set para asunto
        public function getAsunto(){
            return $this->asunto;
        }

        public function setAsunto($asunto){
            $this->asunto = $asunto;
        }

        //Get y set para cuerpo
        public function getCuerpo(){
            return $this->cuerpo;
        }

        public function setCuerpo($cuerpo){
            $this->cuerpo = $cuerpo;
        }

        //Get y set para fecha
        public function getFecha(){
            return $this->fecha;
        }

        public function setFecha($fecha){
            $this->fecha = $fecha;
        }

        //Get y set para fecha_final
        public function getFechaFinal(){
            return $this->fecha_final;
        }

        public function setFechaFinal($fecha_final){
            $this->fecha_final = $fecha_final;
        }

        //Get y set para estado
        public function getEstado(){
            return $this->estado;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }

        //Get y set para empresa
        public function getEmpresa(){
            return $this->empresa;
        }

        public function setEmpresa($empresa){
            $this->empresa = $empresa;
        }

        //Funciones para consultar a la base de datos
        //Conseguir todas las notificaciones
        public function conseguirNotificaciones(){
            //Consulta para sacar todos los registros
            $sql = "SELECT no.*, us.id , us.nombre as 'nombre_usuario', us.apellido 
            FROM notificacion as no 
            INNER JOIN usuario as us 
            ON no.usuario = us.id
            ORDER BY no.codigo DESC";
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
        //Conseguir todas las notificaciones de un usuario
        public function conseguirNotificacionesUsuario(){
            //Consulta para sacar todos los registros
            $sql = "SELECT no.*, us.id, us.nombre as 'nombre_usuario', us.apellido 
            FROM notificacion as no 
            INNER JOIN usuario as us 
            ON no.usuario = us.id 
            WHERE us.id = '{$this->getUsuario()}'
            ORDER BY no.codigo DESC";
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
        //Marcar como leída una notificación
        public function marcarLeido(){
            //Consulta que elimina el registro de un empleo correspondiente
            $sql = "UPDATE notificacion SET estado = 'leida' WHERE codigo = {$this->getCodigo()}";
            $cambiar = $this->db->query($sql);
            //Variable a retornar
            $cambiada = false;
            //En caso de que funcione asignar un true a la variable a retornar
            if($cambiar){
                $cambiada = true;
            }
            //Retornar la variable
            return $cambiada;

        }
        //Conseguir las notificaciones según el estado
        public function reporteNotificacionesEstado(){
            //Consulta para sacar todos los registros según el estado
            $sql = "SELECT no.*, us.id, us.nombre FROM notificacion as no 
            INNER JOIN usuario as us 
            ON no.usuario = us.id
            WHERE no.estado = '{$this->getEstado()}'";
            $notificacion = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($notificacion){
                //Almacenar los datos en la variable a retornar
                $validar = $notificacion;
            }
            //Retorno del resultado
            return $validar;

        }
        //Conseguir las notificaciones según la fecha inicial y final
        public function reporteNotificacionesFecha(){
            //Consulta para sacar todos los registros según las fechas
            $sql = "SELECT no.*, us.id, us.nombre FROM notificacion as no 
            INNER JOIN usuario as us 
            ON no.usuario = us.id
            WHERE no.fecha BETWEEN '{$this->getFecha()}' AND '{$this->getFechaFinal()}'";
            $notificacion = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($notificacion){
                //Almacenar los datos en la variable a retornar
                $validar = $notificacion;
            }
            //Retorno del resultado
            return $validar;

        }
        //Guardar una notificación
        public function guardarNotificacion(){
            //Consulta para guardar la notificación
            $sql = "INSERT INTO notificacion 
            VALUES(null,'{$this->getUsuario()}','{$this->getAsunto()}',
            '{$this->getCuerpo()}',NOW(),'no leida')";
            $notificacion = $this->db->query($sql);

            $validar = false;
            //Si la consulta ejecutó
            if($notificacion){
                //Almacenar los datos en la variable a retornar
                $validar = $notificacion;
            }
            //Retorno del resultado
            return $validar;

        }
        //Validar si una empresa ya está reportada
        public function validarReporte(){
            //Consulta para traer los datos
            $sql = "SELECT * FROM notificacion WHERE usuario = '{$this->getUsuario()}'";
            $cambiar = $this->db->query($sql);
            //Variable a retornar
            $cambiada = false;
            //En caso de que funcione asignar un true a la variable a retornar
            if($cambiar && $cambiar->num_rows >= 1){
                $cambiada = true;
            }
            //Retornar la variable
            return $cambiada;

        }

        //Eliminar una notificación
        public function eliminarNotificacion(){
            //Consulta para traer los datos
            $sql = "DELETE FROM notificacion WHERE codigo = {$this->getCodigo()}";
            $eliminar = $this->db->query($sql);
            //Variable a retornar
            $eliminada = false;
            //En caso de que funcione asignar un true a la variable a retornar
            if($eliminar){
                $eliminada = true;
            }
            //Retornar la variable
            return $eliminada;

        }
        //Eliminar un reporte
        public function eliminarReporte(){
            //Consulta para traer los datos
            $sql = "DELETE FROM notificacion WHERE usuario = '{$this->getUsuario()}' AND asunto = 'reporte'";
            $eliminar = $this->db->query($sql);
            //Variable a retornar
            $eliminada = false;
            //En caso de que funcione asignar un true a la variable a retornar
            if($eliminar){
                $eliminada = true;
            }
            //Retornar la variable
            return $eliminada;

        }

    }