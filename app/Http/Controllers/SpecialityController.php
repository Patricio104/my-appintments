<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Speciality;

class SpecialityController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}


   public function index(){
   	$specialities = Speciality::all();
   	return view('specialities.index', compact('specialities'));
   }

	public function create(){
   		return view('specialities.create');
   }  

   private function performValidation(Request $request){
      $rules = [
            'name'=> 'required|min:3' 
         ];
         $messages = [
            'name.required'=> 'Es necesario ingresar un nombre.',
            'name.min'=> 'Como minimo el nombre debe de tener 3 carateres.',
         ];
         $this->validate($request, $rules, $messages);
   }

   public function store(Request $request){
   		//dd($request->all());
         $this->performValidation($request);

   		$speciality = new Speciality();
   		$speciality->name = $request->input('name');
   		$speciality->description = $request->input('description');
   		$speciality->save();//Insert

         $notification='La especialidad se ha registrado correctamente.';

   		return redirect('/specialities')->with(compact('notification'));
   }

   public function edit(Speciality $speciality){
   		return view('specialities.edit', compact('speciality'));
   }

   public function update(Request $request, Speciality $speciality){
   		//dd($request->all());
   		$this->performValidation($request);

   		$speciality->name = $request->input('name');
   		$speciality->description = $request->input('description');
   		$speciality->save();//Update

         $notification='La especialidad se ha actualizado correctamente.';

   		return redirect('/specialities')->with(compact('notification'));
   }

   public function destroy(Speciality $speciality){
      $specialityName=$speciality->name;
      $speciality->delete();

      $notification='La especialidad '.$specialityName.' se ha eliminado correctamente.';

      return redirect('/specialities')->with(compact('notification'));
   }

}
