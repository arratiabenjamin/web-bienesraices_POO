<?php 

namespace App;

class ActiveRecord {

    // VARS STATICS

    //DB
    //Crear Variable Protegida y Statica que se usara como DB
    protected static $db;
    //Variable usada para poder Sanitizar
    protected static $columnasDB = [];
    //Nombre de la Tabla/Objeto Crea@
    protected static $tabla = '';

    //Errores
    protected static $errores = [];
    

    //Metodo para Setear Variable de DB
    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if( !is_null($this->id) ) {
            //Actualizar
            $this->actualizar();
        } else {
            //Crear
            $this->crear();
        }
    }

    //Subir a la DB
    public function crear() {


        //Sanitizar
        $atributos = $this->sanitizarDatos();

        $atributosKeys = join(', ', array_keys($atributos));
        $atributosValues = join("', '", array_values($atributos));

        //Creamos Query Recortado
        $queryInsert = "INSERT INTO " . static::$tabla . " ( " . $atributosKeys . " ) VALUES ( ' " . $atributosValues . " ' )";
        
        //Realizamos Query
        $resultado = self::$db->query($queryInsert);

        if($resultado) {
            header('Location: /admin?resultado=1');
        }
        
    }

    //Actualizar DB
    public function actualizar() {

        //Sanitizar
        $atributos = $this->sanitizarDatos();

        $values = [];
        foreach($atributos as $key => $value) {
            $values[] = "$key = '$value'";
        }

        //Creamos Query Recortado
        $queryUpdate = "UPDATE " . static::$tabla . " SET " . join( ', ', $values) . " WHERE id = $this->id LIMIT 1";
        
        //Realizamos Query
        $resultado = self::$db->query($queryUpdate);

        if($resultado) {
            header('Location: /admin?resultado=2');
        }

    }

    //Eliminar Propiedad
    public function eliminar() {
        // Query
        $queryEliminarPropiedad = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($queryEliminarPropiedad);

        if($resultado) {
            $this->eliminarImagen();
            header('Location: /admin?resultado=1');
        }
    }

    //Asignar Nombre de la Imagen a Atributo
    public function setImagen($imagen) {

        //Eliminar Imagen
        if(!is_null($this->id)) {
            $this->eliminarImagen();
        }

        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar Imagen
    public function eliminarImagen() {
        $existImage = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existImage) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Asignar Keys y Values a Array Assoc para luego Sanitizar
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
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

        return static::$errores;

    }

    //Verificar Errores en Formulario
    public function validar() {

        static::$errores = [];
        return static::$errores;

    }

    //Listar Propiedades
    public static function all() {
        
        $querySelectPropiedades = "SELECT * FROM " . static::$tabla; //Static hace Referencia a la Clase Hija.
        $propiedades = self::consultarSQL($querySelectPropiedades);
        return $propiedades;


    }
    //Listar Propiedades con Limite
    public static function getLimit($limit) {

        $querySelectPropiedades = "SELECT * FROM " . static::$tabla . " LIMIT ". $limit; //Static hace Referencia a la Clase Hija.
        $propiedades = self::consultarSQL($querySelectPropiedades);
        return $propiedades;

    }

    public static function find($id) {

        $querySelectPropiedades = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $propiedades = self::consultarSQL($querySelectPropiedades);
        //array_shift sirve para retornar el primer valor del array
        return array_shift($propiedades);

    }

    //Consultar DB
    public static function consultarSQL($query) {

        //Consultar DB
        $propiedades = self::$db->query($query);

        //Asignar Todas las Propiedades como Obejetos al Array
        $array = [];
        foreach($propiedades as $propiedad) {
            $array[] = static::crearObjeto($propiedad);
        }

        //Liberar Memoria (Mas que nada pasa Ayudar al Servidor)
        //Es como el mysqli_close()
        $propiedades->free();

        //Retornar Resultados
        return $array;

    }

    //Crear Objetos
    protected static function crearObjeto($propiedad) {

        //Crear Objeto a Usar para Añadir Valores
        $obj = new static;

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

    //Sincronizar Valores al Actualizar
    public function sincronizar($args = []) {
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }


}


?>