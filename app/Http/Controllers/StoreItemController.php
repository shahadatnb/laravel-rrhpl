<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreItemSupplier;
use App\StoreTransaction;
use App\StoreRecipient;
use App\StoreCategory;
use App\StoreItem;
use App\StoreMrr;
use App\StoreSrr;
use Session;

class StoreItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = StoreCategory::all();
        $items = StoreItem::all();
        //dd($items);

        return view('store.item')->withItems($items)->withCategories($category);
    }

    public function export()
    {
        $items = StoreItem::all();
        $data = '';
        $data .= '<table>
        <thead>
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Unit</th>
          <th>price</th>
          <th>Current Stock</th>
        </tr>
        </thead>
        <tbody>';
        foreach($items as $item){
        $data .='<tr>
          <td>' .$item->id. '</td>
          <td>' .$item->Item. '</td>
          <td>' .$item->StoreCategory->name. '</td>
          <td>' .$item->unit. '</td>
          <td>' .$item->price. '</td>
          <td>' .$item->qty. '</td>
        </tr>';
        }
        $data .= '</tbody>
        <tfoot>
      </table>';
      header('Content-type: application/xls');
      header('Content-Disposition: attachment; filename = product.xls');
      echo $data;
      //return redirect()->route('store.item');
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
            'item'=>'required|max:255|unique:store_items,Item'
            ));

        $item = new StoreItem;
        $item->item=$request->item;
        $item->unit=$request->unit;
        $item->category_id=$request->category_id;
        $item->qty=0;
        $item->price=$request->price;

        $item->save();

        Session::flash('success','The item was Successfully Save');
        return redirect()->route('store.item');
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

    public function ShowHide($id){
        $recipient=StoreItem::find($id);
        if($recipient){

            if ($recipient->publish == 1) {
                if($recipient->qty > 0){
                    Session::flash('warning','Sorry, Can`t Hide');
                    return redirect()->back(); 
                }
                $recipient->publish=0;
            }else{
                $recipient->publish=1;
            }
            $recipient->save();
        }
        return redirect()->back();
    }


    public function destroy($id)
    {
        $item=StoreItem::find($id);
        
        if($item){
            $Transaction=StoreTransaction::where('Item_id',$id)->count();
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

        return redirect()->route('store.item');
    }



    /* ########## Supplier Area ########### */
    public function Supplier(){
        $supplier = StoreItemSupplier::all();
        return view('store.supplier')->withSuppliers($supplier);
    }


    public function storeSupplier(Request $request){
        $this->validate($request, array(
            'name'=>'required|max:255|unique:store_item_suppliers,name'
            ));

        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        \DB::table('store_item_suppliers')->insert($data);

        Session::flash('success','The Supplier name was Successfully Save');

        return redirect()->route('store.supplier');
    }

    public function supplierRemove($id)
    {
        $supplier=StoreItemSupplier::find($id);
        
        if($supplier){
            $mrr=StoreMrr::where('supplier_id',$id)->count();            
            if($mrr > 0){
                Session::flash('warning','This Item already used, you can’t delete it.');
            }
            else{
                $supplier->delete();
                Session::flash('success','Supplier Removed');
            }             
        }
        else{
            Session::flash('warning','Not Found');
            }

        return redirect()->route('store.supplier');
    }

    /* ########## Recipients Area ########### */

    public function Recipients(){
        $recipients = StoreRecipient::all();
        return view('store.recipients')->withRecipients($recipients);
    }


    public function storeRecipient(Request $request){
        $this->validate($request, array(
            'name'=>'required|max:255|unique:store_recipients,name'
            ));

        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        \DB::table('store_recipients')->insert($data);
        //DB::table('shipping')->insertGetId($data);

        Session::flash('success','The Recipient name was Successfully Save');
        return redirect()->route('store.recipient');
    }

    public function recipientRemove($id)
    {
        $recipient=StoreRecipient::find($id);
        
        if($recipient){
            $Transaction=StoreSrr::where('recipient_id',$id)->count();
            if($Transaction > 0){
                Session::flash('warning','This Item already used, you can’t delete it.');
            }
            else{
                $recipient->delete();
                Session::flash('success','Recipient Removed');
            }             
        }
        else{
            Session::flash('warning','Not Found');
            }

        return redirect()->route('store.recipient');
    }

    /* ########## Category Area ########### */

    public function Category(){
        $category = StoreCategory::all();
        return view('store.category')->withCategories($category);
    }


    public function StoreCategory(Request $request){
        $this->validate($request, array(
            'name'=>'required|max:255|unique:store_categories,name'
            ));

        $data = array();
        $data['name'] = $request->name;
        \DB::table('store_categories')->insert($data);
        //DB::table('shipping')->insertGetId($data);

        Session::flash('success','The Category name was Successfully Save');
        return redirect()->route('store.category');
    }

    public function categoryRemove($id)
    {
        $category=StoreCategory::find($id);
        
        if($category){
            $item=StoreItem::where('category_id',$id)->count();
            if($item > 0){
                Session::flash('warning','This Item already used, you can’t delete it.');
            }
            else{
                $category->delete();
                Session::flash('success','Category Removed');
            }             
        }
        else{
            Session::flash('warning','Not Found');
            }

        return redirect()->route('store.category');
    }
}
