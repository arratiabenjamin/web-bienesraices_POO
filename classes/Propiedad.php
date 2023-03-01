<?php 

    namespace App;

    class Propiedad {

        //Crear Variable Protegida y Statica que se usara como DB
        protected static $db;
        //Variable usada para poder Sanitizar
        protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamientos', 'creado', 'vendedorId'];

        //Errores
        protected static $errores = [];

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
        
        //Metodo para Setear Variable de DB
        public static function setDB($database) {
            self::$db = $database;
        }

        public function __construct($args = [])
        {
            
            $this->id = $args['id'] ?? '';
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

        public function guardar() {

            $atributos = $this->sanitizarDatos();
            //Transformar Keys y Values de Array Assoc a String con sus Respectivos Separadores.
            //Para poder Ponerlos en el Query y Poder dejar todo mas Ordenado.
            $atributosKeys = join(', ', array_keys($atributos));
            $atributosValues = join("', '", array_values($atributos));

            //Creamos Query Recortado
            $queryInsert = "INSERT INTO propiedades ( " . $atributosKeys . " ) VALUES ( ' " . $atributosValues . " ' )";
            
            //Realizamos Query
            $resultado = self::$db->query($queryInsert);

            return $resultado;
        }

        //Asignar Nombre de la Imagen a Atributo
        public function setImagen($imagen) {
            if($imagen) {
                $this->imagen = $imagen;
            }
        }

        public function atributos() {
            $atributos = [];
            foreach(self::$columnasDB as $columna) {
                //Si $columna es igual a 'id' saltamos este loop y vamos al siguiente.
                if($columna === 'id') continue;
                //La Key sera el valor de cada variables
                //El Value sera el Valor de Cada Atributo que Creamos Anteriormente
                //Ej: $atributos['titulo'] = $this->titulo;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }

        public function sanitizarDatos() {
            
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value) {
                //escape_string() es como mysqli_real_escape_string(), pero para POO
                $sanitizado[$key] = self::$db->escape_string($value);
            }

            return $sanitizado;

        }

        //Validacion de Datos
        public static function getErrores() {

            return self::$errores;

        }

        public function validar() {

            if(!$this->titulo) {
                self::$errores[] = "Debes Añadir un Titulo";
            }
            if(!$this->precio) {
                self::$errores[] = 'El Precio es Obligatorio';
            }
            if( strlen( $this->descripcion ) < 50 ) {
                self::$errores[] = 'La Descripción es Obligatoria y Debe Tener al Menos 50 cCaracteres';
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