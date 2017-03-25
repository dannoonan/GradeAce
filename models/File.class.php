<?php

class File{

	private $fileId;
	private $fileName;
	private $tmpName;
	private $fileSize;
	private $fileType;
  
	function setFileId($fileId) { $this->fileId = $fileId; }
	function getFileId($fileId) { return $this->fileId; }
	function setFileName($fileName) { $this->fileName = $fileName; }
	function getFileName() { return $this->fileName; }
	function setTmpName($tmpName) { $this->tmpName = $tmpName; }
	function getTmpName() { return $this->tmpName; }
	function setFileSize($fileSize) { $this->fileSize = $fileSize; }
	function getFileSize() { return $this->fileSize; }
	function setFileType($fileType) { $this->fileType = $fileType; }
	function getFileType() { return $this->fileType; }
	
}

?>