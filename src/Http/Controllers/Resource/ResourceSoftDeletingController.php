<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceSoftDeletingController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            $cols = null;
            $col = null;
            foreach(request()->resourceId as $id)
            {

                $find = $request->newModel()->where([$request->newModel()->getKeyName() => $id])->first();

                if(is_null($find)) break;

                if($request->Resource()->authorizedToDelete($find))
                    $find->delete();

                $col = \Zoroaster::ResourceActions($request , $find ,
                    $request->newModel() , 'Index' , $request->ResourceFields(function($field)
                    {
                        if($field !== null && $field->showOnIndex == true)
                            return true;
                        else
                            return false;
                    })
                );

                $cols [] = [
                    'id' => $find->{$request->newModel()->getKeyName()} ,
                    'col' => $col ,
                    'status' => 'ok',
                ];


            }


            if(request()->has('redirect'))
                redirect(request()->redirect)->with([
                    'success' => 'منبع مورد نظر حذف شد',
                ])->send();

            return response($cols);
        }


    }