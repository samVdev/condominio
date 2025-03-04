<?php
namespace App\Http\Services\Menu;

use App\Http\Validator\Menu\UpdateMenuValidator;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Menu;

class UpdateMenuService
{
 
  static public function execute(UpdateMenuRequest $request, Menu $menu): \Illuminate\Http\JsonResponse
  { 

      $msg  = 'Data incompleta.';

      if ( !UpdateMenuValidator::rule( $request )->fails() ) {      
          $menu->update( $request->except( '_method', 'id' ) );
          $msg  = 'Menu updated.';
      }  

      return response()->json(["message"=> $msg], 200);

  }
    
}
