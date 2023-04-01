<?php 

    namespace App;

    class Propiedad extends ActiveRecord{

        //VARS STATICS
        protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamientos', 'creado', 'vendedorId'];
        protected static $tabla = "propiedades";


        //VARS INSTANS
        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public $estacionamientos;
        public $creado;
        public $vendedorId;

        //Asignar Valores a Atributos
        public function __construct($args = [])
        {
            
            $this->id = $args['id'] ?? null;
            $this->titulo = $args['titulo'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->imagen = $args['imagen'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->habitaciones = $args['habitaciones'] ?? '';
            $this->wc = $args['wc'] ?? '';
            $this->estacionamientos = $args['estacionamientos'] ?? '';
            $this->creado = date('Y/m/d');
            $this->vendedorId = $args['vendedorId'] ?? '';

        }

        //Verificar Errores en Formulario
        public function validar() {

            if(!$this->titulo) {
                self::$errores[] = "Debes Añadir un Titulo";
            }
            if(!$this->precio) {
                self::$errores[] = 'El Precio es Obligatorio';
            }
            if( strlen( $this->descripcion ) < 50 ) {
                self::$errores[] = 'La Descripción es Obligatoria y Debe Tener al Menos 50 Caracteres';
            }
            if(!$this->habitaciones) {
                self::$errores[] = 'El Número de Habitaciones es Obligatorio';
            }
            if(!$this->wc) {
                self::$errores[] = 'El Número de Baños es Obligatorio';
            }
            if(!$this->estacionamientos) {
                self::$errores[] = 'El Número de Lugares de Estacionamiento es Obligatorio';
            }
            if(!$this->vendedorId) {
                self::$errores[] = 'Elige un Vendedor';
            }

            if(!$this->imagen) {
                self::$errores[] = 'Se Debe Añadir una Imagen';
            }

            return self::$errores;

        }

    }