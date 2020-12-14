<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabTransaction;
use App\LabInvoice;
use App\LabItem;
use Session;
use Auth;

class LabSrrController extends Controller
{
    public function index()
    {
        $id = $this->lastBill();
        //dd($id);
        if($id > 0){
            return redirect()->route('lab.srr.edit',$id);
        }
        return redirect()->route('lab.srr.create');
    }

    public function lastBill(){
        $id = LabInvoice::where('iType','cell')->orderBy('id','desc')->first();
        if($id){
        	return $id->cell_id;
        }
        return 0;
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $id = $this->lastBill();
        $mrr = LabInvoice::where('user_id', $user_id)->where('iType','cell')->where('post', 0)->orderBy('id','desc')->first();
        //dd($mrr);
        if(!$mrr){
            $data = new LabInvoice;
            $data->user_id=$user_id;
            $data->cell_id=++$id;
            $data->iType='cell';
            $data->post=0;
            $data->save();
            $mrr = $data->cell_id;
            }
        return redirect()->route('lab.srr.edit',$mrr);
    }

    public function edit($id)
    {
        $mrr=LabInvoice::where('cell_id',$id)->first();
        if($mrr){
        	$items = LabItem::all();
        	$StoreTransaction = LabTransaction::where('invoice_id', $mrr->id)->get();
        	//dd($StoreTransaction);
        	return view('lab.srr')->withMrr($mrr)->withItems($items)->withTransaction($StoreTransaction);
        }
        else
        {
            Session::flash('warning','Bill Not Found');
            $id = $this->lastBill();
            return redirect()->route('lab.srr.edit',$id);
        }
    }

    public function itemIncrement($id,$qty)
    {
        LabItem::where('id',$id)->increment('qty',$qty);
    }

    public function itemDecrement($id,$qty)
    {
        LabItem::where('id',$id)->decrement('qty',$qty);
    }
    public function stockCheck($id){
        $item = LabItem::find($id);
        return $item->qty;
    }


    public function store(Request $request)
    {
        if($request->bill_status == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('lab.srr.edit',$request->id);
        }

        $this->validate($request, array(
            'qty'=>'required|numeric',
            ));

        $qty = $this->stockCheck($request->item);
        if($request->qty > $qty){
            Session::flash('warning','No Stock, Please Check Your Stock');
            return redirect()->route('lab.srr.edit',$request->cell_id);
        }

        $item=LabInvoice::find($request->item);
        $data = new LabTransaction;
        $data->Item_id = $request->item;
        $data->qty = $request->qty;
        $data->iType = 'cell';
        $data->invoice_id = $request->id;
        $data->save();
        $this->itemDecrement($data->Item_id,$data->qty);
        return redirect()->route('lab.srr.edit',$request->cell_id);
    }

    public function billPost(Request $request)
    {
        $data=LabInvoice::find($request->id);
        if($data->post == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('lab.srr.edit',$data->cell_id);
        }
        $data->post = 1;
        $data->save();
        Session::flash('success','Bill Posted');
        return redirect()->route('lab.srr.edit',$data->cell_id);
    }


    public function find(Request $request){
        return redirect()->route('lab.srr.edit',$request->bill_id);
    }

    public function remove($id)
    {
        $item=LabTransaction::find($id);
        
        $bill=LabInvoice::find($item->invoice_id);
        if($bill->post == 1){
            Session::flash('warning','Bill Already Posted');
            //return redirect()->route('store.mrr.edit',$bill->id);
            return redirect()->route('lab.srr.edit',$bill->buy_id);
        }
        $this->itemIncrement($item->Item_id,$item->qty);
        $item->delete();
        Session::flash('success','Item Removed');
        return redirect()->route('lab.srr.edit',$bill->cell_id);
    }
}
