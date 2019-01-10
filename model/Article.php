<?php

class Article {

	private $id;
	private $title;
	private $content;
	private $date_create;
	private $status;

	public function getId() {
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getContent() {
		return $this->content;
	}

	public function setContent($content){
		$this->content = $content;
	}

	public function getDateCreate() {
		return $this->date_create;
	}

	public function setDateCreate($date_create){
		$this->date_create = $date_create;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}
}