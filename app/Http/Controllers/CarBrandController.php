<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function index()
    {   
        $brands = CarBrand::all();
        return view('brands.brandList', compact('brands'));
    }

    public function formNew()
    {
        return view('brands.newBrand');
    }

    public function formEdit($id)
    {
        $brand = CarBrand::findOrFail($id);
        return view('brands.editBrand', compact('brand'));    
    }

    public function edit(Request $request, $id)
    {   
        
        $data = $request->input();
        $request->validate(CarBrand::$rules, CarBrand::$messages);

        $brand = CarBrand::findorFail($id);
        $brand->update($data);

        $message = [
            'class'         =>'success',
            'title'         =>'Acción completada!',
            'content'       =>"La marca ' . $brand->brand . '  fue editada exitosamente.",
        ];
        return redirect()
        ->route('brands.index')
        ->with('message', $message);
    }

    public function create(Request $request)
    {
        $data = $request->input();
        $request->validate(CarBrand::$rules, CarBrand::$messages);

        $brand = CarBrand::create($data);
        $message = [
            'class'         =>'success',
            'title'         =>'Acción completada!',
            'content'       =>"La marca ' . $brand->brand . ' se insertó exitosamente.",
        ];
        return redirect()
        ->route('brands.index')
        ->with('success', $message);
    }

    public function delete($id)
    {
        $brand = CarBrand::findorFail($id);
        $marca = $brand->brand;
        
        try {
        $brand->delete();
        $message = [
            'class'         =>'success',
            'title'         =>'Acción completada!',
            'content'       =>"La marca $marca fue eliminada exitosamente.",
        ];
        return redirect()->route('brands.index')->with('message', $message);
        } catch (\Throwable $th) {
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"La marca $marca no se puede eliminar porque se encuentra asignada a un vehículo.",
            ];
            return redirect()->route('brands.index')->with('message', $message);
        }
        
        

    }
}
