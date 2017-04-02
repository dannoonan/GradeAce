<?php
 require_once __DIR__.'/../models/PdfFile.class.php';
 require_once __DIR__.'/../utils/MySQLiAccess.class.php';
 require_once __DIR__.'/../utils/ModelFactory.class.php';

 
 Class FileDAO {
	 
	 
	public static function getFile($FileId, $FileName){
		 
		$file = null;
		 
        if (!is_null($FileId) || !is_null($FileName)) {
		
            $args = $FileId.", ".MySQLiAccess::prepareString($FileName);

            $result = MySQLiAccess::call("getFile", $args);
			
			
            if ($result) {
				$resultArray = $result->fetch_array();
                $file = ModelFactory::buildModel("PdfFile", $resultArray);
            }
        }
        return $file;
    }
 
			
	

		 
	//Inserts a new file into the database
	public static function insert(&$PdfFile) {
		$name=$PdfFile->getFileName();
		//A string, $args, is created to hold the attributes of the PdfFile object that will be inserted into the database
		$args = 
		MySQLiAccess::prepareString($PdfFile->getFileName()).", ".
		MySQLiAccess::prepareString($PdfFile->getFileType()).", ".
		MySQLiAccess::prepareString($PdfFile->getFileSize()).", ".
		MySQLiAccess::prepareString($PdfFile->getContent());

		$result = MySQLiAccess::call("addFile", $args);
		
        if ($result) {
            $PdfFile = self::getFile("''", $name);
        } else {
            $PdfFile = null;
        }
		echo $PdfFile->getFileName();
		return $PdfFile;
    }
	
 }
?>