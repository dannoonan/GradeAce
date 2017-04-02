<?php

class PdfFile{

	private $fileId;
	private $fileName;
	private $tmpName;
	private $fileSize;
	private $fileType;
	private $content;
  
	function setFileId($fileId) { $this->fileId = $fileId; }
	function getFileId() { return $this->fileId; }
	function setFileName($fileName) { $this->fileName = $fileName; }
	function getFileName() { return $this->fileName; }
	function setTmpName($tmpName) { $this->tmpName = $tmpName; }
	function getTmpName() { return $this->tmpName; }
	function setFileSize($fileSize) { $this->fileSize = $fileSize; }
	function getFileSize() { return $this->fileSize; }
	function setFileType($fileType) { $this->fileType = $fileType; }
	function getFileType() { return $this->fileType; }
	function setContent($content) { $this->content = $content; }
	function getContent() { return $this->content; }
	
}

?>