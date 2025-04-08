<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    //purchase requisition
    public function purchase_requisition()
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name')
            ->where('pro_purchase_requisition_master.status', 1)
            ->where('pro_purchase_requisition_master.valid', 1)
            ->get();
        $m_product = DB::table('pro_product')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin(
                'pro_origins',
                'pro_product.origin_id',
                'pro_origins.origin_id',
            )
            ->select(
                'pro_product.*',
                'pro_sizes.size_name',
                'pro_origins.origin_name',
            )
            ->where('pro_product.valid', 1)
            ->get();
        return view('purchase.purchase_requisition', compact('m_product', 'pu_requ_master'));
    }

    public function purchase_requisition_store(Request $request)
    {
        $rules = [
            'txt_purchase_requistion_date' => 'required',
            'cbo_product' => 'required',
            'txt_product_qty' => 'required',
        ];
        $customMessages = [
            'txt_purchase_requistion_date.required' => 'Purchase Requisition Date is required!',
            'cbo_product.required' => 'Select Product',
            'txt_product_qty.required' => 'Product Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();

        $last_inv_no = DB::table('pro_purchase_requisition_master')->orderByDesc("purchase_requisition_id")->first();
        if (isset($last_inv_no->purchase_requisition_id)) {
            $purchase_requisition_id = "PRE" . date("my") . str_pad((substr($last_inv_no->purchase_requisition_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $purchase_requisition_id = "PRE" . date("my") . "00001";
        }

        //
        $data = array();
        $data['purchase_requisition_id'] = $purchase_requisition_id;
        $data['purchase_requisition_date'] = $request->txt_purchase_requistion_date;
        $data['remark'] = $request->txt_remark;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['user_id'] = $m_user_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        DB::table('pro_purchase_requisition_master')->insert($data);
        //
        $data2 = array();
        $data2['purchase_requisition_id'] = $purchase_requisition_id;
        $data2['purchase_requisition_date'] = $request->txt_purchase_requistion_date;
        $data2['pg_id'] = $m_product->pg_id;
        $data2['pg_sub_id'] = $m_product->pg_sub_id;
        $data2['product_id'] = $request->cbo_product;
        $data2['unit_id'] = $m_product->unit_id;
        $data2['qty'] = $request->txt_product_qty;
        $data2['price'] = $request->txt_product_price;
        $data2['entry_date'] = date("Y-m-d");
        $data2['entry_time'] = date("h:i:s");
        $data2['user_id'] = $m_user_id;
        $data2['valid'] = 1;
        $data2['status'] = 1;
        DB::table('pro_purchase_requisition_details')->insert($data2);
        return redirect()->route('purchase_requisition_details', $purchase_requisition_id)->with('success', "Add Successfully!");
    }

    public function purchase_requisition_details($id)
    {
        $pu_requ_master =  DB::table('pro_purchase_requisition_master')->where('purchase_requisition_id', $id)->first();
        $pu_requ_details = DB::table('pro_purchase_requisition_details')->where('purchase_requisition_id', $id)->get();
        $add_product_id = DB::table('pro_purchase_requisition_details')->where('purchase_requisition_id', $id)->pluck('product_id');
        $m_product = DB::table('pro_product')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin(
                'pro_origins',
                'pro_product.origin_id',
                'pro_origins.origin_id',
            )
            ->select(
                'pro_product.*',
                'pro_sizes.size_name',
                'pro_origins.origin_name',
            )
            ->whereNotIn('pro_product.product_id', $add_product_id)
            ->where('pro_product.valid', 1)
            ->get();

        return view('purchase.purchase_requisition_details', compact('m_product', 'pu_requ_master', 'pu_requ_details'));
    }
    public function purchase_requisition_details_store(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required',
            'txt_product_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'txt_product_qty.required' => 'Product Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();
        $pu_requ_master =  DB::table('pro_purchase_requisition_master')->where('purchase_requisition_id', $id)->first();

        $data2 = array();
        $data2['purchase_requisition_id'] = $pu_requ_master->purchase_requisition_id;
        $data2['purchase_requisition_date'] = $pu_requ_master->purchase_requisition_date;
        $data2['pg_id'] = $m_product->pg_id;
        $data2['pg_sub_id'] = $m_product->pg_sub_id;
        $data2['product_id'] = $request->cbo_product;
        $data2['qty'] = $request->txt_product_qty;
        $data2['price'] = $request->txt_product_price;
        $data2['unit_id'] = $m_product->unit_id;
        $data2['entry_date'] = date("Y-m-d");
        $data2['entry_time'] = date("h:i:s");
        $data2['user_id'] = $m_user_id;
        $data2['valid'] = 1;
        $data2['status'] = 1;
        DB::table('pro_purchase_requisition_details')->insert($data2);
        return back()->with('success', "Add Successfully!");
    }

    public function purchase_requisition_final($id)
    {
        DB::table('pro_purchase_requisition_master')->where('purchase_requisition_id', $id)->update(['status' => 2]);
        DB::table('pro_purchase_requisition_details')->where('purchase_requisition_id', $id)->update(['status' => 2]);

        $pu_requisition = DB::table('pro_purchase_requisition_master')->where('purchase_requisition_id', $id)->where('status', 2)->first();
        //Notification for our website
        $messages = "$pu_requisition->purchase_requisition_id | Purchase Requisition | Date: $pu_requisition->entry_date | 
          Time: $pu_requisition->entry_time";
        $report_to = ["00000104", "00000184", "00000185", "00000186"];
        $link = route("purchase_requisition_approved_details", $id);
        for ($i = 0; $i < count($report_to); $i++) {
            DB::table('pro_alart_massage')->insert([
                'massage' => $messages,
                'refarence_id' => "PR$pu_requisition->purchase_requisition_id",
                'report_to' => $report_to[$i],
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
                'valid' => 1,
                'link' => $link,
                'color' => "purchase_color"
            ]);
        }

        return redirect()->route('purchase_requisition')->with('success', "Add Successfully!");
    }

    //purchase requisition approved 
    public function purchase_requisition_approved()
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name')
            ->where('pro_purchase_requisition_master.status', 2)
            ->get();
        return view('purchase.purchase_requisition_approved', compact('pu_requ_master'));
    }


    public function purchase_requisition_approved_details($id)
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name')
            ->where('pro_purchase_requisition_master.purchase_requisition_id', $id)
            ->where('pro_purchase_requisition_master.status', 2)
            ->first();

        $pu_requ_details = DB::table('pro_purchase_requisition_details')
            ->leftJoin('pro_product', 'pro_purchase_requisition_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select('pro_purchase_requisition_details.*', "pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_purchase_requisition_details.purchase_requisition_id', $id)
            ->where('pro_purchase_requisition_details.status', 2)
            ->get();

        return view('purchase.purchase_requisition_approved_details', compact('pu_requ_master', 'pu_requ_details'));
    }

    public function purchase_requisition_approved_ok(Request $request, $id)
    {
        $rules = [
            'txt_product_qty' => 'required',
        ];
        $customMessages = [
            'txt_product_qty.required' => 'Product Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $pu_requ_details = DB::table('pro_purchase_requisition_details')
            ->where('pu_requ_details_id', $id)
            ->where('status', 2)
            ->first();
        if ($pu_requ_details) {
            $data2 = array();
            $data2['approved_id'] = $m_user_id;
            $data2['approved_qty'] = $request->txt_product_qty;
            $data2['approved_entry_date'] = date("Y-m-d");
            $data2['approved_entry_time'] = date("h:i:s");
            $data2['status'] = 3;
            DB::table('pro_purchase_requisition_details')
                ->where('pu_requ_details_id', $id)
                ->where('status', 2)
                ->update($data2);

            //master update
            $data = DB::table('pro_purchase_requisition_details')
                ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                ->where('valid', 1)
                ->count();
            $data_approved = DB::table('pro_purchase_requisition_details')
                ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                ->where('valid', 1)
                ->where('status', 3)
                ->count();

            if ($data_approved == $data) {
                $data3 = array();
                $data3['approved_id'] = $m_user_id;
                $data3['approved_entry_date'] = date("Y-m-d");
                $data3['approved_entry_time'] = date("h:i:s");
                $data3['status'] = 3;
                DB::table('pro_purchase_requisition_master')
                    ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                    ->where('status', 2)
                    ->update($data3);
                if ($pu_requ_details->purchase_requisition_id) {
                    DB::table('pro_alart_massage')->where('refarence_id', "PR$pu_requ_details->purchase_requisition_id")->update(['valid' => 0]);
                }
                return redirect()->route('purchase_requisition_approved')->with('success', 'Approved Successfull!');
            } else {
                return back()->with('success', 'Approved Successfull!');
            } //    if($data_approved == $data){


        } else {
            return back()->with('warning', 'No data Found');
        } //if ($pu_requ_details) {
    }

    public function purchase_requisition_approved_reject(Request $request)
    {
        $id = $request->txt_details;
        $m_user_id =  Auth::user()->emp_id;
        $pu_requ_details = DB::table('pro_purchase_requisition_details')
            ->where('pu_requ_details_id', $id)
            ->where('status', 2)
            ->first();
        if ($pu_requ_details) {
            $data2 = array();
            $data2['approved_id'] = $m_user_id;
            $data2['approved_qty'] = 0;
            $data2['approved_entry_date'] = date("Y-m-d");
            $data2['approved_entry_time'] = date("h:i:s");
            $data2['status'] = 3;
            $data2['valid'] = 0; // Reject valid 0 nad approved qty 0
            DB::table('pro_purchase_requisition_details')
                ->where('pu_requ_details_id', $id)
                ->where('status', 2)
                ->update($data2);

            //master update
            $data = DB::table('pro_purchase_requisition_details')
                ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                ->where('valid', 1)
                ->count();
            $data_approved = DB::table('pro_purchase_requisition_details')
                ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                ->where('valid', 1)
                ->where('status', 3)
                ->count();

            if ($data_approved == $data) {
                $data3 = array();
                $data3['approved_id'] = $m_user_id;
                $data3['approved_entry_date'] = date("Y-m-d");
                $data3['approved_entry_time'] = date("h:i:s");
                $data3['status'] = 3;
                DB::table('pro_purchase_requisition_master')
                    ->where('purchase_requisition_id', $pu_requ_details->purchase_requisition_id)
                    ->where('status', 2)
                    ->update($data3);
                if ($pu_requ_details->purchase_requisition_id) {
                    DB::table('pro_alart_massage')->where('refarence_id', "PR$pu_requ_details->purchase_requisition_id")->update(['valid' => 0]);
                }
                return redirect()->route('purchase_requisition_approved')->with('success', 'Approved Successfull!');
            } else {
                return back()->with('success', 'Reject Successfull!');
            } //    if($data_approved == $data){


        } else {
            return back()->with('warning', 'No data Found');
        } //if ($pu_requ_details) {
    }

    //rpt 
    public function rpt_purchase_requisition_list()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as approved_mgm', 'pro_purchase_requisition_master.approved_id', 'approved_mgm.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name', 'approved_mgm.employee_name as approved_by')
            ->where('pro_purchase_requisition_master.status', 3)
            ->where('pro_purchase_requisition_master.valid', 1)
            ->whereBetween('pro_purchase_requisition_master.purchase_requisition_date', [$form, $to])
            ->orderByDesc('purchase_requisition_id')
            ->get();
        return view('purchase.rpt_purchase_requisition_list', compact('pu_requ_master', 'form', 'to'));
    }

    public function rpt_purchase_requisition_info(Request $request)
    {
        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'Form is Required.',
            'txt_to.required' => 'To is Required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $form = $request->txt_from;
        $to = $request->txt_to;

        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as approved_mgm', 'pro_purchase_requisition_master.approved_id', 'approved_mgm.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name', 'approved_mgm.employee_name as approved_by')
            ->where('pro_purchase_requisition_master.status', 3)
            ->where('pro_purchase_requisition_master.valid', 1)
            ->whereBetween('pro_purchase_requisition_master.purchase_requisition_date', [$form, $to])
            ->orderByDesc('purchase_requisition_id')
            ->get();

        return view('purchase.rpt_purchase_requisition_list', compact('pu_requ_master', 'form', 'to'));
    }

    public function rpt_purchase_requisition_details($id)
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as approved_mgm', 'pro_purchase_requisition_master.approved_id', 'approved_mgm.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name', 'approved_mgm.employee_name as approved_by')
            ->where('pro_purchase_requisition_master.purchase_requisition_id', $id)
            ->where('pro_purchase_requisition_master.valid', 1)
            ->first();

        $pu_requ_details = DB::table('pro_purchase_requisition_details')
            ->leftJoin('pro_product', 'pro_purchase_requisition_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
            ->select('pro_purchase_requisition_details.*', 'pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name', 'pro_units.unit_name')
            ->where('pro_purchase_requisition_details.purchase_requisition_id', $id)
            ->where('pro_purchase_requisition_details.valid', 1)
            ->get();
        return view('purchase.rpt_purchase_requisition_details', compact('pu_requ_master', 'pu_requ_details'));
    }

    // purchase_invoice
    public function purchase_invoice()
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as approved_mgm', 'pro_purchase_requisition_master.approved_id', 'approved_mgm.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name', 'approved_mgm.employee_name as approved_by')
            ->where('pro_purchase_requisition_master.status', 3)
            ->where('pro_purchase_requisition_master.pu_status', null)
            ->orderByDesc('purchase_requisition_id')
            ->get();

        return view('purchase.purchase_invoice', compact('pu_requ_master'));
    }

    public function purchase_invoice_master($id)
    {
        $pu_requ_master = DB::table('pro_purchase_requisition_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_requisition_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as approved_mgm', 'pro_purchase_requisition_master.approved_id', 'approved_mgm.employee_id')
            ->select('pro_purchase_requisition_master.*', 'pro_employee_info.employee_name', 'approved_mgm.employee_name as approved_by')
            ->where('pro_purchase_requisition_master.purchase_requisition_id', $id)
            ->where('pro_purchase_requisition_master.status', 3)
            ->first();

        $purchase_details_product_id = DB::table('pro_purchase_requisition_details')
            ->where('purchase_requisition_id', $id)
            ->where('pu_status', null)
            ->where('status', 3)
            ->where('valid', 1)
            ->pluck('product_id');

        $m_product = DB::table('pro_product')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin(
                'pro_origins',
                'pro_product.origin_id',
                'pro_origins.origin_id',
            )
            ->select(
                'pro_product.*',
                'pro_sizes.size_name',
                'pro_origins.origin_name',
            )
            ->whereIn('pro_product.product_id', $purchase_details_product_id)
            ->where('pro_product.valid', 1)
            ->get();

        $m_store = DB::table('pro_store_details')
            ->where('valid', 1)
            ->get();


        return view('purchase.purchase_invoice_master', compact('pu_requ_master', 'm_product', 'm_store'));
    }

    public function GetPurchaseRequictionProductQty($product_id, $id)
    {
        $re_details = DB::table('pro_purchase_requisition_details')
            ->select('approved_qty', 'pu_qty')
            ->where('purchase_requisition_id', $id)
            ->where('product_id', $product_id)
            ->where('status', 3)
            ->where('valid', 1)
            ->first();
        $data = array();
        $data['approved_qty'] = $re_details->approved_qty;
        $data['pu_qty'] = $re_details->pu_qty == null ? 0 : $re_details->pu_qty;
        $data['qty'] = $re_details->approved_qty - $re_details->pu_qty;
        return response()->json($data);
    }


    public function purchase_invoice_store(Request $request)
    {
        $rules = [
            'txt_purchase_invoice_no' => 'required',
            'txt_purchase_invoice_date' => 'required',
            'cbo_product' => 'required',
            'txt_product_qty' => 'required',
            'cbo_store_id' => 'required',
        ];
        $customMessages = [
            'txt_purchase_invoice_no.required' => 'Purchase invoice No is required!',
            'txt_purchase_invoice_date.required' => 'Purchase invoice Date is required!',
            'cbo_product.required' => 'Select Product',
            'txt_product_qty.required' => 'Product Qty is required!',
            'cbo_store_id.required' => 'Select Warehouse',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();

        $m_purchase_requisition_details = DB::table('pro_purchase_requisition_details')
            ->select('approved_qty', 'pu_qty')
            ->where('purchase_requisition_id', $request->txt_purchase_requisition_id)
            ->where('product_id', $request->cbo_product)
            ->where('status', 3)
            ->where('valid', 1)
            ->first();

        //Purchase QTY check
        $requisition_qty = $m_purchase_requisition_details->approved_qty;
        $purchase_qty = $m_purchase_requisition_details->pu_qty == null ? 0 : $m_purchase_requisition_details->pu_qty;
        $purchase_total_qty =  $purchase_qty + $request->txt_product_qty;
        //
        if ($request->txt_product_qty <= 0) {
            return back()->with('warning', "Purchase Qty  $request->txt_product_qty <=0 ");
        } elseif ($requisition_qty < $purchase_total_qty) {
            return back()->with('warning', "Purchase Qty Getter than Requisition QTY! $purchase_total_qty>$requisition_qty");
        } else {
            //purchase master
            $purchase_master_id = DB::table('pro_purchase_master')->insertGetId([
                'purchase_requisition_id' =>  $request->txt_purchase_requisition_id,
                'purchase_requisition_date' =>  $request->txt_purchase_requisition_date,
                'purchase_invoice_no' =>  $request->txt_purchase_invoice_no,
                'purchase_invoice_date' =>  $request->txt_purchase_invoice_date,
                'store_id' =>  $request->cbo_store_id,
                'remark' =>  $request->txt_remark,
                'user_id' => $m_user_id,
                'status' => '1',
                'valid' => '1',
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:s"),
            ]);

            if (isset($request->txt_product_rate)) {
                $rate = $request->txt_product_rate;
                $total = $request->txt_product_qty * $rate;
            } else {
                $rate = 0;
                $total = 0;
            }



            //purchase details
            $data = array();
            $data['purchase_requisition_id'] =  $request->txt_purchase_requisition_id;
            $data['purchase_requisition_date'] =  $request->txt_purchase_requisition_date;
            $data['purchase_master_id'] = $purchase_master_id;
            $data['purchase_invoice_no'] = $request->txt_purchase_invoice_no;
            $data['purchase_invoice_date'] = $request->txt_purchase_invoice_date;
            $data['store_id'] = $request->cbo_store_id;
            $data['pg_id'] = $m_product->pg_id;
            $data['pg_sub_id'] = $m_product->pg_sub_id;
            $data['product_id'] = $request->cbo_product;
            $data['unit_id'] = $m_product->unit_id;
            $data['qty'] = $request->txt_product_qty;
            $data['rate'] = $rate;
            $data['total'] = $total;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['user_id'] = $m_user_id;
            $data['valid'] = 1;
            $data['status'] = 1;
            DB::table('pro_purchase_details')->insert($data);

            if ($requisition_qty == $purchase_total_qty) {
                DB::table('pro_purchase_requisition_details')
                    ->where('purchase_requisition_id', $request->txt_purchase_requisition_id)
                    ->where('product_id', $request->cbo_product)
                    ->where('status', 3)
                    ->where('valid', 1)
                    ->update([
                        'pu_qty' => $purchase_total_qty,
                        'pu_status' => 1
                    ]);
            } else {
                DB::table('pro_purchase_requisition_details')
                    ->where('purchase_requisition_id', $request->txt_purchase_requisition_id)
                    ->where('product_id', $request->cbo_product)
                    ->where('status', 3)
                    ->where('valid', 1)
                    ->update(['pu_qty' => $purchase_total_qty]);
            }
            return redirect()->route('purchase_invoice_details', $purchase_master_id)->with('success', "Add Successfully!");
        }
    }

    public function purchase_invoice_details($id)
    {
        $m_purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_store_details.store_name')
            ->where('pro_purchase_master.purchase_master_id', $id)
            ->first();

        //product
        $purchase_details_product_id = DB::table('pro_purchase_details')
            ->where('purchase_master_id', $id)
            ->pluck('product_id');

        $requiction_details_product_id = DB::table('pro_purchase_requisition_details')
            ->whereNotIn('product_id', $purchase_details_product_id)
            ->where('purchase_requisition_id', $m_purchase_master->purchase_requisition_id)
            ->where('pu_status', null)
            ->where('valid', 1)
            ->pluck('product_id');

            $m_product = DB::table('pro_product')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin(
                'pro_origins',
                'pro_product.origin_id',
                'pro_origins.origin_id',
            )
            ->select(
                'pro_product.*',
                'pro_sizes.size_name',
                'pro_origins.origin_name',
            )
            ->whereIn('pro_product.product_id', $requiction_details_product_id)
            ->where('pro_product.valid', 1)
            ->get();
        //
        $m_purchase_details = DB::table('pro_purchase_details')->where('purchase_master_id', $id)->get();
        return view('purchase.purchase_invoice_details', compact('m_product', 'm_purchase_master', 'm_purchase_details'));
    }

    public function purchase_invoice_details_store(Request $request, $id)
    {

        $rules = [
            'cbo_product' => 'required',
            'txt_product_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'txt_product_qty.required' => 'Product Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $m_product = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();
        $m_purchase_master = DB::table('pro_purchase_master')->where('purchase_master_id', $id)->first();


        $m_purchase_requisition_details = DB::table('pro_purchase_requisition_details')
            ->select('approved_qty', 'pu_qty')
            ->where('purchase_requisition_id', $m_purchase_master->purchase_requisition_id)
            ->where('product_id', $request->cbo_product)
            ->where('status', 3)
            ->where('valid', 1)
            ->first();

        //Purchase QTY check
        $requisition_qty = $m_purchase_requisition_details->approved_qty;
        $purchase_qty = $m_purchase_requisition_details->pu_qty == null ? 0 : $m_purchase_requisition_details->pu_qty;
        $purchase_total_qty =  $purchase_qty + $request->txt_product_qty;
        //
        if ($request->txt_product_qty <= 0) {
            return back()->with('warning', "Purchase Qty  $request->txt_product_qty <=0 ");
        } elseif ($requisition_qty < $purchase_total_qty) {
            return back()->with('warning', "Purchase Qty Getter than Requisition QTY! $purchase_total_qty>$requisition_qty");
        } else {

            if (isset($request->txt_product_rate)) {
                $rate = $request->txt_product_rate;
                $total = $request->txt_product_qty * $rate;
            } else {
                $rate = 0;
                $total = 0;
            }

            $data = array();
            $data['purchase_requisition_id'] =  $m_purchase_master->purchase_requisition_id;
            $data['purchase_requisition_date'] =  $m_purchase_master->purchase_requisition_date;
            $data['purchase_master_id'] = $m_purchase_master->purchase_master_id;
            $data['purchase_invoice_no'] = $m_purchase_master->purchase_invoice_no;
            $data['purchase_invoice_date'] = $m_purchase_master->purchase_invoice_date;
            $data['store_id'] = $m_purchase_master->store_id;
            $data['pg_id'] = $m_product->pg_id;
            $data['pg_sub_id'] = $m_product->pg_sub_id;
            $data['product_id'] = $request->cbo_product;
            $data['unit_id'] = $m_product->unit_id;
            $data['qty'] = $request->txt_product_qty;
            $data['rate'] = $rate;
            $data['total'] = $total;
            $data['remark'] = $request->txt_remark;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['user_id'] = $m_user_id;
            $data['valid'] = 1;
            $data['status'] = 1;
            DB::table('pro_purchase_details')->insert($data);

            if ($requisition_qty == $purchase_total_qty) {
                DB::table('pro_purchase_requisition_details')
                    ->where('purchase_requisition_id', $request->txt_purchase_requisition_id)
                    ->where('product_id', $request->cbo_product)
                    ->where('status', 3)
                    ->where('valid', 1)
                    ->update([
                        'pu_qty' => $purchase_total_qty,
                        'pu_status' => 1
                    ]);
            } else {
                DB::table('pro_purchase_requisition_details')
                    ->where('purchase_requisition_id', $request->txt_purchase_requisition_id)
                    ->where('product_id', $request->cbo_product)
                    ->where('status', 3)
                    ->where('valid', 1)
                    ->update(['pu_qty' => $purchase_total_qty]);
            }
            return back()->with('success', "Add Successfully!");
        }
    }

    public function purchase_invoice_final($id)
    {
        DB::table('pro_purchase_master')->where('purchase_master_id', $id)->update(['status' => 2]);
        DB::table('pro_purchase_details')->where('purchase_master_id', $id)->update(['status' => 2]);
        $purchase_master = DB::table('pro_purchase_master')->where('purchase_master_id', $id)->first();

        $data =  DB::table('pro_purchase_requisition_details')
            ->where('purchase_requisition_id',  $purchase_master->purchase_requisition_id)
            ->where('status', 3)
            ->where('valid', 1)
            ->count();

        $data_02 =  DB::table('pro_purchase_requisition_details')
            ->where('purchase_requisition_id',  $purchase_master->purchase_requisition_id)
            ->where('status', 3)
            ->where('valid', 1)
            ->where('pu_status', 1)
            ->count();
        if ($data == $data_02) {
            DB::table('pro_purchase_requisition_master')
                ->where('purchase_requisition_id', $purchase_master->purchase_requisition_id)
                ->update(['pu_status' => 1]);
            //Notification for our website
            $messages = "$purchase_master->purchase_invoice_no | Purchase | Date: $purchase_master->entry_date | 
        Time: $purchase_master->entry_time";
            $report_to = ["00000104", "00000184", "00000185", "00000186"];
            $link = route("purchase_approved_details", $id);
            for ($i = 0; $i < count($report_to); $i++) {
                DB::table('pro_alart_massage')->insert([
                    'massage' => $messages,
                    'refarence_id' => "PU$purchase_master->purchase_master_id",
                    'report_to' => $report_to[$i],
                    'user_id' => Auth::user()->emp_id,
                    'entry_date' => date("Y-m-d"),
                    'entry_time' => date("h:i:s"),
                    'valid' => 1,
                    'link' => $link,
                    'color' => "purchase_color"
                ]);
            }
            //End Notification for our website
        }
        return redirect()->route('purchase_invoice')->with('success', "Add Successfully!");
    }

    //purchase approved
    public function purchase_approved()
    {
        $purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_employee_info.employee_name', 'pro_store_details.store_name')
            ->where('pro_purchase_master.status', 2)
            ->get();

        return view('purchase.purchase_approved', compact('purchase_master'));
    }

    public function purchase_approved_details($id)
    {
        $purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_employee_info', 'pro_purchase_master.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_employee_info.employee_name', 'pro_store_details.store_name')
            ->where('pro_purchase_master.purchase_master_id', $id)
            ->where('pro_purchase_master.status', 2)
            ->first();

        $purchase_details = DB::table('pro_purchase_details')
            ->leftJoin('pro_product', 'pro_purchase_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select('pro_purchase_details.*', 'pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_purchase_details.purchase_master_id', $id)
            ->where('pro_purchase_details.status', 2)
            ->get();

        return view('purchase.purchase_approved_details', compact('purchase_master', 'purchase_details'));
    }

    public function purchase_approved_ok(Request $request, $id)
    {
        $rules = [
            'txt_product_qty' => 'required',
        ];
        $customMessages = [
            'txt_product_qty.required' => 'Product Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id =  Auth::user()->emp_id;
        $purchase_details = DB::table('pro_purchase_details')
            ->where('purchase_details_id', $id)
            ->where('status', 2)
            ->first();


        if ($purchase_details) {
            if ($request->txt_product_qty > $purchase_details->qty) {
                return back()->with('warning', "Purchase qty getter than Requisition Qty $request->txt_product_qty > $purchase_details->qty");
            } else {
                $data2 = array();
                $data2['approved_id'] = $m_user_id;
                $data2['approved_qty'] = $request->txt_product_qty;
                $data2['approved_entry_date'] = date("Y-m-d");
                $data2['approved_entry_time'] = date("h:i:s");
                $data2['status'] = 3;
                DB::table('pro_purchase_details')
                    ->where('purchase_details_id', $id)
                    ->where('status', 2)
                    ->update($data2);

                //master update
                $data = DB::table('pro_purchase_details')
                    ->where('purchase_master_id', $purchase_details->purchase_master_id)
                    ->count();
                $data_approved = DB::table('pro_purchase_details')
                    ->where('purchase_master_id', $purchase_details->purchase_master_id)
                    ->where('status', 3)
                    ->count();

                if ($data_approved == $data) {
                    $data3 = array();
                    $data3['approved_id'] = $m_user_id;
                    $data3['approved_entry_date'] = date("Y-m-d");
                    $data3['approved_entry_time'] = date("h:i:s");
                    $data3['status'] = 3;
                    DB::table('pro_purchase_master')
                        ->where('purchase_master_id', $purchase_details->purchase_master_id)
                        ->where('status', 2)
                        ->update($data3);

                    //Notification Disable
                    if ($purchase_details->purchase_master_id) {
                        DB::table('pro_alart_massage')->where('refarence_id', "PU$purchase_details->purchase_master_id")->update(['valid' => 0]);
                    }

                    //stock table update data
                    $m_purchase_approved = DB::table('pro_purchase_details')
                        ->where('purchase_master_id', $purchase_details->purchase_master_id)
                        ->where('status', 3)
                        ->get();

                    foreach ($m_purchase_approved as $row) {
                        $product = DB::table('pro_product')
                            ->where('product_id', $row->product_id)
                            ->first();

                        $total_product_qty = DB::table('pro_product_stock')
                            ->where('product_id', $row->product_id)
                            ->orderByDesc('stock_id')
                            ->first();
                        if (isset($total_product_qty)) {
                            $total_stock =  $total_product_qty->total_stock + $row->approved_qty;
                        } else {
                            $total_stock = 0 + $row->approved_qty;
                        }

                        $data  = array();
                        $data['purchase_master_id'] = $row->purchase_master_id;
                        $data['purchase_invoice_no'] = $row->purchase_invoice_no;
                        $data['purchase_invoice_date'] = $row->purchase_invoice_date;
                        $data['pg_id'] = $product->pg_id;
                        $data['pg_sub_id'] = $product->pg_sub_id;
                        $data['product_id'] = $product->product_id;
                        $data['qty'] = $row->approved_qty;
                        $data['total_stock'] = $total_stock;
                        $data['status'] = 1;
                        $data['request_status'] = 1;
                        $data['store_id'] = $row->store_id;
                        $data['user_id'] = Auth::user()->emp_id;
                        $data['valid'] = 1;
                        $data['entry_date'] = date("Y-m-d");
                        $data['entry_time'] = date("h:i:s");
                        DB::table('pro_product_stock')->insert($data);
                    }
                    //end stock

                    return redirect()->route('purchase_approved')->with('success', 'Approved Successfull!');
                } else {
                    return back()->with('success', 'Approved Successfull!');
                } //    if($data_approved == $data){
            } //  if($request->txt_product_qty > $purchase_details->qty){


        } else {
            return back()->with('warning', 'No data Found');
        } //if ($pu_requ_details) {
    }



    //report purchase
    public function rpt_purchase_invoice_list()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_store_details.store_name')
            ->where('pro_purchase_master.status', 3)
            ->where('pro_purchase_master.valid', 1)
            ->whereBetween('pro_purchase_master.purchase_invoice_date', [$form, $to])
            ->orderByDesc('pro_purchase_master.purchase_master_id')
            ->get();

        return view('purchase.rpt_purchase_invoice_list', compact('m_purchase_master', 'form', 'to'));
    }
    public function rpt_purchase_invoice_info(Request $request)
    {
        $rules = [
            'txt_from' => 'required',
            'txt_to' => 'required',
        ];

        $customMessages = [
            'txt_from.required' => 'Form is Required.',
            'txt_to.required' => 'To is Required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $form = $request->txt_from;
        $to = $request->txt_to;
        $m_purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_store_details.store_name')
            ->where('pro_purchase_master.status', 3)
            ->where('pro_purchase_master.valid', 1)
            ->whereBetween('pro_purchase_master.purchase_invoice_date', [$form, $to])
            ->orderByDesc('pro_purchase_master.purchase_master_id')
            ->get();
        return view('purchase.rpt_purchase_invoice_list', compact('m_purchase_master', 'form', 'to'));
    }

    public function rpt_purchase_invoice_details($id)
    {
        $m_purchase_master = DB::table('pro_purchase_master')
            ->leftJoin('pro_store_details', 'pro_purchase_master.store_id', 'pro_store_details.store_id')
            ->select('pro_purchase_master.*', 'pro_store_details.store_name')
            ->where('pro_purchase_master.purchase_master_id', $id)
            ->where('pro_purchase_master.valid', 1)
            ->first();
        $m_purchase_details =  DB::table('pro_purchase_details')->where('purchase_master_id', $id)->where('valid', 1)->get();
        return view('purchase.rpt_purchase_invoice_details', compact('m_purchase_master', 'm_purchase_details'));
    }






    //indent Ajax
    public function GetIndentGroup($id)
    {
        $data = DB::table('pro_product_sub_group')
            ->where('pg_id', $id)
            ->get();

        return response()->json($data);
    }


    public function GetIndentProduct($id)
    {
        $data = DB::table('pro_product')
            ->where('pg_sub_id', $id)
            ->get();

        return response()->json($data);
    }

    public function GetIndentProductDetails($id, $id2)
    {
        $product_id = DB::table('pro_indent_details')->where('indent_no', $id2)->pluck('product_id');

        $data = DB::table('pro_product')
            ->whereNotIn('product_id', $product_id)
            ->where('pg_sub_id', $id)
            ->get();

        return response()->json($data);
    }

    public function GetProductStoreUnit($id)
    {
        $product = DB::table('pro_product')
            ->where('product_id', $id)
            ->first();

        $data = DB::table('pro_units')->where('unit_id', $product->unit_id)->first();
        return response()->json($data);
    }

    public function GetSupplyAddress($id)
    {
        $data = DB::table('pro_suppliers')->where('supplier_id', $id)->where('valid', 1)->first();
        return response()->json($data);
    }
}
