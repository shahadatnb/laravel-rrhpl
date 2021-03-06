<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\StoreItem;
use App\StoreSrr;
use App\StoreMrr;
use App\StoreRecipient;
use App\StoreTransaction;
use Session;
use Auth;
use DB;

class StoreReportController extends Controller
{
    public function __construct()
    {   
        set_time_limit(8000000);
        if(!Session::has('from_date') || !Session::has('to_date')){
          Session::put('from_date', date('Y-m-d'));
          Session::put('to_date', date('Y-m-d'));
          //Session::put('from_date', date('Y-m-d'));
          //Session::put('to_date', date('Y-m-d'));
        }
    }

    public function index(){
        $report['from_date'] = Session::get('from_date');
        $report['to_date'] = Session::get('to_date');
        $report['item'] = Session::get('item');
        $item = StoreItem::all();
        $items=array();
        foreach ($item as $sup) {
            $items[$sup->id]= $sup->Item;
        }
    	return view('store.report')->withItems($items)->withReport($report);
    }

    public function stockUpdate(){
        $items = StoreItem::all();
        foreach ($items as $item) {
            $stock = StoreTransaction::where('Item_id',$item->id)->where('mrr_id','>',0)->sum('qty');
            $stock -= StoreTransaction::where('Item_id',$item->id)->where('srr_id','>',0)->sum('qty');
            //echo $stock.'<br>';
            DB::table('store_items')
            ->where('id', $item->id)
            ->update(['qty' => $stock]);
        }
        return redirect()->back();
    }

    public function view($slug){

        switch ($slug) {
            case 'cureent_stock':
                /*$report = DB::table('store_items')
                    ->leftJoin('store_transactions', function ($join){
                        $join->on('store_items.id', '=', 'store_transactions.Item_id')
                        ->where('store_transactions.mrr_id','>',0)
                        ->latest()->take(1);
                    })
                    //->join('store_transactions', 'store_items.id', '=', 'store_transactions.Item_id')
                    ->join('store_mrrs', 'store_mrrs.id', '=', 'store_transactions.mrr_id')
                    ->select('store_items.*', 'store_mrrs.id as mrr_id', 'store_mrrs.created_at as mrr_date')
                    ->get();*/
                $report = StoreItem::where('publish',1)->get();
                //dd($report);
                $title='Current Stock';
                return view('store.report.stock',compact('title','report'));
                break;
            case 'stock_period':
                $items = StoreItem::where('publish',1)->orderBy('Item')->get();
                $report = array();
                $totalBalance = 0;
                $totalCostIssue = 0;
                $totalCostClosing = 0;
                foreach($items as $key=>$item){
                    $opening = StoreTransaction::where('Item_id',$item->id)->whereDate('created_at','<',$this->fromDate())->where('mrr_id','>',0)->sum('qty');
                    $opening -= StoreTransaction::where('Item_id',$item->id)->whereDate('created_at','<',$this->fromDate())->where('srr_id','>',0)->sum('qty');
                    
                    $from_date = $this->getFromDate();
                    $to_date = $this->getToDate();
                    $mrr = StoreTransaction::where('mrr_id','>',0)->where('Item_id',$item->id)->whereBetween('created_at', array($from_date, $to_date))->sum('qty');
                    $srr = StoreTransaction::where('srr_id','>',0)->where('Item_id',$item->id)->whereBetween('created_at', array($from_date, $to_date))->sum('qty');

                    $balance = $opening+$mrr-$srr;
                    $costIssue = $item->price*$srr;
                    $costClosing = $item->price*$balance;
                    //$totalBalance += $balance;
                    $totalCostIssue += $costIssue;
                    $totalCostClosing += $costClosing;
                    $report[$key] = ['id'=>$item->id,'Item'=>$item->Item,'opening'=>$opening,'receive'=>$mrr,'issue'=>$srr,'balance'=>$balance,
                    'price'=>$item->price,'costIssue'=>$costIssue,'costClosing'=>$costClosing];
                }
                //dd($report);
                $title='Stock of a Period';
                return view('store.report.stock_period',compact('report','totalBalance','totalCostIssue','totalCostClosing','title'));
                break;
            case 'stock_date':
                $report = DB::table('store_items')
                        ->leftJoin('store_transactions')
                        ->get();
                //$report = StoreItem::all();
                dd($report);
                return view('store.report.stock',compact('title','report'));
                break;
            case 'mrr_period':
                $from_date = $this->getFromDate();
                $to_date = $this->getToDate();
                $report = StoreTransaction::where('mrr_id','>',0)->whereBetween('created_at', array($from_date, $to_date))
                ->orderBy('created_at','desc')
                ->get();//->groupBy('Item_id');
                //$report = $r->groupBy('Item_id');
                //dd($report);
                $title= trans('language.mrr').' of a Period';
                return view('store.report.mrr_by_category',compact('title','report'));
                break;
            case 'srr_period':
                $from_date = $this->getFromDate();
                $to_date = $this->getToDate();
               // $report = StoreTransaction::where('srr_id','>',0)->whereBetween('created_at', array($from_date, $to_date))->get();
                $report = DB::table('store_transactions')
                ->join('store_srrs', 'store_srrs.id', '=', 'store_transactions.srr_id')
                ->join('store_recipients', 'store_srrs.recipient_id', '=', 'store_recipients.id')
                ->join('store_items', 'store_transactions.Item_id', '=', 'store_items.id')
                ->select('store_transactions.*', 'store_srrs.id', 'store_srrs.remark', 'store_recipients.name', 'store_recipients.address', 'store_items.Item', 'store_items.unit')
                ->whereBetween('store_transactions.created_at', array($from_date, $to_date))
                ->orderBy('store_transactions.created_at','desc')
                ->get();
                //dd($report);
                $title= trans('language.srr').' of a Period';
                return view('store.report.srr_by_recep',compact('title','report'));
                break;
            case 'item_ledger':
                $from_date = $this->getFromDate();
                $to_date = $this->getToDate();
                $item = Session::get('item');
                $itemName = StoreItem::find($item);
                $q = StoreTransaction::where('Item_id', $item)->where('created_at', '<', $to_date )->where('mrr_id','>',0)->sum('qty');//
                $q2=StoreTransaction::where('Item_id', $item)->where('created_at', '<', $to_date )->where('srr_id','>',0)->sum('qty');

                $report = StoreTransaction::where('Item_id', $item)
                        ->whereBetween('created_at', array($from_date, $to_date))
                        ->orderBy('created_at','desc')
                        ->get();
                $total= $q-$q2;
                $itemname = $itemName->Item;
                $title='Unposted Bill';
                return view('store.report.item_ledger',compact('title','report','total','itemname'));
                break;
            case 'unposted_bill':
                $mrr = StoreMrr::where('post',0)->get();
                $srr = StoreSrr::where('post',0)->get();
                $title='Unposted Bill';
                return view('store.report.unposted_bill',compact('title','mrr','srr'));
                break;
        }

    }

    public function setDate(Request $request){
        Session::forget('item');
        Session::forget('from_date');
        Session::forget('to_date');
        //$from_date = date_create($request->from_date);
        Session::put('item', $request->item );
        Session::put('from_date', $request->from_date );
        //Session::put('from_date', date_create($request->from_date) );
        Session::put('to_date', $request->to_date );
        return redirect()->route('store.report');
    }

    private function getFromDate(){
        //$from_date = Session::get('from_date');
        //$from_date = date_create($from_date);
        //return Carbon::parse($from_date)->format('d/m/Y');
        //return date_format($from_date, 'Y-m-d');
        //return Carbon::createFromFormat('Y-m-d', '11/06/1990');
        return Session::get('from_date').' 00:00:00';
    }

    private function getToDate(){
        return Session::get('to_date').' 23:59:59';
    }

    private function fromDate(){
        return Session::get('from_date');
    }
    private function toDate(){
        return Session::get('to_date');
    }


}
