<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DetachmentRequest;
use App\Detachment;

class DetachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detachments = Detachment::all();
        return view('detachments.detachments', ['detachments' => $detachments]);
    }

    public function search(Request $request) {
        $request->validate([
            'q' => 'required'
        ]);
        $detachments = Detachment::where('name', 'like', "%{$request->q}%")
            ->orWhere('address', 'like', "%{$request->q}%")
            ->get();
        return view('detachments.detachments', ['detachments' => $detachments, 'query' => $request->q]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('detachments.detachment', ['edit' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetachmentRequest $request)
    {
        Detachment::create($request->all());
        return redirect('/detachments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detachment = Detachment::find($id);
        if (!$detachment) {
            return redirect('/detachments');
        }
        return view('detachments.detachment', ['edit' => $detachment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetachmentRequest $request, $id)
    {
        $detachment = Detachment::find($id);
        if (!$detachment) {
            return redirect('/detachments');
        }
        $detachment->update($request->all());
        return redirect("/detachments/{$id}")->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detachment = Detachment::find($id);
        if (!$detachment) {
            return redirect('/detachments');
        }
        $detachment->deleted_by = Auth::user()->id;
        $detachment->save();
        $detachment->delete();
        return redirect('/detachments');
    }
}
