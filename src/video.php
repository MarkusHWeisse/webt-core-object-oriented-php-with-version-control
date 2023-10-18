<?php
declare(strict_types = 1);

class Date {
	public $day;
	public $month;
	public $year;

	public function setDate($day, $month, $year) {
		$this->day = $day;
		$this->month = $month;
		$this->year = $year;
	}

	public function getDay() {
		return $day;
	}

	public function getMonth() {
		return $month;
	}

	public function getYear() {
		return $year;
	}
}

interface video_interface {
	public function getHTML();
	public function getName();
	public function getSource();
	public function getDate();
	public function setName($source);
	public function setDate($source);
	public function setSource($source);
}

abstract class Video implements video_interface {
	public $name;
	public $source;
	public $HTML;
	public $videoDate;

	public function getDate() {
		return $this->videoDate;
	}

	public function getName() {
		return $this->name;
	}

	public function getSource() {
		return $this->source;
	}
	
	abstract public function getHTML();
	abstract public function setName($source);
	abstract public function setDate($source);
	abstract public function setSource($source);
}

?>