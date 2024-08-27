<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguagesRequest;
use App\Http\Requests\UpdateLanguagesRequest;
use App\Models\Languages;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Languages::get();

        return view('languages.index')->with('languages', $languages);
    }

    public function create()
    {
        return view('languages.insert');
    }

    public function store(Request $request)
    {
        // dd($request);
        $language = new Languages();
        $rules = [
            'field_name' => 'required',
            'lang' => 'required',
            'translation' => 'required|unique:languages',
        ];
        $this->validate($request, $rules);
        $language->field_name = $request->field_name;
        $language->lang = $request->lang;
        $language->translation = $request->translation;
        $language->save();
        return redirect()->back()->with('success', 'Translation Added Successfully.');
    }

    public function update(Request $request, $id)
    {
        // return $id;
        $language = Languages::find($id);
        // dd($request->lang);
        $rules = [
            'field_name' => 'required',
            'lang' => 'required',
            'translation' => 'required|unique:languages',
        ];
        $this->validate($request, $rules);
        $language->field_name = $request->field_name;
        $language->lang = $request->lang;
        $language->translation = $request->translation;
        $language->update();

        return redirect()->back()->with('success', 'Translation has been Updated Successfully');
    }

    public function edit($id)
    {
        $language = Languages::find($id);
        return view('languages.update')->with('language', $language);
    }
}
