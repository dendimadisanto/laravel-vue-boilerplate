<?php

namespace App\Repositories;

use App\Contracts\SupplierInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRepo implements SupplierInterface
{   
    public function __construct()
    {
        
    }

    public function getAll()
    {
        return Supplier::all();
    }

    public function create($request)
    {   
        $this->validation($request);
        return Supplier::create($request->all());
    }

    public function delete($id)
    {
        return Supplier::destroy($id);
    }

    public function update($request, $id)
    {   
        $this->validation($request);
        $model = Supplier::find($id);
        return $model->update($request->all());
    }

    public function find($id)
    {
        return Supplier::find($id);
    }

    public function paginate($limit){
        return Supplier::paginate($limit);
    }

    function validation($request){
    	
        $validatedData = $request->validate([
	        'supplier' => 'required',
	        'phone' => 'required',
	        'address' => 'required'
    	]);

    	return $validatedData;
    }
}
