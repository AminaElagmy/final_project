<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactUs;


class ContactUsController extends Controller
{
    public function index()
    {
        $contact = ContactUs::get();
        //return $contact;
        return view('contact.index', [
            'contacts' => $contact,  //DBالمفتاح هوا اسم المتغير في ملف الفيو والقيمه هي القيمه الحقيقيه في
            'title' => 'contact Us'
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'    => ['unique:contact_us,name', 'required', 'string', 'min:3'],
            'email'   => ['unique:contact_us,email', 'required', 'email', 'string'],
            'subject' => ['nullable', 'string', 'required'],
            'message' => ['nullable', 'string', 'required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { // هذا السطر وظيفتة ان يقوم با التحقق إذا كان هناك اي خطئ في الفاليديشن ام لا
            return response()->json($validator->errors(), 422);
        }

        $contacts          = new ContactUs();
        $contacts->name    = $request->input('name');
        $contacts->email   = $request->input('email');
        $contacts->subject = $request->input('subject');
        $contacts->message = $request->input('message');
        $contacts->save();

        return response()->json([
            'status' => 201,
            'data'   => $contacts,
        ], 201);
    }

    // public function store(Request $request)
    // {
    //     $rules = [
    //         'name'    => ['unique:contact_us,name', 'required', 'string', 'min:3'],
    //         'email'   => ['unique:contact_us,email', 'required', 'email', 'string'],
    //         'subject' => ['nullable', 'string', 'required'],
    //         'message' => ['nullable', 'string', 'required'],
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) { // هذا السطر وظيفتة ان يقوم با التحقق إذا كان هناك اي خطئ في الفاليديشن ام لا
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $contacts = ContactUs::create([
    //         'name'    => $request->name,
    //         'email'   => $request->email,
    //         'subject' => $request->subject,
    //         'message' => $request->message,
    //     ]);

    //     return response()->json([
    //         'status' => 201,
    //         'data'   => $contacts,
    //     ], 201);
    // }
}
