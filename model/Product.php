<?php   
// Product hereda las funciones de la clase Conectar, 
// que se encuentra en el archivo config/connection.php. 
// Esto permite que la clase Product pueda utilizar la conexión a la base de datos y otras funcionalidades definidas en la clase Conectar.
    class Product extends Conectar{
        // obtiene el listado de productos activos en la base de datos.
        public function get_product(){
            // establecer la conexión a la base de datos utilizando el método Conexion() de la clase padre (Conectar).
            $conectar = parent::Conexion();
            // codificacion de caracteres a UTF-8 para la conexión a la base de datos.
            parent::set_names();
            // Consulta sql para obtener todos los productos activos (est = 1) de la tabla tm_producto.
            $sql = "SELECT * FROM tm_producto WHERE est = 1";
            // prepara la consulta SQL utilizando el método prepare() de PDO, que permite ejecutar consultas de manera segura y eficiente.
            $sql = $conectar->prepare($sql);
            // ejecuta la consulta SQL utilizando el método execute() de PDO, que ejecuta la consulta preparada.
            $sql->execute();
            // obtiene todos los resultados de la consulta utilizando el método fetchAll() de PDO, que devuelve un array con todas las filas resultantes de la consulta.
             $resultado = $sql->fetchAll();
             return $resultado;
        }
    }


?>