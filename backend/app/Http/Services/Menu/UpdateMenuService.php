<?php
namespace App\Http\Services\Menu;

use App\Http\Requests\Menu\FormMenuRequest;
use App\Models\Menu;

class UpdateMenuService
{
 
  static public function execute(FormMenuRequest $request, Menu $menu): \Illuminate\Http\JsonResponse
  { 

      $menu->update($request->except( '_method', 'id' ) );
      return response()->json(["message"=> 'Se ha actualizado correctamente el menu.'], 200);

  }
    
}
