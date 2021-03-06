<?php

namespace Strukt\Router;

use RecursiveDirectoryIterator as RecDirItr;
use RecursiveIteratorIterator as RecItrItr;
use Strukt\Fs;

class FileFinder{

	public function __construct(string $base_dir, string $dir_path){

		$abs_dir = sprintf("%s/%s", $base_dir, $dir_path);

		$dItr = new RecDirItr($abs_dir);
		$rItrItr  = new RecItrItr($dItr, RecItrItr::SELF_FIRST);

		foreach ($rItrItr as $file) {

		    if($file->isFile()){

		    	$uri = str_replace(array($base_dir, $dir_path), "", $file->getRealPath());

		    	$this->files[$uri] = $file; 
		    }
		}
	}

	public function exists($filepath){

		return array_key_exists($filepath, $this->files);
	}

	public function getObject($filepath){

		return $this->files[$filepath];
	}

	public function getContents($filepath){

		return Fs::cat($this->getObject($filepath)->getRealPath());
	}
}