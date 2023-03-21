<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function showDashboard()
    {
        if(auth()){
            $results = Painting::paginate(30);
            return view('pages.dashboard',compact('results'));
        }
        else{
            dd('here');
            return redirect()->route('show-login');
        }

    }

    public function storePainting(Request $request)
    {
        try {


           $imageName = time() . '.' . $request->file->extension();

           $request->file->move(public_path('images'), $imageName);


           Painting::create([
               'name' => $request->name,
               'description' => $request->description,
               'type' => $request->type,
               'dimensions' => $request->dimensions,
               'price' => $request->price,
               'url' => '/images/' . $imageName,
               'status' => 'available',

           ]);

           return back()->with('success', 'You have successfully upload image.');
       }
       catch (\Exception $e){
           return back()->with('error',$e->getMessage());
       }
    }

    public function editPainting(Request $request)
    {
//        dd($request);
        try {
            $painting = Painting::find($request->id);
            $painting->update([
                'name' => $request->edit_name,
                'description' => $request->edit_description,
                'type' => $request->edit_type,
                'dimensions' => $request->edit_dimensions,
                'price' => $request->edit_price,
            ]);
            return back()->with('success', 'You have successfully edited the painting.');
        }
        catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function hidePainting($id) {
        $painting = Painting::find($id);
        $painting->status = 'hidden';
        $painting->save();
        return back()->with('success','Painting has been hidden from gallery');
    }

    public function deletePainting($id) {
        $painting = Painting::find($id);
        $painting->status = 'deleted';
        $painting->save();
        return back()->with('success','Painting has been deleted');
    }

    public function sellPainting($id) {
       $painting = Painting::find($id);
       $painting->status = 'sold';
       $painting->save();
        return back()->with('success','Painting has been marked as sold');
    }

    public function restorePainting($id) {
        $painting = Painting::find($id);
        $painting->status = 'available';
        $painting->save();
        return back()->with('success','Painting has been marked as available');
    }


    public function showProfile()
    {

    }
}
