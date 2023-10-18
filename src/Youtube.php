<?php
declare(strict_types = 1);
include_once 'video.php';

class Youtube extends Video {
	public function __construct($source, $name) {
		$this->setSource($source);
		$this->name = $name;
	}

	public function setName($source) {
		$this->name = $source;
	}

	public function setSource($source) {
		$pos = strpos($source, '=') + 1;
		$this->source = substr($source, $pos, strlen($source));
	}

	public function getHTML() {
		return '<iframe src="https://www.youtube.com/embed/'.$this->source.'" width="400px" height="300px" title="'.$this->name.'">'.$this->name.'</iframe>';
	}

	public function setDate($source) {

	}
}

/*public function setName($source) {
		if(strlen($source) == 0) {
			$content = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$this->source."&key=".$this->key."&part=snippet");
			//echo $content;
			//parse_str($content, $ytarr);
			$ytarr = json_decode($content, true);
			echo "                                                     \n";
			var_dump($ytarr);
			echo "                                                     \n";
			echo "                                                     \n";
			echo $ytarr['items'][0]['snippet']['title'];
			$this->name = $ytarr->snippet->title;
		}else {
			$this->name = $source;
		}	
}*/
?>