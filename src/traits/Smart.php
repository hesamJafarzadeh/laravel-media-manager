<?php namespace MediaManager\Manager\traits;

trait Smart
{
    /**
     * smart store file
     * @param object $file       
     * @param string $folderName path for save file 
     * @param string|callback $fileName   name For file
     */
    public function SmartStore($file, $folderName, $fileName )
    {
    	$folderName = $this->clearExtraSlash($folderName);
    	$name = is_callable($fileName) ? $fileName() : $fileName ;
    	$destinationPath = $this->SmartPathGenerator($file, $folderName);
        $file->move($destinationPath, $name);

        return [$name, $destinationPath];
    }
    /**
     * set palce that save file
     * @param  string $folderName folder for save
     * @return string
     */
    public function SmartPathGenerator($file, $folderName)
    {
        $this->path = public_path().DS . $this->uploadDirectory() . DS . $folderName . DS . $this->detectType($file, $folderName) . DS;
        return $this->EDIT_DIRECTORY_SEPARATOR($this->path);
    }

    /**
     * detect file type for smart store
     * @param  object OR string     $file file: UploadFiler Or nameFile(String)
     * @return string       return type file : image, video, pdf or ...
     */
    public function detectType($file, $folderName)
    {
    	if(is_object($file))
    	{
    		$extension = $file->getMimeType();
    	}
    	else{
    		die('file must instance from uploaderFile');
    	}

    	if( in_array($extension, config('manager.image')) )
    	{
    		self::$type = 'image';
    	}
    	else if( in_array($extension, config('manager.archive')) )
    	{
    		self::$type = 'archive';
    	}
    	else if( in_array($extension, config('manager.audio')) )
    	{
    		self::$type = 'audio';
    	}
    	else if( in_array($extension, config('manager.video')) )
    	{
    		self::$type = 'video';
    	}
    	else if( in_array($extension, config('manager.adobe')) )
    	{
    		self::$type = 'adobe';
    	}
    	else if( in_array($extension, config('manager.office')) )
    	{
    		self::$type = 'office';
    	}
    	else if( in_array($extension, config('manager.text')) )
    	{
    		self::$type = 'text';
    	}
    	else if( in_array($extension, config('manager.programming')) )
    	{
    		self::$type = 'programming';
    	}
    	else{
    		self::$type = 'other';
    	}
    	return self::$type;
    }

    /**
     * SMART COPY
     * The difference between this function and the normal copy is that, if destination directory not exists, this function creates it and then continue
     * @param  string $file   file name
     * @param  string $source path source file
     * @param  string $dest   path for destination
     * @return void  
     */
    public function SmartCopy($file, $source, $dest)
    {
        if (file_exists($this->destinationGenerator($file, $source))) {
            $dest = $this->clearExtraSlash($dest);

            if (!is_dir($this->EDIT_DIRECTORY_SEPARATOR(public_path() . DS . $this->uploadDirectory() . DS . $dest))) {
                // create directory if not exists
                mkdir($this->EDIT_DIRECTORY_SEPARATOR(public_path() . DS . $this->uploadDirectory() . DS . $dest));
            }
            copy($this->destinationGenerator($file, $source), $this->destinationGenerator($file, $dest));
        } else {
            die('Sorry! There is no such file');
        }
    }

    /**
     * SmartCut Such as Smart Copy, when the destination folder does not exist, creates that and continue
     */
    public function SmartCut($file, $source, $dest)
    {
        $this->SmartCopy($file, $source, $dest);
        $this->delete($file, $source);
    }
}
