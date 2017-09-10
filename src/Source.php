<?php
namespace MediaManager\Manager;

define("DS", DIRECTORY_SEPARATOR);

use MediaManager\Manager\traits\ManagerTrait;
use MediaManager\Manager\traits\Smart;

/**
 * Manage Your Media In Project
 */
class Source
{
    use ManagerTrait, Smart;

    /**
     * store media
     * @param  string $fileName instace from uploaderFile
     * @param  string $path path for destination
     * @return array       fileName, destination File
     */
    public function store($file, $folderName, $fileName )
    {
    	$folderName = $this->clearExtraSlash($folderName);
    	$name = is_callable($fileName) ? $fileName() : $fileName ;
    	$destinationPath = $this->pathGenerator($folderName);
    	$file->move($destinationPath, $name);

    	return [ $name,  $destinationPath ];
    }

    /**
     * delete media
     * @param  string $fileName   file name
     * @param  string $folderName folder name
     * @return var
     */
    public function delete($fileName, $path)
    {
        if (is_array($fileName)) {
            foreach ($fileName as $fn) {
                $destinationPath = $this->destinationGenerator($fn, $path);
                if (file_exists($destinationPath)) {
                    unlink($destinationPath);
                }
            }
        } else {
            $destinationPath = $this->destinationGenerator($fileName, $path);
            if (file_exists($destinationPath)) {
                unlink($destinationPath);
                return 1;
            } else {
                die('Sorry! There is no such file');
            }
        }
    }

    /**
     * for show media in blade
     * @param  string $file
     * @param  string $folderName
     * @return string
     */
    public function show($file, $path)
    {
        if (file_exists($this->destinationGenerator($fileName, $path))) {
            return asset($this->destinationGenerator($fileName, $path));
        } else {
            die('Sorry! There is no such file');
        }
    }

    /**
     * rename file
     * @param  string $oldName oldname, with extension file
     * @param  string $newName newname, without extension file
     * @param  string $path    Location of files
     * @return void
     */
    public function rename($oldName, $newName, $path)
    {
        if (file_exists($this->destinationGenerator($oldName, $path))) {
        	$extension = pathinfo($this->destinationGenerator($oldName, $path))['extension'];
            rename($this->destinationGenerator($oldName, $path), $this->destinationGenerator($newName, $path) . "." . $extension);
        } else {
            die('Sorry! There is no such file');
        }
    }

    /**
     * copy file
     *  Warning : If the destination file already exists, it will be overwritten.
     * @return [type] [description]
     */
    public function copy($file, $source, $dest)
    {
        if (file_exists($this->destinationGenerator($file, $source))) {
            $dest = $this->clearExtraSlash($dest);

            if (is_dir($this->EDIT_DIRECTORY_SEPARATOR(public_path() . DS . $this->uploadDirectory() . DS . $dest))) {
                copy($this->destinationGenerator($file, $source), $this->destinationGenerator($file, $dest));
            } else {
                die("Sorry! no Such This Directory");
            }
        } else {
            die('Sorry! There is no such file');
        }
    }

    /**
     * cut file to new path
     * @param  string $file   namefile
     * @param  string $source path source file
     * @param  string $dest   path destination for replace
     * @return void
     */
    public function cut($file, $source, $dest)
    {
        $this->copy($file, $source, $dest);
        $this->delete($file, $source);
    }
}
