<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabTransaction;
use App\LabInvoice;
use App\LabItem;
use Session;
use Auth;

class LabMrrController extends Controller
{
    public function index()
    {
        $id = $this->lastBill();
        //dd($id);
        if($id > 0){
            return redirect()->route('lab.mrr.edit',$id);
        }
        return redirect()->route('lab.mrr.create');
    }

    public function lastBill(){
        $id = LabInvoice::where('iType','buy')->orderBy('id','desc')->first();
        if($id){
        	return $id->buy_id;
        }
        return 0;
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $id = $this->lastBill();
        $mrr = LabInvoice::where('user_id', $user_id)->where('iType','buy')->where('post', 0)->orderBy('id','desc')->first();
        //dd($mrr);
        if(!$mrr){
            $data = new LabInvoice;
            $data->user_id=$user_id;
            $data->buy_id=++$id;
            $data->iType='buy';
            $data->post=0;
            $data->save();
            $mrr = $data->buy_id;
            }
        return redirect()->route('lab.mrr.edit',$mrr);
    }

    public function edit($id)
    {
        $mrr=LabInvoice::where('buy_id',$id)->first();
        if($mrr){
        	$items = LabItem::all();
        	$StoreTransaction = LabTransaction::where('invoice_id', $mrr->id)->get();
        	//dd($StoreTransaction);
        	return view('lab.mrr')->withMrr($mrr)->withItems($items)->withTransaction($StoreTransaction);
        }
        else
        {
            Session::flash('warning','Bill Not Found');
            $id = $this->lastBill();
            return redirect()->route('lab.mrr.edit',$id);
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


    public function store(Request $request)
    {
        if($request->bill_status == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('lab.mrr.edit',$request->id);
        }

        $this->validate($request, array(
            'qty'=>'required|numeric',
            'expiryDate'=>'required|date_format:Y-m-d',
            ));

        $item=LabInvoice::find($request->item);
        $data = new LabTransaction;
        $data->Item_id = $request->item;
        $data->qty = $request->qty;
        $data->iType = 'buy';
        $data->expiryDate = $request->expiryDate;
        $data->invoice_id = $request->id;
        $data->save();
        $this->itemIncrement($data->Item_id,$data->qty);
        return redirect()->route('lab.mrr.edit',$request->buy_id);
    }

    public function billPost(Request $request)
    {
        $data=LabInvoice::find($request->id);
        if($data->post == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('lab.mrr.edit',$data->buy_id);
        }
        $data->post = 1;
        $data->save();
        Session::flash('success','Bill Posted');
        return redirect()->route('lab.mrr.edit',$data->buy_id);
    }


    public function find(Request $request){
        return redirect()->route('lab.mrr.edit',$request->bill_id);
    }

    public function remove($id)
    {
        $item=LabTransaction::find($id);
        
        $bill=LabInvoice::find($item->invoice_id);
        if($bill->post == 1){
            Session::flash('warning','Bill Already Posted');
            //return redirect()->route('store.mrr.edit',$bill->id);
            return redirect()->route('lab.mrr.edit',$bill->buy_id);
        }
        $this->itemDecrement($item->Item_id,$item->qty);
        $item->delete();
        Session::flash('success','Item Removed');
        return redirect()->route('lab.mrr.edit',$bill->buy_id);
    }
}
