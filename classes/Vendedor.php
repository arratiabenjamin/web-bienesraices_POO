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
    }