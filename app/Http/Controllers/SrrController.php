<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\StoreItem;
use App\StoreSrr;
use App\StoreRecipient;
use App\StoreTransaction;
use Session;
use Auth;

class SrrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = $this->lastBill();
        if($id){
            return redirect()->route('store.srr.edit',$id);
        }
        return redirect()->route('store.srr.create');
    }

    public function lastBill(){
        $id = StoreSrr::orderBy('id','desc')->first();
        return $id;
    }

    public function itemIncrement($id,$qty)
    {
        StoreItem::where('id',$id)->increment('qty',$qty);
    }

    public function itemDecrement($id,$qty)
    {
        StoreItem::where('id',$id)->decrement('qty',$qty);
    }

    public function stockCheck($id){
        $item = StoreItem::find($id);
        return $item->qty;
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $srr = StoreSrr::where('user_id', $user_id)->where('post', 0)->orderBy('id','desc')->first();
        //dd($srr);
        if(!$srr){
            $item = new StoreSrr;
            $item->user_id=$user_id;
            $item->post=0;
            $item->save();
            $srr = $item->id;
            }
        return redirect()->route('store.srr.edit',$srr);
    }

    public function store(Request $request)
    {
        if($request->bill_status == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('store.srr.edit',$request->id);
        }

        $qty = $this->stockCheck($request->item);
        if($request->qty > $qty){
            Session::flash('warning','No Stock, Please Check Your Stock');
            return redirect()->route('store.srr.edit',$request->id);
        }

        $item=StoreItem::find($request->item);
        $data = new StoreTransaction;
        $data->Item_id = $request->item;
        $data->qty = $request->qty;
        $data->price = $item->price;
        $data->srr_id = $request->id;
        $data->save();
        $this->itemDecrement($data->Item_id,$data->qty);
        return redirect()->route('store.srr.edit',$request->id);
    }

    public function billPost(Request $request)
    {
        $data=StoreSrr::find($request->id);
        if($data->post == 1){
            Session::flash('warning','Bill Already Posted');
            return $this->edit($request->id);
        }

        $data->recipient_id = $request->recipient_id;
        $data->remark = $request->remark;
        $data->post = 1;
        $data->save();
        Session::flash('success','Bill Posted');
        return redirect()->route('store.srr.edit',$request->id);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $srr=StoreSrr::find($id);
        if($srr){
        $recipient = StoreRecipient::all();
        $recipients=array();
        foreach ($recipient as $sup) {
            $recipients[$sup->id]= $sup->name;
        }
        if($srr->post == 0){ $recipients['']= '------------'; }
        $items = StoreItem::where('publish',1)->get();
        $StoreTransaction = StoreTransaction::where('srr_id', $id)->get();
        //dd($StoreTransaction);
        return view('store.srr')->withSrr($srr)->withItems($items)->withRecipients($recipients)->withTransaction($StoreTransaction);
        }
        else
        {
            Session::flash('warning','Bill Not Found');
            $id = $this->lastBill();
            return redirect()->route('store.srr.edit',$id);
        }
    }

    public function find(Request $request){
        return redirect()->route('store.srr.edit',$request->bill_id);
    }

    public function remove($id)
    {
        $item=StoreTransaction::find($id);
        
        $bill=StoreSrr::find($item->srr_id);
        if($bill->post == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('store.srr.edit',$item->srr_id);
        }
        $this->itemIncrement($item->Item_id,$item->qty);
        $item->delete();
        Session::flash('success','Item Removed');
        return redirect()->route('store.srr.edit',$item->srr_id);
    }

}
