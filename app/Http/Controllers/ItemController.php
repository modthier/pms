<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.index')->with('items',Item::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'item' => 'required'
        ]);

        $data = [
            'item' => $request->item,
            'permission' => $request->permission
        ];
        
        if(Item::create($data)){
            $request->session()->flash('success','Item  has been Saved');
            return redirect()->route('item.index');
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('item.create');
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit')->with(['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request,[
            'item' => 'required',
            'permission' => 'required'
        ]);

        $data = [
            'item' => $request->item,
            'permission' => $request->permission
        ];
        
        if($item->update($data)){
            $request->session()->flash('success','Item  has been Updated');
            return redirect()->route('item.index');
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('item.edit',$expense->id);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
