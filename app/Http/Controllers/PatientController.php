<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        if ($patients) {

            $data = [
                'message' => 'Get All Resource',
                'data' => $patients,
            ];
            return response()->json([$data, 200]);
        } else {
            $data = [
                'message' => 'Resource not found'
            ];
            return response()->json([$data, 404]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string', 'max:255'],
            'phone' => [ 'required', 'string', 'max:255'],
            'address' => [ 'required','string', 'max:255'],
            'status' => [ 'required', 'string','max:255'],
            'in_date_at' => [ 'required' ,'date'],
            'out_date_at' => [ 'required', 'date',],
        ]);

        $patients = Patient::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at,
        ]);

        if ($patients) {
            return response()->json([
                'message' => 'Resource is added successfully',
                'data' => $patients,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to add resource',
            ], 404);
        }
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $data = [
                'message' => 'Get Details Resource ',
                'data' => $patient,
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $input = [
                'name' => $request->nama ?? $patient->nama,
                'phone' => $request->phone ?? $patient->phone,
                'addres' => $request->addres ?? $patient->addres,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->status,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at,
            ];
            $patient->update($input);
            $data = [
                'message' => 'Resource is updated succesfully',
                'data' => $patient,
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }
    }
    public function destroy($id)
    {
        $patients = Patient::find($id);
        if ($patients) {
            $patients->delete();

            $data = [
                'message' => 'Resource is deleted succesfully',
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }
    }

    public function search($name) {
        $patients = Patient::where('name', 'like', '%' . $name . '%')->get();

        if(!$patients->IsEmpty()){
            return response()->json([
                'message' => 'Get Searched resource',
                'data' => $patients
            ], 404);
        }else{
            return response()->json([
                'message' => 'Searched Not Found',
            ]);
        }
    }
    public function positive($name) {
        $patients = Patient::where('status', 'positive')->get();
        return response()->json([
            'massage' => 'Get Positive resource',
            'total' => $patients->count(),
            'data' => $patients,
        ], 200);
    }
    public function recovere($name) {
        $patients = Patient::where('status', 'recovered')->get();

        if(!$patients->IsEmpty()){
            return response()->json([
                'message' => 'Get Recovered resource',
                'total' => $patients->count(),
                'data' => $patients,
            ], 200);
        }
    }
    public function dead($name) {
        $patients = Patient::where('status', 'dead')->get();


        if(!$patients->IsEmpty()){
            return response()->json([
                'message' => 'Get Recovered resource',
                'total' => $patients->count(),
                'data' => $patients,
            ], 200);
        }   
    }
}
