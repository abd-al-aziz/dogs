<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    public function index() {
        $pageTitle = 'Consultations';
        $consultations = Consultation::with('user')->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.consultations.index', compact('pageTitle', 'consultations'));
    }

    public function show($id) {
        $consultation = Consultation::find($id);
        $pageTitle = trans('Consultation Request From').' '.$consultation->email;
        return view('admin.consultations.show', compact('pageTitle', 'consultation'));
    }

    public function complete($id) {
        $consultation = Consultation::find($id);
        $consultation->status = 1;
        $consultation->save();
        $notify[] = ['success', 'Consultation completed successfully'];
        return back()->withNotify($notify);
    }

    public function search(Request $request) {
        $pageTitle = 'Search results for'.'"'.$request->search.'"';
        $consultations = Consultation::where('email', 'like', "%$request->search%")->orWhere('service_name', 'like', "%$request->search%")->paginate(getPaginate());
        return view('admin.consultations.index', compact('pageTitle', 'consultations'));
    }
}
