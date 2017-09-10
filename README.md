# Laravel Media Manager 1.0.0
This Package Created, For Manage Media and file in your Project

Working with this package is very simple so let's start learning



### Installation

Require the package in your composer.json and update your dependency with composer update:
```
"require": {
...
"laravel-media-manager/manager": "dev-master",
...
},
```

Add the package to your application service providers in `config/app.php`.
```
'providers' => [

'Illuminate\Foundation\Providers\ArtisanServiceProvider',
'Illuminate\Auth\AuthServiceProvider',
...
'MediaManager\Manager\ManagerServiceProvider::class',
],
```
    

then add this line to **aliases** array in the `config/app.php` file :
```
'MediaManager' => MediaManager\Manager\Facade\Manager::class,
```

# Documentation

first of all, at this package, assumed `public > upload` directory  is Root directory for destination place for files uploaded and You should not mention it in the address
*for example: public/upload/product/7/image/picture.jpg*

just you write :

```
MediaManager::store($request->file('file'), 'product/7/image', 'picture.jpg');
```


But you can change this logic By change into config.php file with this command :
```
php artisan publish:config
```

for use this package must be imported it, so write this command after namespace

import Facade  :
`use MediaManager;`
## Store
you can manage saving file with `store` method :

when get file with $request->file('file'), use this :

MediaManager::store(UploadedFile $file, String $destinationPath, String $name);

for example, we want save file into `upload/product/7/image`,

```
MediaManager::store($request->file('file'), 'product/7/image', 'picture.jpg');
```

Maybe you want to make changes to the file name, to do this, use the closure instead of the third argument
```
$baseName  = $request->file('file')->getClientOriginalName();
list($fileName, $destinationPath) = MediaManager::store($request->file('file'), 'product/7/image', function() use ($baseName){ 
        return 'company_name_'.time().'_'.$baseName;
});
```
The file is stored in the destination path and these values are returned:
```
{
    "company_name_1504896197_picture.png",
    "yourSite.com\upload\product\7\image\"
}
```

Notice: all paths under are equal :
* `product/7/image` 
* `/product/7/image/`
* `/product/7/image`
* `product/7/image/`

## Delete


for delete file, name and file path is enough:

```
MediaManager::delete('picture.jpg', 'product/7/image');
```

or given array

```
MediaManager::delete(['picture1.jpg', 'picture2.jpg'], 'product/7/image');
```


## Rename


for rename file, give to `rename` method 3 parameters : 

first parameter : oldName or Now Name

second parameter : new Name 

third parameter: path file

for example:

```
MediaManager::rename('oldName.jpg', 'newName', 'product/7/image');
```
      
###### *Notice*: You must not include a suffix for the new name, the suffix is determined by the old name


## Copy

>*Warning:* If the destination file already exists, it will be overwritten.

for copy file, give to `copy` method 3 parameters : 

first parameter : file name

second parameter : now path 

third parameter : new path

for example:

```
MediaManager::copy('picture.jpg', 'product/7/image', 'product/49/image');
```
      
      

## Cut


for cut file,such as copy, give 3 parameters  to `cut` method  : 

first parameter : file name

second parameter : now path 

third parameter : new path

for example:

```
MediaManager::cut('picture.jpg', 'product/7/image', 'product/49/image');
```
      
      
# Smart Methods

## Smart Store
In the SmartStore method, the file type is examined using the mimetype and based on its type, the folder is created and you do not need to consider a folder for a particular type in the declaration.
for example if file is one of these mime type:
        'image/jpeg',
        'image/jpeg',
        'image/jpeg',
        'image/gif',
        'image/bmp',
        'image/vnd.microsoft.icon',
        'image/tiff',
        'image/tiff',
        'image/svg+xml',
        'image/svg+xml'
        
In fact, a folder called the `image` is created and used for storing, and you give this path to method `product/7` instead `product/7/image`


MediaManager::store(UploadedFile $file, String $destinationPath, String $name);

for example, we want save file into `upload/product/7/image`,

```
MediaManager::SmartStore($request->file('file'), 'product/7', 'picture.jpg');
```

Maybe you want to make changes to the file name, to do this, use the closure instead of the third argument
```
$baseName  = $request->file('file')->getClientOriginalName();
list($fileName, $destinationPath) = MediaManager::store($request->file('file'), 'product/7', function() use ($baseName){ 
        return 'company_name_'.time().'_'.$baseName;
});
```
The file is stored in the destination path and these values are returned:
```
{
    "company_name_1504896197_picture.png",
    "yourSite.com\public\upload\product\7\image\"
}
```


## Smart Copy
In the `copy` and `cut` method, the destination path must exist, and if it does not, you will get a mistake. In the smart way, if the destination does not exist, it initially creates it and then continues.

>*Warning:* If the destination file already exists, it will be overwritten.

parameters are such as normal copy :

```
MediaManager::SmartCopy('picture.jpg', 'product/7/image', 'product/49/image');
```
      
      

## Smart Cut


parameters are such as normal cut :

```
MediaManager::SmartCut('picture.jpg', 'product/7/image', 'product/49/image');
```
      # laravel-media-manager
