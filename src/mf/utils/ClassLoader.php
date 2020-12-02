<?php

namespace mf\utils;
class ClassLoader extends AbstractClassLoader{
    protected function GetFilename(string $classname) :string
    {
        $chemin = str_replace("\\",DIRECTORY_SEPARATOR,$classname);
        $chemin .= ".php";
        return $chemin;
    }
    protected function makePath(string $filename) :string
    {
        $filename = $this->prefix.DIRECTORY_SEPARATOR.$filename;
        return $filename;
    }
    public function loadClass(string $classname)
    {
        $filename = $this->GetFilename($classname);
        $path = $this->makePath($filename);
        if(file_exists($path)){
            require_once $path;
        }
    }
}