<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Noticias;


class NoticiasController extends Controller
{
   
    public function index(Request $request)
    {     
        if($request->ajax()){
            return response()->json(Noticias::all(),200);
        }
        else {
            return;
        }
  
    }

    public function store(Request $request)
    {
            
    }
    
    public function show($id)
    {
        
    }

    public function edit($id)
    {
      
    }
    
    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {

    }
}
