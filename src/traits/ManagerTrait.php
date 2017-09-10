<?php namespace MediaManager\Manager\traits;

trait ManagerTrait
{
	public $path              = '';
	public static $type       = 'image';
	public $file;
	public $folderName;

	public function uploadDirectory()
	{
		return config('manager.upload_directory');
	}
	
	public function pathGenerator($path)
	{
		$path = $this->clearExtraSlash($path);
		return $this->EDIT_DIRECTORY_SEPARATOR(public_path().DS.$this->uploadDirectory().DS.$path.DS);
	}

	/**
	 * generate destionation path, with File Name
	 * @param  string $fileName 
	 * @param  string $path     
	 * @return string           return fullpath file
	 */
	public function destinationGenerator($fileName, $path)
	{
		$path = $this->clearExtraSlash($path);
		return $this->EDIT_DIRECTORY_SEPARATOR(public_path().DS.$this->uploadDirectory().DS.$path.DS.$fileName);
	}

	/**
	 * clear extra / or \ at first or last file directory
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function clearExtraSlash($input)
	{
		$input = $this->EDIT_DIRECTORY_SEPARATOR($input);
		if ( strpos($input, DS) === 0 ) {
			$input = substr($input, 1);
		}
		if ( strpos($input, DS, strlen($input)-1)) {
			$input = substr($input, 0, strlen($input)-1);
		}
		return $input;
	}

	private function EDIT_DIRECTORY_SEPARATOR($path)
	{
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
		return $path;
	}
}