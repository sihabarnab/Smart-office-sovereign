<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    //quotation
    public function quotation()
    {

        // $m_customers=DB::table('pro_customers')->where('valid',1)->get();
        $all_quotation_master = DB::table('pro_quotation_master')->where('status', 1)->get();
        return view('crm.quotation', compact('all_quotation_master'));
    }

    public function quotation_store(Request $request)
    {
        $rules = [
            'txt_customer' => 'required',
            'txt_date' => 'required',
            'txt_address' => 'required',
            'txt_subject' => 'required',
            'txt_valid_until' => 'required',
        ];
        $customMessages = [
            'txt_customer.required' => 'Customer name required.',
            'txt_date.required' => 'Date required.',
            'txt_address.required' => 'Address required.',
            'txt_subject.required' => 'Subject required.',
            'txt_valid_until.required' => 'Valid Until required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['customer_name'] = $request->txt_customer;
        $data['customer_address'] = $request->txt_address;
        $data['customer_mobile'] = $request->txt_mobile_number;
        $data['subject'] = $request->txt_subject;
        $data['offer_valid'] = $request->txt_valid_until;
        $data['reference'] = $request->txt_reference_name;
        $data['reference_mobile'] = $request->txt_reference_number;
        $data['email'] = $request->txt_email;
        $data['attention'] = $request->txt_attention;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        //
        $quotation_master_id  = "QUOTATION/" . date("Y") . date("m") . mt_rand(1, 100000);
        $data['quotation_master_id'] =  $quotation_master_id;
        $data['quotation_date'] = $request->txt_date;
        //
        $quotation_id = DB::table('pro_quotation_master')->insertGetId($data);

        //
        DB::table('pro_customers_temp')->insert([
            'customer_name' => $request->txt_customer,
            'customer_add' => $request->txt_address,
            'customer_email' => $request->txt_email,
            'customer_phone' => $request->txt_mobile_number,
            'contact_person' => $request->txt_attention,
            'entry_date' => date('Y-m-d'),
            'entry_time' => date('h:i:sa'),
            'valid' => 1,
        ]);


        return redirect()->route('quotation_details', $quotation_id);
    }

    public function quotation_details($id)
    {
        $all_quotation_details = DB::table('pro_quotation_details')
            ->leftJoin('pro_product_group', 'pro_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('quotation_id', $id)
            ->get();

        $m_quotation_master = DB::table('pro_quotation_master')->where('quotation_id', $id)->first();
        $product_group = DB::table('pro_product_group')->where('valid', 1)->get();
        return view('crm.quotation_details', compact('m_quotation_master', 'product_group', 'all_quotation_details'));
    }

    public function quotation_details_store(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required|integer|between:1,99999999',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'txt_rate' => 'required',
            'txt_quantity' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Product name required.',
            'cbo_product.integer' => 'Product name required.',
            'cbo_product.between' => 'Product name required.',
            'cbo_product_sub_group.required' => 'Product Sub Group required.',
            'cbo_product_sub_group.integer' => 'Product Sub Group required.',
            'cbo_product_sub_group.between' => 'Product Sub Group required',
            'cbo_product_group.required' => 'Product Group required.',
            'cbo_product_group.integer' => 'Product Group required.',
            'cbo_product_group.between' => 'Product Group required',
            'txt_rate.required' => 'Rate is required.',
            'txt_quantity.required' => 'Quantity is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table('pro_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $data = array();
        $data['quotation_id'] = $m_quotation_master->quotation_id;
        $data['quotation_master_id'] = $m_quotation_master->quotation_master_id;
        $data['quotation_date'] = $m_quotation_master->quotation_date;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['qty'] = $request->txt_quantity;
        $data['rate'] = $request->txt_rate;
        $data['total'] = $request->txt_rate * $request->txt_quantity;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        DB::table('pro_quotation_details')->insert($data);
        return redirect()->route('quotation_details', $id)->with('success', 'Received Successfull !');
    }

    public function quotation_details_more($id)
    {
        $m_quotation_master = DB::table('pro_quotation_master')
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_details = DB::table('pro_quotation_details')
            ->leftJoin('pro_product_group', 'pro_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_quotation_details.quotation_id', $id)
            ->get();

        return view('crm.quotation_details_final', compact('m_quotation_master', 'm_quotation_details'));
    }
    public function quotation_details_final(Request $request, $id)
    {
        $data = array();
        $data['vat'] = $request->txt_vat;
        $data['ait'] = $request->txt_ait;
        $data['sub_total'] = $request->txt_subtotal;
        $data['quotation_total'] = $request->txt_subtotal + $request->txt_vat + $request->txt_ait;
        $data['status'] = 2;
        DB::table('pro_quotation_master')
            ->where('quotation_id', $id)
            ->update($data);

        DB::table('pro_quotation_details')
            ->where('quotation_id', $id)
            ->update(['status' => 2]);

        return redirect()->route('quotation')->with('success', 'Successfull !');
    }

    //edit
    public function quotation_details_edit($id)
    {
        $quotation_details_edit = DB::table('pro_quotation_details')
            ->leftJoin('pro_product_group', 'pro_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_id',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_id',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_quotation_details.quotation_details_id', $id)
            ->first();
        $m_quotation_master = DB::table('pro_quotation_master')->where('quotation_id', $quotation_details_edit->quotation_id)->first();
        $product_group = DB::table('pro_product_group')->where('valid', 1)->get();
        return view('crm.quotation_details', compact('quotation_details_edit', 'product_group', 'm_quotation_master'));
    }
    public function quotation_details_update(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required|integer|between:1,99999999',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'txt_rate' => 'required',
            'txt_quantity' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Product name required.',
            'cbo_product.integer' => 'Product name required.',
            'cbo_product.between' => 'Product name required.',
            'cbo_product_sub_group.required' => 'Product Sub Group required.',
            'cbo_product_sub_group.integer' => 'Product Sub Group required.',
            'cbo_product_sub_group.between' => 'Product Sub Group required',
            'cbo_product_group.required' => 'Product Group required.',
            'cbo_product_group.integer' => 'Product Group required.',
            'cbo_product_group.between' => 'Product Group required',
            'txt_rate.required' => 'Rate is required.',
            'txt_quantity.required' => 'Quantity is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['qty'] = $request->txt_quantity;
        $data['rate'] = $request->txt_rate;
        $data['total'] = $request->txt_rate * $request->txt_quantity;

        DB::table('pro_quotation_details')
            ->where('quotation_details_id', $id)
            ->update($data);

        $get_quotation_id =  DB::table('pro_quotation_details')
            ->where('quotation_details_id', $id)
            ->first();
        return redirect()->route('quotation_details', $get_quotation_id->quotation_id)->with('success', 'Updated Successfull !');
    }

    public function RptQuotationList()
    {
        return view('crm.rpt_quotation_list');
    }
    public function rpt_quotation_print($id)
    {
        $m_quotation_master = DB::table('pro_quotation_master')->where('quotation_id', $id)->first();
        $m_quotation_details = DB::table('pro_quotation_details')
            ->leftJoin('pro_product_group', 'pro_quotation_details.pg_id', 'pro_product_group.pg_id')
            ->leftJoin('pro_product_sub_group', 'pro_quotation_details.pg_sub_id', 'pro_product_sub_group.pg_sub_id')
            ->join('pro_product', 'pro_quotation_details.product_id', 'pro_product.product_id')
            ->select(
                'pro_quotation_details.*',
                'pro_product.*',
                'pro_product_group.pg_id',
                'pro_product_group.pg_name',
                'pro_product_sub_group.pg_sub_id',
                'pro_product_sub_group.pg_sub_name',
            )
            ->where('pro_quotation_details.quotation_id', $id)
            ->get();
        return view('crm.rpt_quotation_print', compact('m_quotation_master', 'm_quotation_details',));
    }

    //Temporary Client List
    public function rpt_customer_list()
    {
        $m_customer = DB::table('pro_customers_temp')->where('valid', 1)->get();
        return view('crm.rpt_customer_list', compact('m_customer'));
    }



    //All ajax
    public function GetCrmQuotationList()
    {
        $data = DB::table('pro_quotation_master')->where('status', 2)->get();
        return response()->json($data);
    }
    public function GetCrmQuotationProductSubGroup($id)
    {
        $data = DB::table('pro_product_sub_group')
            ->where('pg_id', $id)
            ->where('valid', 1)
            ->get();
        return response()->json($data);
    }
    public function GetCrmQuotationProduct($id, $quotation_id)
    {
        $product_id = DB::table('pro_quotation_details')
            ->where('quotation_id', $quotation_id)
            ->pluck('product_id');

        $data = DB::table('pro_product')
            ->whereNotIn('product_id', $product_id)
            ->where('pg_sub_id', $id)
            ->where('valid', 1)
            ->get();
        return response()->json($data);
    }
    public function GetCrmRptQuotationList()
    {
        $data = DB::table('pro_quotation_master')
            ->where('status', 2)
            ->get();
        return response()->json($data);
    }
}
