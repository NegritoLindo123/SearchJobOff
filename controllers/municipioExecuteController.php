<?php

    //Se usa el modelo de municipio
    require_once "models/municipioModel.php";
    //Se usa el modelo de empleo
    require_once "models/empleoModel.php";
    //Se usa el modelo de postulacion
    require_once "models/postulacionModel.php";

    class municipioExecuteController{

        //Función para mostrar los registros de la tabla municipio
        public function mostrarMunicipios(){

            $municipio = new MunicipioModel();
            //Sacar todos los datos
            $municipios = $municipio->mostrarMunicipios();
            //Retorno de dichos datos
            return $municipios;

        }
        //Guardar un municipio
        public function guardarMunicipio(){
            //Verificar que exista el metodo post y la sesión del admin
            if(isset($_POST) && isset($_SESSION['admin'])){

                $municipio = (int)$_POST['codigo'];
                $nombre = $_POST['nombre'];
                $departamento = (int)$_POST['departamento'];

                $errores = array();

                //Validación para municipio
                if(!empty($municipio) && is_numeric($municipio) && preg_match("/[0-9]/",$municipio)){
                    $municipio_validado = true;
                }else{
                    $municipio_validado = false;
                    $errores['municipio'] = "Solo se permiten números";
                }

                //Validación para nombre
                if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/",$nombre)){
                    $nombre_validado = true;
                }else{
                    $nombre_validado = false;
                    $errores['nombre'] = "No se permiten numeros";
                }

                //Validación para departamento
                if(!empty($departamento) && is_numeric($departamento) && preg_match("/[0-9]/",$departamento)){
                    $departamento_validado = true;
                }else{
                    $departamento_validado = false;
                    $errores['departamento'] = "Solo se permiten números";
                }

                var_dump($errores);

                if(count($errores) == 0){

                    $guardar = new MunicipioModel();
                    $guardar->setCodigo($municipio);
                    $guardar->setNombre($nombre);
                    $guardar->setDepartamento($departamento);
                    $guardado = $guardar->guardarMunicipio();

                    if($guardado){
                        $_SESSION['complete'] = "Complete";
                        header("Location: views/municipios/registrarMunicipio.php");
                    }else{
                        $_SESSION['fail'] = "Fail";
                        header("Location: views/municipios/registrarMunicipio.php");
                    }

                }else{
                    //En caso de que hallan errores, se crea una sesión para
                    //imprimir todos los errores
                    $_SESSION['errores'] = $errores;
                    header("Location: views/municipios/registrarMunicipio.php");
                }

            }else{
                $_SESSION['fail'] = "Fail";
                header("Location: views/municipios/registrarMunicipio.php");
            }

        }

        //Función para mostrar los registros de la tabla municipio
        public function eliminarMunicipio(){
            //Comprobar que exista el admin y el codigo correspondiente del registro
            if(isset($_SESSION['admin']) && isset($_GET['id'])){
                //Almacenar el codigo en una variable
                $codigo = (int)$_GET['id'];

                //Eliminar todos los registros en los que aparezca el usuario (tabla postulaciones)
                $empleo = new EmpleoModel();
                $empleo->setMunicipio($codigo);
                $empleos = $empleo->obtenerEmpleosBorrarFK();
                // var_dump($empleos);
                // die();
                //conidicion para saber si hay algún empleo que haya publicado
                //el usuario
                if($empleos->num_rows >= 1){
                    //Ciclo para borrar todos los empleos
                    while($emp = $empleos->fetch_object()){

                        $codigo1 = $emp->codigo;

                        $postulacion1 = new PostulacionModel();
                        $postulacion1->setEmpleo($codigo1);
                        $postulaciones1 = $postulacion1->eliminarEmpleo();

                    }

                }else{//En caso de no haber registros
                    $postulaciones1 = "Sin postulaciones";
                }
                // var_dump($postulaciones1);
                // die();
                
                if(isset($postulaciones1)){

                    $empleo1 = new EmpleoModel();
                    $empleo1->setMunicipio($codigo);
                    $empleos1 = $empleo1->eliminarEmpleoMunicipio();

                    if($empleos){

                        $eliminar = new MunicipioModel();
                        $eliminar->setCodigo($codigo);
                        $eliminado = $eliminar->eliminarMunicipio();

                        if($eliminado){
                            $_SESSION['complete'] = "Complete";
                            header("Location: views/municipios/indexMunicipio.php");
                        }else{
                            $_SESSION['fail'] = "Fail";
                            header("Location: views/municipios/indexMunicipio.php");
                        }

                    }else{
                        $_SESSION['fail'] = "Fail";
                        header("Location: views/municipios/indexMunicipio.php");
                    }

                }

            }else{
                $_SESSION['fail'] = "Fail";
                header("Location: views/municipios/indexMunicipio.php");
            }

        }

    }