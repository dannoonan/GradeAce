<?php

Class Task{
	private $TaskId;
	private $Title;
	private $TaskType;
	private $Description;
	private $Pages;
	private $Words;
	private $FileFormat;
	private $FilePath;
	private $ClaimDate;
	private $CompleteDate;
	private $Notes;


	function setTaskId($TaskId) { $this->TaskId = $TaskId; }
	function getTaskId() { return $this->TaskId; }
	function setTitle($Title) { $this->Title = $Title; }
	function getTitle() { return $this->Title; }
	function setTaskType($TaskType) { $this->TaskType = $TaskType; }
	function getTaskType() { return $this->TaskType; }
	function setDescription($Description) { $this->Description = $Description; }
	function getDescription() { return $this->Description; }
	function setPages($Pages) { $this->Pages = $Pages; }
	function getPages() { return $this->Pages; }
	function setWords($Words) { $this->Words = $Words; }
	function getWords() { return $this->Words; }
	function setFileFormat($FileFormat) { $this->FileFormat = $FileFormat; }
	function getFileFormat() { return $this->FileFormat; }
	function setFilePath($FilePath) { $this->FilePath = $FilePath; }
	function getFilePath() { return $this->FilePath; }
	function setClaimDate($ClaimDate) { $this->ClaimDate = $ClaimDate; }
	function getClaimDate() { return $this->ClaimDate; }
	function setCompleteDate($CompleteDate) { $this->CompleteDate = $CompleteDate; }
	function getCompleteDate() { return $this->CompleteDate; }
	function setNotes($Notes) { $this->Notes = $Notes; }
	function getNotes() { return $this->Notes; }
}

?>