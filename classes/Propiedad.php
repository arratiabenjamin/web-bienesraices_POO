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

        //Asignar Valores a Atributos
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
            $this->vendedorId = $args['vendedorId'] ?? 1;

        }

        //Subir a la DB
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

        //Asignar Keys y Values a Array Assoc para luego Sanitizar
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

        //Sanitizacion
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

        //Verificar Errores en Formulario
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

        //Listar Propiedades
        public static function all() {
            
            $querySelectPropiedades = "SELECT * FROM propiedades";
            $propiedades = self::consultarSQL($querySelectPropiedades);
            return $propiedades;

        }

        public static function consultarSQL($query) {

            //Consultar DB
            $propiedades = self::$db->query($query);

            //Asignar Todas las Propiedades como Obejetos al Array
            $array = [];
            foreach($propiedades as $propiedad) {
                $array[] = self::crearObjeto($propiedad);
            }

            //Liberar Memoria (Mas que nada pasa Ayudar al Servidor)
            //Es como el mysqli_close()
            $propiedades->free();

            //Retornar Resultados
            return $array;

        }

        protected static function crearObjeto($propiedad) {

            //Crear Objeto a Usar para Añadir Valores
            $obj = new self;

            //Iterar Array de Propiedad
            foreach($propiedad as $key => $value){

                //Si existe la Propieda en el Obejeto
                if(property_exists($obj, $key)){

                    //Añadir Valor a la Key
                    $obj->$key = $value;

                }

            }

            //Retornar Obj con sus Valores ya Asignados
            return $obj;

        }

    }