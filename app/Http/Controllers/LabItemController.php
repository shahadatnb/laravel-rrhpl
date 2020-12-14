<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabTransaction;
use App\LabItem;
use Session;

class LabItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = LabItem::all();
        //dd($items);

        return view('lab.item')->withItems($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'item'=>'required|max:255|unique:lab_items,Item'
            ));

        $item = new LabItem;
        $item->item=$request->item;
        $item->unit=$request->unit;
        $item->qty=0;

        $item->save();

        Session::flash('success','The item was Successfully Save');

        return redirect()->route('lab.item');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($task_id){
        $task = StoreItem::find($task_id);
        return \Response::json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$task_id){ // request->
        $task = StoreItem::find($task_id);

        if($request->category_id != null){
            $task->category_id = $request->category_id;
        }

        if($request->unit != null){
           $task->unit = $request->unit; 
        }
                
        $task->price = $request->price;
        $task->save();
        return \Response::json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=LabItem::find($id);
        
        if($item){
            $Transaction=LabTransaction::where('Item_id',$id)->count();
            if($Transaction > 0){
                Session::flash('warning','This Item already used, you can’t delete it.');
            }
            else{
                $item->delete();
                Session::flash('success','Item Removed');
            }             
        }
        else{
            Session::flash('warning','Item Not Found');
            }

        return redirect()->route('lab.item');
    }
}
