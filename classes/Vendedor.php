<?php 

    namespace App;

    class Vendedor extends ActiveRecord{

        //VARS STATICS
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];
        protected static $tabla = "vendedores";

        //VARS INSTANS
        public $id;
        public $nombre;
        public $apellido;
        public $telefono;

        //Asignar Valores a Atributos
        public function __construct($args = [])
        {
            
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->telefono = $args['telefono'] ?? '';

        }

        //Verificar Errores en Formulario
        public function validar() {

            if(!$this->nombre) {
                self::$errores[] = "Debes Añadir un Nombre";
            }
            if(!$this->apellido) {
                self::$errores[] = "Debes Añadir un Apellido";
            }
            if(!$this->telefono) {
                self::$errores[] = "Debes Añadir un Teléfono";
            }

            //Expresion Regular
            //Permite buscar el patron requerido
            //Sirve para un Telefono/Email/TarjetaBancaria/etc.
            if(!preg_match('/[0-9]{9}/', $this->telefono)){
                self::$errores[] = "Formato Teléfono Invalido";
            }

            return self::$errores;

        }
    }