<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class MetricController extends Controller
    {
        public function handle(Request $request)
        {
            $class = str_replace('-' , '\\' , $request->class);

            if(!class_exists($class)) return 'Metric پیدا نشد';

            if(is_null(\Zoroaster::getDashboardMetricFind(class_basename($class)))) return ' کلاس داخل داشبورد پیدا نشد';

            $newClass = new $class;


//            dd(array_merge((array)$newClass->calculate($request) , [
//                'class' => $class ,
//                'classN' => str_replace('\\' , '-' , $class) ,
//                'ranges' => method_exists($newClass,'ranges')? $newClass->ranges() : null ,
//                'label' => $newClass->label() ,
//                'range' => $request->range ,
//            ]));

            if($newClass->canSee())
                return [
                    'class' => $request->class ,
                    'html' => view('Zoroaster::metrics.' . array_first(explode('-' , $newClass->component)))->with(array_merge((array)$newClass->calculate($request) , [
                        'class' => $class ,
                        'classN' => str_replace('\\' , '_' , $class) ,
                        'ranges' => method_exists($newClass , 'ranges') ? $newClass->ranges() : null ,
                        'label' => $newClass->label() ,
                        'range' => $request->range ,
                    ]))->render()
                ];

//            return response()->json((array)(new $class)->calculate($request));

        }


    }