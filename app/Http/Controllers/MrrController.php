<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\StoreItem;
use App\StoreMrr;
use App\StoreItemSupplier;
use App\StoreTransaction;
use Session;
use Auth;

class MrrController extends Controller
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
            return redirect()->route('store.mrr.edit',$id);
        }
        return redirect()->route('store.mrr.create');
    }

    public function lastBill(){
        $id = StoreMrr::orderBy('id','desc')->first();
        return $id;
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $mrr = StoreMrr::where('user_id', $user_id)->where('post', 0)->orderBy('id','desc')->first();
        //dd($mrr);
        if(!$mrr){
            $item = new StoreMrr;
            $item->user_id=$user_id;
            $item->post=0;
            $item->save();
            $mrr = $item->id;
            }
        return redirect()->route('store.mrr.edit',$mrr);
    }

    public function store(Request $request)
    {
        if($request->bill_status == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('store.mrr.edit',$request->id);
        }
        $item=StoreItem::find($request->item);
        $data = new StoreTransaction;
        $data->Item_id = $request->item;
        $data->qty = $request->qty;
        $data->price = $request->price;
        $data->mrr_id = $request->id;
        $data->save();
        $this->itemIncrement($data->Item_id,$data->qty);
        $this->updatePrice($data->Item_id,$data->price);
        return redirect()->route('store.mrr.edit',$request->id);
    }

    public function billPost(Request $request)
    {
        $data=StoreMrr::find($request->id);
        if($data->post == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('store.mrr.edit',$request->id);
        }

        $data->supplier_id = $request->supplier_id;
        $data->remark = $request->remark;
        $data->post = 1;
        $data->save();
        Session::flash('success','Bill Posted');
        return redirect()->route('store.mrr.edit',$request->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mrr=StoreMrr::find($id);
        if($mrr){
        $supplier = StoreItemSupplier::all();
        $suppliers=array();
        foreach ($supplier as $sup) {
            $suppliers[$sup->id]= $sup->name;
        }
        if($mrr->post == 0){
            $suppliers['']= '------------';
        }
        $items = StoreItem::where('publish',1)->get();
        $StoreTransaction = StoreTransaction::where('mrr_id', $id)->get();
        //dd($StoreTransaction);
        return view('store.mrr')->withMrr($mrr)->withItems($items)->withSuppliers($suppliers)->withTransaction($StoreTransaction);
        }
        else
        {
            Session::flash('warning','Bill Not Found');
            $id = $this->lastBill();
            return redirect()->route('store.mrr.edit',$id);
        }
    }

    public function find(Request $request){
        return redirect()->route('store.mrr.edit',$request->bill_id);
    }

    public function remove($id)
    {
        $item=StoreTransaction::find($id);
        
        $bill=StoreMrr::find($item->mrr_id);
        if($bill->post == 1){
            Session::flash('warning','Bill Already Posted');
            return redirect()->route('store.mrr.edit',$item->mrr_id);
        }
        $this->itemDecrement($item->Item_id,$item->qty);
        $item->delete();
        Session::flash('success','Item Removed');
        return redirect()->route('store.mrr.edit',$item->mrr_id);
    }

    public function itemIncrement($id,$qty)
    {
        StoreItem::where('id',$id)->increment('qty',$qty);
    }

    public function itemDecrement($id,$qty)
    {
        StoreItem::where('id',$id)->decrement('qty',$qty);
    }

    public function updatePrice($id,$price)
    {
        $data=StoreItem::find($id);
        $data->price = $price;
        $data->save();
    }



    // plus 1 By Using increment()
   /* public function countIncrement($id = 1)
    {
        static::where('id',$id)->increment('count',1);
    }
    // plus 1 By Using update()
    public function countIncrementWithUpdate($id = 1)
    {
        static::where('id',$id)->update(['count' => DB::raw('count+1')]);;
    }
    // minus 1 By Using decrement()
    public function countDecrement($id = 1)
    {
        static::where('id',$id)->decrement('count',1);
    }
    // minus 1 By Using update()
    public function countDecrementWithUpdate($id = 1)
    {
        static::where('id',$id)->update(['count' => DB::raw('count-1')]);;
    }*/
}
