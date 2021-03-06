<?php

    namespace KarimQaderi\Zoroaster;


    class Zoroaster
    {

        private static $resourcesByModel = [];
        private static $resources = [];

//        public static function routes()
//        {
//            return require __DIR__ . '/../routes/routes.php';
//        }

        public static function routeConfiguration()
        {
            return [
                'namespace' => '\KarimQaderi\Zoroaster\Http\Controllers' ,
                'domain' => config('Zoroaster.domain' , null) ,
                'as' => 'Zoroaster.' , // Route name
                'prefix' => 'Zoroaster' ,
                'middleware' => 'can:viewZoroaster' ,
            ];
        }


        public static function newResource($resource)
        {
            $resource = config('Zoroaster.Resources') . $resource;
            if(class_exists($resource))
                return new $resource;
            else
                return null;
        }

        public static function hasNewResourceByModelName($model)
        {
            if(empty($model)) return false;

            if(class_exists(\Zoroaster::getFullNameResourceByModelName($model)))
                return true;
            else
                return false;
        }

        public static function newResourceByModelName($modelName)
        {
            return \Zoroaster::newResourceByModelName($modelName);
        }

        public static function newModel($model)
        {
            if(class_exists($model))
                return new $model;
            else
                return null;
        }

        public static function viewRender($view)
        {
            return $view->render();
        }


        public static function findAllResource()
        {
            $namespace  = str_replace_last('\\' , '' , config('Zoroaster.Resources'));
            $Re = str_replace_first('App' , 'app' , $namespace);

            return self::finderAllClassByPath($namespace , $Re);
        }

        public static function finderAllClassByPath($namespace = '' , $path = '')
        {
            $finder = new \Symfony\Component\Finder\Finder();
            $finder->files()->in(base_path($path));

            $find = [];
            foreach($finder as $file){
                $ns = $namespace;
                if($relativePath = $file->getRelativePath()){
                    $ns .= '\\' . strtr($relativePath , '/' , '\\');
                }
                $class = $ns . '\\' . $file->getBasename('.php');

                $r = new \ReflectionClass($class);

                $find[] = $r->getName();

            }

            return $find;
        }


    }