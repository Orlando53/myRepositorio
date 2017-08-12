<?php

/*
 *    @Autor: Orlando Puentes Andrade
 *
 *    @Licencia: LGPL
 *
 *  @Objetico: clase dbmanager pdo
 *
 */

include_once 'constantes.php';

class DBManejador extends PDO
{
    public $srv      = SRV;
    public $usr      = USR;
    public $pas      = PAS;
    public $dba      = BDA;
    private $prt     = PRT;
    private $numrows = null;
    private $conexion;
    private $manejador;
    public $error;

    public function __construct()
    {
        $this->conectar();
    }

    /**
     * @todo Establece la conexión a la Base de datos utilizando PDO.
     * @access private
     **/

    final public function conectar()
    {
        $srv   = SRV;
        $usr   = USR;
        $pas   = PAS;
        $dba   = BDA;
        $prt   = PRT;
        $conex = null;
        try
        {
            if (is_array(PDO::getAvailableDrivers())) {
                if (in_array("mysql", PDO::getAvailableDrivers())) {

                    $conex = new PDO("mysql:host=".$srv."; port=3306;dbname=db_sstplus", "$usr", "$pas");
                    $this->setManejador('mysql');
                } else {
                    throw new PDOException("No se puede trabajar sin establecer una conexión adecuada con la base de datos de mysql");
                }

            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }

        $this->setConexion($conex);
    }

    /**
     *
     * @todo Permite obtener datos mediante un arreglo asociativo o de objetos, concatenando las columnas y las tablas.
     *
     * @access public
     * @param string $columnas
     * @param string $tabla
     * @param bool $getObjects
     *
     * @return mixed
     *
     **/
	 
	final public function consultar($columnas, $tabla, $getObjects = false)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare(" SELECT " . $columnas . " FROM " . $tabla);
            $query->execute();
            $this->setNumRows($query->rowCount());
            //$this->conexion->cerrarConexion();
            if ($getObjects) {
                $rt = $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $rt = $query->fetchAll(PDO::FETCH_OBJ);
            }
            // cerrarConexion();

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }
        return $rt;
    }

    /**
     *
     * @todo Permite obtener datos mediante un arreglo asociativo o de objetos, concatenando las columnas, las tablas, condición y los valores que serán utilizados.
     *
     * @access public
     * @param string $columnas
     * @param string $tabla
     * @param string $condicion
     * @param mixed  $valores
     *
     * @return mixed
     *
     **/

    public function consultarCondicion($columnas, $tabla, $condicion, $valores)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare("SELECT " . $columnas . " FROM " . $tabla . " WHERE " . $condicion);

            /*foreach ($valores as $key => $value)
            {
            if( !empty( $value ) ){
            $query->bindParam($key, $value, $this->getPDOConstantType( $value ) );
            }
            }*/

            $query->execute($valores);
            $cont = $this->setNumRows($query->rowCount());
            $rt   = $query->fetchAll(PDO::FETCH_ASSOC);
            //$this->setConexion(null);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }
        return $rt;
    }

	public function count($tabla, $condicion, $valores){
		$rt = null;
		try
		{
			$query = $this->conexion->prepare("SELECT COUNT(*) AS cuenta FROM " . $tabla . " WHERE ". $condicion);
			$rt = $query->fetch(PDO::FETCH_OBJ);
		} catch(PDOException $e){
			error_log($e->getMessage);
			$this->error=$e->getMessage();
		}
		return $rt;
	}
    public function consultarUnion($columnas, $tabla, $condicion, $columnas2, $tabla2, $condicion2, $valores)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare("SELECT " . $columnas . " FROM " . $tabla . " WHERE " . $condicion . " UNION SELECT "
                . $columnas2 . " FROM " . $tabla2 . " WHERE " . $condicion2);

            /*foreach ($valores as $key => $value)
            {
            if( !empty( $value ) ){
            $query->bindParam($key, $value, $this->getPDOConstantType( $value ) );
            }
            }*/

            $query->execute($valores);
            $cont = $this->setNumRows($query->rowCount());
            $rt   = $query->fetchAll(PDO::FETCH_ASSOC);
            //$this->setConexion(null);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }
        return $rt;
    }

    public function consultarMax($columna, $tabla)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare("SELECT MAX" . "(" . $columna . ")" . " AS id FROM " . $tabla);

            /*foreach ($valores as $key => $value)
            {
            if( !empty( $value ) ){
            $query->bindParam($key, $value, $this->getPDOConstantType( $value ) );
            }
            }*/

            $query->execute();
            $cont = $this->setNumRows($query->rowCount());
            $rt   = $query->fetchAll(PDO::FETCH_ASSOC);
            //$this->setConexion(null);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }
        return $rt;
    }
    /**
     *
     * @todo Guarda valores en la tabla que se desee, concatenando las columnas, tabla, campos y los valores que serán utilizados.
     *
     * @access public
     * @param string $tabla
     * @param string $columnas
     * @param string $campos
     * @param mixed  $valores
     *
     * @return int
     *
     **/

    final public function agregar($tabla, $columnas, $campos, $valores)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare("INSERT INTO " . $tabla . " (" . $columnas . ") VALUES (" . $campos . ")");
            $rt = $query->execute($valores);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }
        return $this->conexion->lastInsertId($tabla);
    }

    /**
     *
     * @todo Modifica valores en la tabla que se desee, concatenando la tabla, campos, valores y la condicion que sera utilizada para ejecutar esta consulta.
     *
     * @access public
     * @param string $tabla
     * @param string $campos
     * @param mixed $valores
     * @param string $condicion
     *
     * @return int
     *
     **/

    final public function actualizar($tabla, $campos, $valores, $condicion)
    {
        $rt = null;
        try
        {
            $query = $this->conexion->prepare("UPDATE " . $tabla . " SET " . $campos . " WHERE " . $condicion);
            /*foreach ($valores as $key => $value)
            {
            if( !empty( $value ) )
            $query->bindParam( $key, $value, $this->getPDOConstantType( $value ) );
            }*/
            $rt = $query->execute($valores);
//                        echo "UPDATE ".$tabla." SET ".$campos." WHERE ".$condicion ;
            //                        echo $query->errorInfo()[2];
            $this->setNumRows($query->rowCount());
            //$this->setConexion(null);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }

        return $rt;

    }

    /**
     *
     * @todo Elimina valores en la tabla que se desee, concatenando la tabla, condicion y los valores que seran utilizados en esta consulta.
     *
     * @access public
     * @param string $tabla
     * @param string $condicion
     * @param mixed $valores
     *
     * @return int
     *
     **/

    final public function eliminar($tabla, $condicion, $valores)
    {
        $rt = null;

        try
        {

            $query = $this->conexion->prepare("DELETE FROM " . $tabla . " WHERE " . $condicion);

            // foreach ($valores as $key => $value) {
            //     if (!empty($value)) {
            //         $query->bindParam($key, $value, $this->getPDOConstantType($value));
            //     }

            // }

            $rt = $query->execute($valores);
            $this->setNumRows($query->rowCount());
            //$this->setConexion(null);

        } catch (PDOException $e) {

            error_log($e->getMessage());
            $this->error=$e->getMessage();
        }

        return $rt;

    }

    /**
     *
     * @todo Muestra la estructura de las tablas de la Base de datos
     *
     * @access public
     *
     * @return mixed $rt
     *
     **/

    final public function estructuraBD()
    {
        $rt = array($this->dba => array());

        if ($this->getManejador() == 'pgsql') {
            $query = $this->conexion->prepare("SELECT table_schema FROM information_schema.tables WHERE table_schema NOT IN ( 'pg_catalog', 'information_schema' ) AND table_catalog = '" . $this->dba . "' GROUP BY table_schema ORDER BY table_schema");

            $query->execute();

            $esquemas = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($esquemas as $indice_esquema => $valor_esquema) {
                if (!empty($valor_esquema)) {
                    $rt[$this->dba][$valor_esquema['table_schema']] = array();

                    $query = $this->conexion->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema NOT IN ( 'pg_catalog', 'information_schema' ) AND table_catalog = '" . $this->dba . "' AND table_schema = '" . $valor_esquema['table_schema'] . "' ORDER BY table_schema");

                    $query->execute();

                    $tablas = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($tablas as $indice_tabla => $valor_tabla) {
                        if (!empty($valor_tabla)) {
                            $rt[$this->dba][$valor_esquema['table_schema']][$valor_tabla['table_name']] = array();

                            $query = $this->conexion->prepare(" SELECT * FROM " . $valor_esquema['table_schema'] . "." . $valor_tabla['table_name'] . " LIMIT 1");

                            $query->execute();

                            $columnas = $query->fetchAll(PDO::FETCH_ASSOC);

                            $constrains = $this->conexion->prepare(" SELECT ccu.column_name AS columna, ccu.constraint_name AS alias, tc.constraint_type AS restrinccion FROM information_schema.key_column_usage AS ccu, information_schema.table_constraints AS tc WHERE ccu.constraint_name = tc.constraint_name AND ccu.table_name = '" . $valor_tabla['table_name'] . "' AND tc.table_name = '" . $valor_tabla['table_name'] . "'");

                            $constrains->execute();

                            $restrincciones = $constrains->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($columnas as $indice_columnas => $valor_columnas) {
                                if (!empty($valor_columnas)) {
                                    $cantidad_columnas = $query->columnCount();

                                    for ($i = 0; $i < $cantidad_columnas; $i++) {
                                        $detalles = $query->getColumnMeta($i);

                                        foreach ($restrincciones as $key => $value) {
                                            if (!empty($value)) {
                                                if ($detalles['name'] == $value['columna']) {
                                                    $detalles['alias']        = $value['alias'];
                                                    $detalles['restrinccion'] = $value['restrinccion'];
                                                }
                                            }
                                        }

                                        $rt[$this->dba][$valor_esquema['table_schema']][$valor_tabla['table_name']][$i] = $detalles;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $rt;
    }

    /**
     *
     * @todo Borra la información de la conexión
     *
     * @access public
     *
     **/

    final public function cerrarConexion()
    {
        //$this->setConexion(null);
    }

    /**
     *
     * @todo Devuelve la información de la conexión.
     *
     * @access public
     *
     * @return int
     *
     **/

    final public function getConexion()
    {
        return $this->conexion;
    }

    /**
     *
     * @todo Guarda la información de la conexión a la base de datos.
     *
     * @access private
     *
     * @param mixed $conexion
     *
     **/

    final private function setConexion($conexion)
    {
        $this->conexion = $conexion;
    }

    /**
     *
     * @todo Devuelve el alias del manejador de la base de datos.
     *
     * @access public
     *
     * @return string
     *
     **/

    final public function getManejador()
    {
        return $this->manejador;
    }

    /**
     *
     * @todo Guarda la información del alias del manejador de la base de datos.
     *
     * @access private
     *
     * @param string $manejador
     *
     **/

    final private function setManejador($manejador)
    {
        $this->manejador = $manejador;
    }

    /**
     *
     * @todo Guarda la cantidad de filas afectadas en una consulta.
     *
     * @access public
     *
     * @param int $rows
     *
     **/

    final private function setNumRows($rows)
    {
        $this->numrows = $rows;
    }

    /**
     *
     * @todo Devuelve la cantidad de filas afectadas en una consulta.
     *
     * @access public
     *
     * @return int $this->numrows
     *
     **/

    final public function getNumRows()
    {
        return $this->numrows;
    }

    final public function getDba()
    {
        return $this->dba;
    }

    /**
     *
     * @todo Devuelve las constantes definidas por la extensión PDO
     *
     * @access private
     *
     * @param mixed $var
     *
     * @return mixed PDO::PARAM_
     *
     **/

    private function getPDOConstantType($var)
    {
        if (is_int($var)) {
            return PDO::PARAM_INT;
        }

        if (is_bool($var)) {
            return PDO::PARAM_BOOL;
        }

        if (is_null($var)) {
            return PDO::PARAM_NULL;
        }

        return PDO::PARAM_STR;
    }
    
    public function begin(){
    	$this->conexion->beginTransaction();
    }
    
    public function rollback(){
    	$this->conexion->rollBack();
    }
    
    public function commit(){
    	$this->conexion->commit();
    }
}
