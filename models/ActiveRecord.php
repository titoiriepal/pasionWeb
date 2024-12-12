<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }


    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            if ($value !== null){
                $sanitizado[$key] = self::$db->escape_string($value);
            }else{
                $sanitizado[$key] = null;
            }
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    public function setRuta($ruta){
    
        //Eliminar la imagen previa(en el caso de actualizar)
        if(!is_null($this->id)){
            $this->borrarImagen();
            
        }

        //Asignar al atributo de imagen el nombre de la imagen
        if ($ruta){
            $this->ruta = $ruta;
        }
    }

     //Eliminar la imagen
   
     public function borrarImagen(){
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->ruta);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->ruta);
        }

    }

     //Eliminar la imagen

    public function eliminarFotografia($carpeta){
        $rutaArchivo = $carpeta . trim($this->ruta);
        $existeArchivo = file_exists($rutaArchivo);
        if($existeArchivo){
            unlink($rutaArchivo);
        }
        $this->eliminar();

    }
    

    
   

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Cantidad de registros desde una determinada posicion.
    public static function findXFromTo($columna, $principio, $cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $columna . " > " . $principio . " LIMIT " . $cantidad; 
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite" ;
        
        $resultado = self::consultarSQL($query);
        return  $resultado ;
    }

    public static function paginar($registros, $offset, $query = " ",$orden = "id"){
        if($query === " "){
            $query = "SELECT * FROM " . static::$tabla;
        }
        $query = $query . " ORDER BY " . $orden . " DESC LIMIT $registros OFFSET $offset " ;
        //debuguear($query);
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }  
    
    public static function paginarAsc($registros, $offset, $query = " ",$orden = "id"){
        if($query === " "){
            $query = "SELECT * FROM " . static::$tabla;
        }
        $query = $query . " ORDER BY " . $orden . " ASC LIMIT $registros OFFSET $offset " ;
        //debuguear($query);
        $resultado = self::consultarSQL($query);
        return  $resultado;
    } 
    

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    //Busqueda Where con Columna devolviendo más de una opción
    public static function arrayWhere($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

        // Busqueda Where con multiples opciones 
        public static function whereArray($array = []) {
            $first = array_key_first($array);
            $last = array_key_last($array);
            $query = "SELECT * FROM " . static::$tabla . " WHERE ";
            foreach($array as $key => $value){
                if (count($array) === 1 || $key === $first){
                    $query .= "$key = '$value'";
                }else if($key === $last){
                    $query .= " AND $key = '$value'";
                }else{
                    $query .= ", $key = '$value'";
                }
            }
            $resultado = self::consultarSQL($query);
            return  $resultado;
        }

        //Generar Select con array Where para busquedas
        public static function selectWhereArray($array = []) {
            $first = array_key_first($array);
            $last = array_key_last($array);
            $query = "SELECT * FROM " . static::$tabla . " WHERE ";
            foreach($array as $key => $value){
                if (count($array) === 1 || $key === $first){
                    $query .= "$key LIKE '%$value%'";
                }else{
                    $query .= " OR $key LIKE '%$value%'";
                }
            }

            //debuguear($query);
            return($query);
        }

        //Total de registros
    public static function counter($columna, $valor){
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return ($resultado);

    }

    //Devuelve la posición que tendrá un registro determinado en una busqueda por el $valor en $columna
    public static function registerPosition($columna, $valor){
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE $columna <= '$valor'";
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    } 

        //Traer el total de registros
        public static function total($columna = '', $valor=''){
            $query = "SELECT COUNT(*) FROM " . static::$tabla;
            if($columna){
                $query .= " WHERE $columna = '$valor'";
            }
    
            $resultado = self::$db->query($query);
    
            $total = $resultado->fetch_array();
            return array_shift($total);
            
        }

        //Contar los registros en una busqueda
        public static function totalQuery($array){
            $first = array_key_first($array);
            $last = array_key_last($array);
            $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";
            foreach($array as $key => $value){
                if (count($array) === 1 || $key === $first){
                    $query .= "$key LIKE '%$value%'";
                }else{
                    $query .= " OR $key LIKE '%$value%'";
                }
            }

    
            $resultado = self::$db->query($query);
    
            $total = $resultado->fetch_array();
            return array_shift($total);
            
        }

    //Total de registros con un Array where

    public static function totalArray($array = []){
        $first = array_key_first($array);
        $last = array_key_last($array);

        $query = "SELECT COUNT(*) FROM " . static::$tabla . ' WHERE ';
        foreach($array as $key => $value){
            if (count($array) === 1 || $key === $first){
                $query .= "$key = '$value'";
            }else if($key === $last){
                $query .= " AND $key = '$value'";
            }else{
                $query .= ", $key = '$value'";
            }
        }
        

        $resultado = self::$db->query($query);

        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    //Consulta plana de SQL (Utilizar cuando los métodos del modelo no sonsuficientes)
    public static function SQL($query) {
        $resultado = self::consultarSQL($query);
        return $resultado;
        
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

}