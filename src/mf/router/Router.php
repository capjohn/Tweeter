<?php
namespace mf\router;

class Router extends \mf\router\AbstractRouter {

    //Création d'une route en liant le nom, son url, son controleur, sa vue et son niveau d'accès
    public function addRoute($name, $url, $ctrl, $mth, $niv) {
        self::$routes[$url] = [ $ctrl, $mth, $niv];
        self::$aliases[$name] = $url;
    }

    // Paramètre la route par défaut (home)
    public function setDefaultRoute($url){
        self::$aliases['default'] = $url;
    }

    public function __construct(){
        parent::__construct();
    }


    public function run() { 
        $path_info = $this->http_req->path_info;
        if(array_key_exists($path_info,self::$routes))
        {
            $auth = new \mf\auth\Authentification();
            if($auth->checkAccessRight(self::$routes[$path_info][2]))
            {
                $c_name = self::$routes[$path_info][0];
                $m_name = self::$routes[$path_info][1];
            }
            else{
                $c_name = self::$routes[self::$aliases['default']][0];
                $m_name = self::$routes[self::$aliases['default']][1];
            }  
        }
        else{
            $c_name = self::$routes[self::$aliases['default']][0];
            $m_name = self::$routes[self::$aliases['default']][1];
        }
        $c = new $c_name();
        $c->$m_name();
    }
    
    public function urlFor($route_name, $param_list=[]) {
        if (isset (self::$aliases[$route_name]))
        {
            $url_alias = self::$aliases[$route_name];
            $url = $this->http_req->script_name . $url_alias;
    
            if($param_list != null)
            {
                $url = $url."?";
                foreach($param_list as $param)
                {
                    $url = $url.$param[0]."=".$param[1];
                }
            }
            return $url;
        }
    }
    public static function executeRoute($alias){
        $rname = self::$aliases[$alias];
        $cname = self::$routes[$rname][0];
        $mname = self::$routes[$rname][1];

        $c = new $cname;
        $c->$mname();
    }
}