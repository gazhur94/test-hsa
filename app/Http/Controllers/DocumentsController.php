<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\File;
use PDF;
use Storage;

class DocumentsController extends Controller
{
    public function index()
    {
        return view('welcome', ['documents' => Document::get()]);
    }

    public function getAll()
    {
        return ['documents' => Document::get()];
    }

    public function getById(Request $request)
    {
        return Document::with('files')->find($request->id);
    }

    public function copy(Request $request)
    {
        $document = Document::find($request->id);
        $newDocument = $document->replicate();
        $newDocument->save();

        foreach($document->files as $file){
            $newFile = $file->replicate();
            $newFile->document_id = $newDocument->id;
            $newFile->save();
        }

        copy(public_path().'/storage/uploads/document_'.$document->id.'.pdf', public_path().'/storage/uploads/document_'.$newDocument->id.'.pdf');

        return 'copied';
    }

    public function delete(Request $request)
    {
        Document::destroy($request->id);
        return 'deleted';
    }

    public function upload(Request $request)
    {
        $path = $request->file('file')->store('uploads', 'public');
        return ['path' => $path];
    }

    public function saveChanges(Request $request)
    {
        if ($request->id == 0) {
            $document = new Document();
        } else {
            $document = Document::findOrFail($request->id);
        }
        $document->name = $request->name;
        $document->save();
        foreach ($request->filesPdf as $file) {
            $newFile = new File();
            $newFile->name = $file['name'];
            $newFile->path = $file['path'];
            $newFile->document_id = $document->id;
            $newFile->save();
        }

        $pdf = PDF::loadView('pdf', ['document' => Document::with('files')->find($document->id) ])->save( 'storage/uploads/document_'.$document->id.'.pdf' );


        return $pdf->download('invoice.pdf');
        return 'saved';
    }



}
