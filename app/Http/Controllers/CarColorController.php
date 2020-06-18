<?php

namespace App\Http\Controllers;

use App\Models\CarColor;
use Illuminate\Http\Request;

class CarColorController extends Controller
{
    public function index()
    {
        $colors = CarColor::all();
        return view('colors.colorList',compact('colors'));
    }

    public function formNew()
    {
        return view('colors.newColor');
    }
    
    public function formEdit($id)
    {
        $color = CarColor::findOrFail($id);
        return view('colors.editColor', compact('color'));
    }

    public function edit(Request $request, $id)
    {   
        
        $data = $request->input();
        $request->validate(CarColor::$rules, CarColor::$messages);

        $color = CarColor::findorFail($id);
        $color->update($data);

        $message = [
            'class'         =>'success',
            'title'         =>'Acción completada!',
            'content'       =>"El color ' . $color->color . '  fue editado exitosamente.",
        ];

        return redirect()
        ->route('colors.index')
        ->with('message', $message);
    }

    public function create(Request $request)
    {
        $data = $request->input();
        $request->validate(CarColor::$rules, CarColor::$messages);

        $color = CarColor::create($data);
        $message = [
            'class'         =>'success',
            'title'         =>'Acción completada!',
            'content'       =>"El color ' . $color->color . ' se insertó exitosamente.",
        ];
        return redirect()
        ->route('colors.index')
        ->with('message', $message);
    }

    public function delete($id)
    {
        $color = CarColor::findorFail($id);
        $c = $color->color;

        try {
            $color->delete();
            $message = [
                'class'         =>'success',
                'title'         =>'Acción completada!',
                'content'       =>"El color $c fue eliminado exitosamente.",
            ];
            return redirect()
            ->route('colors.index')
            ->with('message', $message);
        } catch (\Throwable $th) {
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"El color $c no puede elimarse porque se encuentra asignado.",
            ];
            return redirect()->back()->with('message', $message);
            
        }


    }

}
