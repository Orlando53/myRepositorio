<?php
/*
 *  @autor:		Orlando Puentes
 *  @fecha:		Agosto 13 de 2017
 *  @objetivo.	Desarrollar una classe que permita subir archivos al servidor web
 */

class Upload
{
	var $archivo;
	var $directorio;	
	var $tipoArchivo;
	var $tipoPermitido;
	var $tamanoArchivo;
	var $tmp;
	var $nombre;
	var $tamanoMaximo;	
	
	/**
	 * Constructor de la clase Archivo
	 *
	 * @param string $archivo
	 * @param string $dir	 
	 * @param array $extPermitida
	 * @param int $tamano
	 * @param string $tmp
	 * @param string $nombre
	 * @param int $tamPermitido	 
	 */
	public function __construct($archivo,$dir,$extPermitida=array(),$tamano,$tmp,$nombre='',$tamPermitido=''){
		$this->archivo			= $archivo;
		$this->directorio		= $dir;		
		$this->tipoArchivo		= $this->getTipoArchivo($archivo);
		$this->tipoPermitido	= $extPermitida;
		$this->tamanoArchivo	= $tamano;		
		$this->nombre			= empty($nombre) ? str_replace(".".$this->tipoArchivo,"",$archivo) : $nombre;		
		$this->tamanoMaximo		= empty($tamPermitido) ? ini_get('upload_max_filesize')*1048576 : $tamPermitido*1048576;
		$this->tmp				= $tmp;
	}
	
	/**
	 * Devuelve la extensión de un archivo
	 * @param String $archivo Cadena con el nombre original del archivo
	 * @return String $extension
     * @author Jorge Andrade M.
	 */
	private function getTipoArchivo($archivo){
	    try {
	        if($archivo!=''){
	            $extension=end(explode('.',$archivo));
	            return $extension;
	        }
	    } catch (Throwable $t) {
	        // Handle exception
	    }
	    
		
	}
	/**
	 * Revisa si el tipo del archivo está dentro de lo permitido
	 * @return boolean Si cumple o no con lo establecido
     * @author Jorge Andrade M.
	 */
	private function checkType(){
		if(in_array($this->tipoArchivo,$this->tipoPermitido)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Revisa si el archivo es del tamaño permitido
	 * @return boolean Si cumple o no con lo establecido
     * @author Jorge Andrade M.
	 */
	private function checkSize(){
		if($this->tamanoArchivo > $this->tamanoMaximo){
			return false;
		}else{
			return true;
		}
	}	
	/**
	 * Sube los archivos, revisa si no sobrepasa el tamaño máximo permitido,
	 *  si está dentro de los tipos aceptados y si no exite
	 *
	 * @return boolean indicando el resultado del proceso
	 */
	public function upLoadFile(){		
		if($this->checkSize()==false){
			echo "El tamano del archivo sobrepasa el permitido que es de ".round(($this->tamanoMaximo/1048576),2)."MB";
			return false;
		}
		if($this->checkType()==false){
			echo "El archivo no corresponde a un formato permitido. Los permitidos son: ".(implode(",",$this->tipoPermitido));
			return false;
		}
		if(file_exists($this->directorio.$this->archivo)){
			echo "El archivo ya existe";
			return false;		
		}
		
		copy($this->tmp,$this->directorio.$this->nombre.".".$this->tipoArchivo);
		return true;
				
	}
	/**
	 * Borra el archivo del servidor
	 *
	 * @return boolean
	 */
	public function delFile(){
		if(file_exists($this->directorio.$this->archivo)){
			unlink($this->directorio.$this->archivo);
			return true;
		}else{
			return false;
		}		
	}
}

?>