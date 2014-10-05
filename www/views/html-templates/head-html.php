<?php

class HeadHtml {
	private $title;

	public function __construct($title) {
		$this->title = $title;
	}

	public function getHtml() {
		return	'<!DOCTYPE html>
				<html>
				<head>
					<title>' . $this->title . '</title>
					<meta charset="utf-8" /> 
					<link rel="stylesheet" type="text/css" href="styles/styles.css" />
				</head>
				<body>';
	}
}
