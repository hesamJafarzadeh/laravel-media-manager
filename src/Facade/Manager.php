<?php
namespace MediaManager\Manager\Facade;
 
use Illuminate\Support\Facades\Facade;
use MediaManager\Manager\Source;

class Manager extends Facade {
    protected static function getFacadeAccessor() { return Source::class; }
}