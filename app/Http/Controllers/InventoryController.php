<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Product Group
    public function inventoryproductgroup()
    {
        $data = DB::table('pro_product_group')->Where('valid', '1')->orderBy('pg_id', 'desc')->get(); //query builder
        return view('inventory.product_group', compact('data'));

        // return view('inventory.product_group');
    }

    public function inventorypgstore(Request $request)
    {
        $rules = [
            'txt_pg_name' => 'required'
        ];
        $customMessages = [
            'txt_pg_name.required' => 'Product Group Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_product_group')->where('pg_name', $request->txt_pg_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['pg_name'] = $request->txt_pg_name;
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_product_group')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function inventorypgedit($id)
    {

        $m_pg = DB::table('pro_product_group')->where('pg_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_product_group')->Where('valid', '1')->orderBy('pg_id', 'desc')->get();
        return view('inventory.product_group', compact('data', 'm_pg'));
    }

    public function inventorypgupdate(Request $request, $update)
    {

        $rules = [
            'txt_pg_name' => 'required',
        ];
        $customMessages = [
            'txt_pg_name.required' => 'Product Group Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_product_group = DB::table('pro_product_group')->where('pg_id', $request->txt_pg_id)->where('pg_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_product_group === null) {

            DB::table('pro_product_group')->where('pg_id', $update)->update([
                'pg_name' => $request->txt_pg_name,
            ]);

            return redirect(route('product_group'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Sub Group
    public function inventoryproductsubgroup()
    {
        $data = DB::table('pro_product_sub_group')->Where('valid', '1')->orderBy('pg_sub_id', 'desc')->get();
        return view('inventory.product_sub_group', compact('data'));

        // return view('inventory.product_group');
    }

    public function inventorypgsubstore(Request $request)
    {
        $rules = [
            'sele_pg_id' => 'required|integer|between:1,10000',
            'txt_pg_sub_name' => 'required',
        ];
        $customMessages = [
            'sele_pg_id.required' => 'Select Product Group.',
            'sele_pg_id.integer' => 'Select Product Group.',
            'sele_pg_id.between' => 'Select Product Group.',

            'txt_pg_sub_name.required' => 'Product Sub Group Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_product_sub_group')->where('pg_sub_name', $request->txt_pg_sub_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['pg_id'] = $request->sele_pg_id;
            $data['pg_sub_name'] = $request->txt_pg_sub_name;
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_product_sub_group')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            // $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function inventorypgsubedit($id)
    {

        $m_pg_sub = DB::table('pro_product_sub_group')->where('pg_sub_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_product_sub_group')->Where('valid', '1')->orderBy('pg_sub_id', 'desc')->get();
        return view('inventory.product_sub_group', compact('data', 'm_pg_sub'));
    }

    public function inventorypgsubupdate(Request $request, $update)
    {

        $rules = [
            'sele_pg_id' => 'required|integer|between:1,10000',
            'txt_pg_sub_name' => 'required',
        ];
        $customMessages = [
            'sele_pg_id.required' => 'Select Product Group.',
            'sele_pg_id.integer' => 'Select Product Group.',
            'sele_pg_id.between' => 'Select Product Group.',

            'txt_pg_sub_name.required' => 'Product Sub Group Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_product_sub_group = DB::table('pro_product_sub_group')->where('pg_sub_id', $request->txt_pg_sub_id)->where('pg_sub_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_product_sub_group === null) {

            DB::table('pro_product_sub_group')->where('pg_sub_id', $update)->update([
                'pg_id' => $request->sele_pg_id,
                'pg_sub_name' => $request->txt_pg_sub_name,
            ]);

            return redirect(route('product_sub_group'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product
    public function inventoryproduct()
    {
        $data = DB::table('pro_product')->Where('valid', '1')->orderBy('pro_product.product_name', "ASC")->get();
        return view('inventory.product', compact('data'));
    }

    public function inventoryproductstore(Request $request)
    {
        $rules = [
            'txt_product_name' => 'required',
            'txt_product_des' => 'required',
            'sele_unit_id' => 'required|integer|between:1,10000',
        ];
        $customMessages = [
            'txt_product_name.required' => 'Product Name is required.',
            'txt_product_des.required' => 'Product Description is required.',

            'sele_unit_id.required' => 'Select Unit.',
            'sele_unit_id.integer' => 'Select Unit.',
            'sele_unit_id.between' => 'Select Unit.',

        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_product')->where('pg_id', $request->sele_pg_id)->where('product_name', $request->txt_product_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $mentrydate = time();
            $m_entry_date = date("Y-m-d", $mentrydate);
            $m_entry_time = date("H:i:s", $mentrydate);

            $data = array();
            $data['pg_id'] = 1;
            $data['pg_sub_id'] = 1;
            $data['product_name'] = $request->txt_product_name;
            $data['unit_id'] = $request->sele_unit_id;
            $data['product_des'] = $request->txt_product_des;
            $data['size_id'] = $request->sele_size_id;
            $data['origin_id'] = $request->sele_origin_id;
            $data['user_id'] = $request->txt_user_id;
            $data['valid'] = $m_valid;
            $data['entry_date'] = $m_entry_date;
            $data['entry_time'] = $m_entry_time;
            // dd($data);
            DB::table('pro_product')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            // $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function inventoryproductedit($id)
    {

        $m_product = DB::table('pro_product')->where('product_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_product')->Where('valid', '1')->orderBy('product_id', 'desc')->get();
        return view('inventory.product', compact('data', 'm_product'));
    }

    public function inventoryproductupdate(Request $request, $update)
    {

        $rules = [
            'txt_product_name' => 'required',
            'sele_unit_id' => 'required|integer|between:1,10000',
        ];
        $customMessages = [
            'txt_product_name.required' => 'Product Name is required.',
            'sele_unit_id.required' => 'Select Unit.',
            'sele_unit_id.integer' => 'Select Unit.',
            'sele_unit_id.between' => 'Select Unit.',
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_product = DB::table('pro_product')->where('product_id', $request->txt_product_id)->where('product_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_product === null) {

            DB::table('pro_product')->where('product_id', $update)->update([
                'pg_id' => 1,
                'pg_sub_id' => 1,
                'product_name' => $request->txt_product_name,
                'unit_id' => $request->sele_unit_id,
                'product_des' => $request->txt_product_des,
                'size_id' => $request->sele_size_id,
                'origin_id' => $request->sele_origin_id,
            ]);

            return redirect(route('product'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Unit
    public function productunit()
    {
        $data = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_id', 'desc')->get(); //query builder
        return view('inventory.product_unit', compact('data'));

        // return view('inventory.product_group');
    }

    public function unitstore(Request $request)
    {
        $rules = [
            'txt_unit_name' => 'required'
        ];
        $customMessages = [
            'txt_unit_name.required' => 'Unit Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_units')->where('unit_name', $request->txt_unit_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['unit_name'] = strtoupper($request->txt_unit_name);
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_units')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prounitedit($id)
    {

        $m_unit = DB::table('pro_units')->where('unit_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_id', 'desc')->get();
        return view('inventory.product_unit', compact('data', 'm_unit'));
    }

    public function prounitupdate(Request $request, $update)
    {

        $rules = [
            'txt_unit_name' => 'required',
        ];
        $customMessages = [
            'txt_unit_name.required' => 'Unit Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_units = DB::table('pro_units')->where('unit_id', $request->txt_unit_id)->where('unit_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_units === null) {

            DB::table('pro_units')->where('unit_id', $update)->update([
                'unit_name' => strtoupper($request->txt_unit_name),
            ]);

            return redirect(route('product_unit'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Size
    public function productsize()
    {
        $data = DB::table('pro_sizes')->Where('valid', '1')->orderBy('size_id', 'desc')->get(); //query builder
        return view('inventory.product_size', compact('data'));
    }

    public function sizestore(Request $request)
    {
        $rules = [
            'txt_size_name' => 'required'
        ];
        $customMessages = [
            'txt_size_name.required' => 'Size Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_sizes')->where('size_name', $request->txt_size_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['size_name'] = $request->txt_size_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_sizes')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prosizeedit($id)
    {

        $m_size = DB::table('pro_sizes')->where('size_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_sizes')->Where('valid', '1')->orderBy('size_id', 'desc')->get();
        return view('inventory.product_size', compact('data', 'm_size'));
    }

    public function prosizeupdate(Request $request, $update)
    {

        $rules = [
            'txt_size_name' => 'required',
        ];
        $customMessages = [
            'txt_size_name.required' => 'Size Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_sizes = DB::table('pro_sizes')->where('size_id', $request->txt_size_id)->where('size_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_sizes === null) {

            DB::table('pro_sizes')->where('size_id', $update)->update([
                'size_name' => $request->txt_size_name,
            ]);

            return redirect(route('product_size'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Origin
    public function productorigin()
    {
        $data = DB::table('pro_origins')->Where('valid', '1')->orderBy('origin_id', 'desc')->get(); //query builder
        return view('inventory.product_origin', compact('data'));
    }

    public function originstore(Request $request)
    {
        $rules = [
            'txt_origin_name' => 'required'
        ];
        $customMessages = [
            'txt_origin_name.required' => 'Origin Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_origins')->where('origin_name', $request->txt_origin_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['origin_name'] = $request->txt_origin_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_origins')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prooriginedit($id)
    {

        $m_origin = DB::table('pro_origins')->where('origin_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_origins')->Where('valid', '1')->orderBy('origin_id', 'desc')->get();
        return view('inventory.product_origin', compact('data', 'm_origin'));
    }

    public function prooriginupdate(Request $request, $update)
    {

        $rules = [
            'txt_origin_name' => 'required',
        ];
        $customMessages = [
            'txt_origin_name.required' => 'Origin Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_origins = DB::table('pro_origins')->where('origin_id', $request->txt_origin_id)->where('origin_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_origins === null) {

            DB::table('pro_origins')->where('origin_id', $update)->update([
                'origin_name' => $request->txt_origin_name,
            ]);

            return redirect(route('product_origin'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Supplier
    public function supplierinfo()
    {
        $data = DB::table('pro_suppliers')->Where('valid', '1')->orderBy('supplier_id', 'desc')->get(); //query builder
        return view('inventory.supplier_info', compact('data'));

        // return view('inventory.product_group');
    }

    public function supplier_info_store(Request $request)
    {
        $rules = [
            'txt_supplier_name' => 'required',
            'txt_supplier_add' => 'required',
            'txt_supplier_phone' => 'required',
        ];
        $customMessages = [
            'txt_supplier_name.required' => 'Supplier Name is required.',
            'txt_supplier_add.required' => 'Supplier Address is required.',
            'txt_supplier_phone.required' => 'Supplier Phone Number is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_suppliers')
            ->where('supplier_name', $request->txt_supplier_name)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['supplier_name'] = $request->txt_supplier_name;
            $data['supplier_add'] = $request->txt_supplier_add;
            $data['supplier_phone'] = $request->txt_supplier_phone;
            $data['supplier_email'] = $request->txt_supplier_email;
            $data['contact_person'] = $request->txt_contact_person;
            $data['valid'] = $m_valid;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');

            // dd($data);
            DB::table('pro_suppliers')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function supplier_info_edit($id)
    {

        $m_supplier = DB::table('pro_suppliers')->where('supplier_id', $id)->first();

        // $data=DB::table('pro_suppliers')->Where('valid','1')->orderBy('supplier_id', 'desc')->get();
        return view('inventory.supplier_info', compact('m_supplier'));
    }

    public function supplier_info_update(Request $request, $update)
    {

        $rules = [
            'txt_supplier_name' => 'required',
            'txt_supplier_add' => 'required',
            'txt_supplier_phone' => 'required',
        ];
        $customMessages = [
            'txt_supplier_name.required' => 'Supplier Name is required.',
            'txt_supplier_add.required' => 'Supplier Address is required.',
            'txt_supplier_phone.required' => 'Supplier Phone Number is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_suppliers = DB::table('pro_suppliers')->where('supplier_id', $request->txt_supplier_id)->where('supplier_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_suppliers === null) {

            DB::table('pro_suppliers')->where('supplier_id', $update)->update([
                'supplier_name' => $request->txt_supplier_name,
                'supplier_add' => $request->txt_supplier_add,
                'supplier_phone' => $request->txt_supplier_phone,
                'supplier_email' => $request->txt_supplier_email,
                'contact_person' => $request->txt_contact_person,
            ]);

            return redirect(route('supplier_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Receving Report


    //warehouse info
    public function warehouse_info()
    {
        $m_store = DB::table('pro_store_details')->where('valid', 1)->get();
        return view('inventory.warehouse_info', compact('m_store'));
    }

    public function warehouse_store(Request $request)
    {
        $rules = [
            'txt_store_name' => 'required',
            'txt_store_address' => 'required',
        ];

        $customMessages = [
            'txt_store_name.required' => 'Warehouse Name Required.',
            'txt_store_address.required' => 'Warehouse Address Required.',
        ];

        $this->validate($request, $rules, $customMessages);


        $data = array();
        $data['store_name'] = $request->txt_store_name;
        $data['store_address'] = $request->txt_store_address;
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');

        DB::table('pro_store_details')
            ->where('valid', 1)
            ->insert($data);

        return back()->with('success', 'Add Successfully');
    }

    public function warehouse_edit($id)
    {
        $m_store_edit = DB::table('pro_store_details')
            ->where('store_id', $id)
            ->where('valid', 1)
            ->first();
        return view('inventory.warehouse_info', compact('m_store_edit'));
    }

    public function warehouse_update(Request $request, $id)
    {
        $rules = [
            'txt_store_name' => 'required',
            'txt_store_address' => 'required',
        ];

        $customMessages = [
            'txt_store_name.required' => 'Warehouse Name Required.',
            'txt_store_address.required' => 'Warehouse Address Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['store_name'] = $request->txt_store_name;
        $data['store_address'] = $request->txt_store_address;
        $data['user_id'] = Auth::user()->emp_id;

        DB::table('pro_store_details')
            ->where('store_id', $id)
            ->where('valid', 1)
            ->update($data);
        return redirect()->route('warehouse_info')->with('success', 'Update Successfully');
    }

    //Requisition
    public function requisition()
    {
        $m_projects = DB::table('pro_projects')->where('valid', 1)->get();
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', 'ASC')
            ->get();
        return view('inventory.mt_requisition', compact('m_projects', 'm_product'));
    }

    // requisition master
    public function requisition_store(Request $request)
    {

        $rules = [
            'cbo_project_id' => 'required|integer|between:1,2000',
            'cbo_product' => 'required|integer|between:1,20000',
            'txt_product_qty' => 'required',
        ];

        $customMessages = [
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
            'cbo_product.required' => 'Select Product.',
            'cbo_product.integer' => 'Select Product.',
            'cbo_product.between' => 'Select Product.',
            'txt_product_qty.required' => 'Product Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $product_sub_group = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();

        $last_req_no = DB::table('pro_requisition_master')->orderByDesc("requisition_master_id")->first();
        if (isset($last_req_no)) {
            $mnum = str_replace("R", "", $last_req_no->req_no);
            $req_no =  date("Ym") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "R";
        } else {
            $req_no = date("Ym") . "00001R";
        }

        if ($request->free_warrenty == 'on') {
            $free_warrenty = 1; //Free warranty
        } else {
            $free_warrenty = '';
        }


        //master
        $data = array();
        $data['req_no'] = $req_no;
        $data['project_id'] = $request->cbo_project_id;
        $data['department_id'] = '2'; // 2-> maintenance
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['free_warrenty'] = $free_warrenty;
        $data['valid'] = 1;
        $req_master_id = DB::table('pro_requisition_master')
            ->insertGetId($data);

        //Details
        $data = array();
        $data['requisition_master_id'] = $req_master_id;
        $data['req_no'] =  $req_no;
        $data['project_id'] =  $request->cbo_project_id;
        $data['department_id'] = '2'; // 2-> maintenance
        $data['pg_id'] = $product_sub_group->pg_id;
        $data['pg_sub_id'] = $product_sub_group->pg_sub_id;
        $data['product_id'] = $request->cbo_product;
        $data['product_qty'] = $request->txt_product_qty;
        $data['product_price'] = $request->txt_product_price;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_requisition_details')->insert($data);


        return redirect()->route('mt_requisition_product', $req_master_id);
    }

    // requisition details
    public function requisition_product($id)
    {
        $req_master = DB::table('pro_requisition_master')->where('requisition_master_id', $id)->first();
        $req_details_product_id = DB::table('pro_requisition_details')->where('requisition_master_id', $id)->pluck('product_id');
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->whereNotIn('product_id', $req_details_product_id)
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', 'ASC')
            ->get();
        $req_details = DB::table('pro_requisition_details')->where('requisition_master_id', $id)->get();
        return view('inventory.requisition_details', compact('req_master', 'm_product', 'req_details'));
    }
    public function requisition_add_product(Request $request, $id)
    {

        $rules = [
            'cbo_product' => 'required|integer|between:1,20000',
            'txt_product_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product.required' => 'Select Product.',
            'cbo_product.integer' => 'Select Product.',
            'cbo_product.between' => 'Select Product.',
            'txt_product_qty.required' => 'Product Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $product_sub_group = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();
        $req_master = DB::table('pro_requisition_master')->where('requisition_master_id', $id)->first();
        // $txt_req_no=$req_master->$req_no;
        // return  $req_master;
        $data = array();
        $data['requisition_master_id'] = $req_master->requisition_master_id;
        $data['req_no'] = $req_master->req_no;
        $data['project_id'] = $req_master->project_id;
        $data['department_id'] = $req_master->department_id;
        $data['pg_id'] = $product_sub_group->pg_id;
        $data['pg_sub_id'] = $product_sub_group->pg_sub_id;
        $data['product_id'] = $request->cbo_product;
        $data['product_qty'] = $request->txt_product_qty;
        $data['product_price'] = $request->txt_product_price;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $data['valid'] = 1;
        DB::table('pro_requisition_details')->insert($data);
        return redirect()->route('mt_requisition_product', $id)->with('success', "Add Successfully!");
    }

    public function requisition_product_edit($id)
    {
        $edit_req_details = DB::table('pro_requisition_details')->where('requisition_details_id', $id)->first();
        $edit_req_master = DB::table('pro_requisition_master')->where('requisition_master_id', $edit_req_details->requisition_master_id)->first();
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', 'ASC')
            ->get();
        return view('inventory.requisition_details', compact('edit_req_details', 'm_product', 'edit_req_master'));
    }
    public function requisition_product_update(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required|integer|between:1,20000',
            'txt_product_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product.required' => 'Select Product.',
            'cbo_product.integer' => 'Select Product.',
            'cbo_product.between' => 'Select Product.',
            'txt_product_qty.required' => 'Product Quantity is Required.',
        ];

        $this->validate($request, $rules, $customMessages);
        $product_sub_group = DB::table('pro_product')->where('product_id', $request->cbo_product)->first();
        $edit_req_details = DB::table('pro_requisition_details')->where('requisition_details_id', $id)->first();
        $data = array();
        $data['pg_id'] = $product_sub_group->pg_id;
        $data['pg_sub_id'] = $product_sub_group->pg_sub_id;
        $data['product_id'] = $request->cbo_product;
        $data['product_qty'] = $request->txt_product_qty;
        $data['product_price'] = $request->txt_product_price;
        DB::table('pro_requisition_details')->where('requisition_details_id', $id)->update($data);
        return redirect()->route('mt_requisition_product', $edit_req_details->requisition_master_id)->with('success', "Update Successfully!");
    }

    public function requisition_finish($id)
    {
        DB::table('pro_requisition_master')->where('requisition_master_id', $id)->update(['status' => 2]);
        DB::table('pro_requisition_details')->where('requisition_master_id', $id)->update(['status' => 2]);
        $m_requisition_master = DB::table('pro_requisition_details')->where('requisition_master_id', $id)->first();
        if ($m_requisition_master) {
            //Notification for our website
            $messages = "$m_requisition_master->req_no | Requisition | Date: $m_requisition_master->entry_date | 
                    Time: $m_requisition_master->entry_time";
            $report_to = ["00000104", "00000184", "00000185", "00000186"];
            $link = route("mt_requisition_admin_approved_details", $id);
            for ($i = 0; $i < count($report_to); $i++) {
                DB::table('pro_alart_massage')->insert([
                    'massage' => $messages,
                    'refarence_id' => "R$m_requisition_master->requisition_master_id",
                    'report_to' => $report_to[$i],
                    'user_id' => Auth::user()->emp_id,
                    'entry_date' => date("Y-m-d"),
                    'entry_time' => date("h:i:s"),
                    'valid' => 1,
                    'department_id' => 4,  //4 is inventory
                    'link' => $link,
                    'color' => "inventory_color"
                ]);
            }
        }
        return redirect()->route('mt_requisition')->with('success', "Add Successfully!");
    }

    //Requation Admin Approved
    public function requisition_admin_approved_list()
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('department_id', 2)
            ->where('status', 2)
            ->where('valid', 1)
            ->get();
        return view('inventory.mt_requisition_admin_approved_list', compact('m_requisition_master'));
    }

    public function requisition_admin_approved_details($id)
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->where('status', 2)
            ->first();

        $m_requisition_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->where('status', 2)
            ->get();
        return view('inventory.requisition_admin_approved_details', compact('m_requisition_details', 'm_requisition_master'));
    }

    public function requisition_admin_approved_final(Request $request, $id)
    {
        $rules = [
            'txt_approved_qty' => 'required',
        ];

        $customMessages = [
            'txt_approved_qty.required' => 'Approved Quantity is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();
        $r_details = DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->first();

        if ($request->txt_approved_qty > $r_details->product_qty) {
            return back()->with('warning', "Approved Quantity Can not getter then product qty.");
        }

        DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->update([
                'status' => 3, // 3 - Accept Requisition Admin
                'approved_qty' => $request->txt_approved_qty,
                'approved_id' => $user->emp_id,
                'approved_date' => date("Y-m-d"),
                'approved_time' => date("H:i:s"),
            ]);

        //
        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->count();

        $data2 = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $r_details->requisition_master_id)
            ->where('valid', 1)
            ->where('status', 3)
            ->count();

        if ($data ==  $data2) {
            DB::table('pro_requisition_master')
                ->where('requisition_master_id', '=', $r_details->requisition_master_id)
                ->update([
                    'status' => 3, // 3 - Accept requisition Admin
                    'approved_id' => $user->emp_id,
                    'approved_date' => date("Y-m-d"),
                    'approved_time' => date("H:i:s"),
                ]);

            if ($r_details->requisition_master_id) {
                DB::table('pro_alart_massage')->where('refarence_id', "R$r_details->requisition_master_id")->update(['valid' => 0]);
            }

            return redirect()->route('mt_rpt_requisition_details', $r_details->requisition_master_id)->with('success', "Approved Successfully!");
        } else {
            return back()->with('success', "Add Successfully!");
        }
    }

    public function requisition_admin_approved_reject(Request $request)
    {

        $id = $request->txt_details;
        $id2 = $request->txt_master;

        // valid 0 - Reject Requisition product and approved 0 qty
        DB::table('pro_requisition_details')
            ->where('requisition_details_id', '=', $id)
            ->update([
                'status' => 4,
                'valid' => 0,
                'approved_qty' => 0,
                'approved_id' =>  Auth::user()->emp_id,
                'approved_date' => date("Y-m-d"),
                'approved_time' => date("H:i:s"),
            ]);

        //
        $data = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id2)
            ->where('valid', 1)
            ->count();

        $data2 = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id2)
            ->where('valid', 1)
            ->where('status', 3)
            ->count();

        if ($data ==  $data2) {
            DB::table('pro_requisition_master')
                ->where('requisition_master_id', '=', $id2)
                ->update([
                    'status' => 3, // 3 - Accespt requisition Admin
                    'approved_id' => Auth::user()->emp_id,
                    'approved_date' => date("Y-m-d"),
                    'approved_time' => date("H:i:s"),
                ]);

            if ($id2) {
                DB::table('pro_alart_massage')->where('refarence_id', "R$id2")->update(['valid' => 0]);
            }

            return redirect()->route('mt_rpt_requisition_details', $id2)->with('success', "Approved Successfully!");
        } else {
            return back()->with('success', "Reject Successfully!");
        }
    }

    //Requation Admin Approved End 

    //RPT Requation
    public function RPTRequisitionAll()
    {

        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_requisition_master = DB::table('pro_requisition_master')
            ->whereNotIn('status', [1, 2])
            ->where('entry_date', date("Y-m-d"))
            ->where('department_id', 2)
            ->where('valid', 1)
            ->orderByDesc('requisition_master_id')
            ->get();

        return view('inventory.rpt_mt_requisition_all', compact('m_requisition_master', 'form', 'to'));
    }

    public function RPTRequisitionSearch(Request $request)
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

        $search_requisition_master = DB::table('pro_requisition_master')
            ->whereNotIn('status', [1, 2])
            ->whereBetween('entry_date', [$request->txt_from, $request->txt_to])
            ->where('department_id', 2)
            ->where('valid', 1)
            ->orderByDesc('requisition_master_id')
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;

        return view('inventory.rpt_mt_requisition_all', compact('search_requisition_master', 'form', 'to'));
    }

    public function RPTRequisitionDetails($id)
    {

        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->first();

        $m_requisition_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->get();
        return view('inventory.rpt_requisition_details', compact('m_requisition_details', 'm_requisition_master'));
    }

    public function RPTRequisitionPrint(Request $request, $id)
    {
        $data = array();
        $all_product_id = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->pluck('product_id');

        for ($i = 0; $i < count($all_product_id); $i++) {
            $product_id = "p$all_product_id[$i]";
            if ($request[$product_id] == $all_product_id[$i]) {
                array_push($data, $all_product_id[$i]);
            }
        }


        $m_requisition_master = DB::table('pro_requisition_master')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->first();

        $m_requisition_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->get();
        return view('inventory.rpt_requisition_print', compact('m_requisition_details', 'm_requisition_master', 'data'));
    }


    //Ajax Requation 
    public function GetProductUnit($id)
    {
        $product = DB::table('pro_product')
            ->where('product_id', $id)
            ->first();
        $data = DB::table('pro_units')->where('unit_id', $product->unit_id)->first();
        return response()->json($data);
    }
    public function GetSupplierDetails($id)
    {
        $data = DB::table('pro_suppliers')->where('supplier_id', $id)->first();
        return response()->json($data);
    }

    //End requisition


    //End Requisition

    // Delivery challan
    public function mt_delivery_challan()
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->whereNotIn('status', [1, 2])
            ->where('dch_status', null)
            ->where('valid', 1)
            ->orderByDesc('requisition_master_id')
            ->get();
        return view('inventory.mt_delivery_challan', compact('m_requisition_master'));
    }
    public function mt_delivery_challan_master($id)
    {
        $m_requisition_master = DB::table('pro_requisition_master')
            ->leftJoin('pro_projects', 'pro_requisition_master.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_employee_info', 'pro_requisition_master.approved_id', 'pro_employee_info.employee_id')
            ->select('pro_requisition_master.*', 'pro_projects.project_name', 'pro_projects.project_address', 'pro_employee_info.employee_name as mgm_name')
            ->where('pro_requisition_master.requisition_master_id', $id)
            ->where('pro_requisition_master.valid', 1)
            ->first();
        $d_challan_master = DB::table("pro_delivery_chalan_master")->where('status', 1)->get();

        $req_details_product_id = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $id)
            ->where('valid', 1)
            ->where('dch_status', null)
            ->pluck('product_id');
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->whereIn('pro_product.product_id', $req_details_product_id)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();
        $m_wearhouse =  DB::table("pro_store_details")
            ->select("store_name", "store_id")
            ->where('valid', 1)
            ->get();
        return view('inventory.mt_delivery_challan_master', compact('m_product', 'm_wearhouse', 'm_requisition_master', 'd_challan_master'));
    }

    public function mt_delivery_challan_store(Request $request)
    {
        $rules = [
            'cbo_product' => 'required|integer|between:1,10000',
            'txt_quantity' => 'required',
            'txt_dcm_date' => 'required',
            'cbo_address' => 'required',
            'cbo_store_id' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'cbo_product.integer' => 'Select Product',
            'cbo_product.between' => 'Select Product',
            'txt_quantity.required' => 'QTY is required!',
            'txt_dcm_date.required' => 'DC Date is required!',
            'cbo_address.required' => 'Address is required!',
            'cbo_store_id.required' => 'Select Warehouse',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $product = DB::table('pro_product')
            ->where('product_id', $request->cbo_product)
            ->where('valid', 1)
            ->first();

        //create challan no
        $last_chalan_no = DB::table('pro_delivery_chalan_master')->orderByDesc("chalan_no")->first();
        if (isset($last_chalan_no)) {
            $mnum = str_replace("D", "", $last_chalan_no->chalan_no);
            $chalan_no =  date("Ym") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "D";
        } else {
            $chalan_no = date("Ym") . "00001D";
        }

        //stock check
        $balance = $request->txt_balance;


        if ($request->txt_quantity > $balance) {
            return back()->with('warning', "Deliver Qty Getter Then Balance Qty ($request->txt_quantity > $balance)");
        } else if ($balance <= 0) {
            return back()->with('warning', " Balance Qty  $balance <= 0 ");
        } else {

            // qty check

            $req_details = DB::table('pro_requisition_details')
                ->where('requisition_master_id', $request->cbo_requisition_master_id)
                ->where('product_id', $request->cbo_product)
                ->where('dch_status', null)
                ->where('valid', 1)
                ->first();
            $req_details_qty = $req_details->approved_qty - ($req_details->dch_qty == null ? '0' : $req_details->dch_qty);
            if ($request->txt_quantity > $req_details_qty) {
                return back()->with('warning', "Deliver Qty Getter Then Requiction Qty ($request->txt_quantity > $req_details_qty)");
            } else {
                $master_id = DB::table('pro_delivery_chalan_master')->insertGetId([
                    'requisition_master_id' => $request->cbo_requisition_master_id,
                    'req_no' => $request->cbo_req_no,
                    'req_date' => $request->cbo_approved_date,
                    'chalan_no' => $chalan_no,
                    'dc_date' => $request->txt_dcm_date,
                    'store_id' => $request->cbo_store_id,
                    'project_id' => $request->cbo_project_id,
                    'address' => $request->cbo_address,
                    'remark' => $request->txt_remark,
                    'user_id' => $m_user_id,
                    'status' => 1,
                    'valid' => 1,
                    'entry_date' => date("Y-m-d"),
                    'entry_time' => date("h:i:s"),
                ]);

                $data = array();
                $data['requisition_master_id'] = $request->cbo_requisition_master_id;
                $data['req_no'] = $request->cbo_req_no;
                $data['req_date'] = $request->cbo_approved_date;
                $data['delivery_chalan_master_id'] = $master_id;
                $data['chalan_no'] = $chalan_no;
                $data['dc_date'] = $request->txt_dcm_date;
                $data['store_id'] = $request->cbo_store_id;
                $data['pg_id'] = $product->pg_id;
                $data['pg_sub_id'] = $product->pg_sub_id;
                $data['product_id'] = $request->cbo_product;
                $data['unit_id'] = $product->unit_id;
                $data['del_qty'] = $request->txt_quantity;
                $data['remark'] = $request->txt_remark;
                $data['user_id'] =  $m_user_id;
                $data['status'] = 1;
                $data['valid'] = 1;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:s");
                DB::table('pro_delivery_chalan_details')->insert($data);

                //update Requiction product status and qty
                if ($req_details_qty == $request->txt_quantity) {
                    DB::table('pro_requisition_details')
                        ->where('requisition_master_id', $request->cbo_requisition_master_id)
                        ->where('product_id', $request->cbo_product)
                        ->where('dch_status', null)
                        ->where('valid', 1)
                        ->update(['dch_status' => 1, 'dch_qty' => $request->txt_quantity]);
                } else {
                    DB::table('pro_requisition_details')
                        ->where('requisition_master_id', $request->cbo_requisition_master_id)
                        ->where('product_id', $request->cbo_product)
                        ->where('dch_status', null)
                        ->where('valid', 1)
                        ->update(['dch_qty' => $request->txt_quantity]);
                }

                //update Requiction master
                $data =  DB::table('pro_requisition_details')
                    ->where('requisition_master_id', $request->cbo_requisition_master_id)
                    ->where('valid', 1)
                    ->count();

                $data_delivery =  DB::table('pro_requisition_details')
                    ->where('requisition_master_id', $request->cbo_requisition_master_id)
                    ->where('dch_status', 1)
                    ->where('valid', 1)
                    ->count();

                if ($data ==  $data_delivery) {
                    DB::table('pro_requisition_master')
                        ->where('requisition_master_id', $request->cbo_requisition_master_id)
                        ->where('valid', 1)
                        ->update(['dch_status' => 1]);
                }

                return redirect()->route('mt_delivery_challan_details', $chalan_no)->with('success', "Add Successfully");
            } //if($req_details_qty > $request->txt_quantity){

        } //if ($request->txt_quantity > $balance) {
    }

    public function mt_delivery_challan_details($id)
    {
        $d_challan_master = DB::table("pro_delivery_chalan_master")
            ->leftJoin('pro_store_details', 'pro_delivery_chalan_master.store_id', 'pro_store_details.store_id')
            ->select('pro_delivery_chalan_master.*', 'pro_store_details.store_name')
            ->where("pro_delivery_chalan_master.chalan_no", $id)
            ->where('pro_delivery_chalan_master.valid', 1)
            ->first();
        $m_requisition_master = DB::table('pro_requisition_master')
            ->leftJoin('pro_projects', 'pro_requisition_master.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_employee_info', 'pro_requisition_master.approved_id', 'pro_employee_info.employee_id')
            ->select('pro_requisition_master.*', 'pro_projects.project_name',  'pro_projects.project_address', 'pro_employee_info.employee_name as mgm_name')
            ->where('pro_requisition_master.requisition_master_id', $d_challan_master->requisition_master_id)
            ->where('pro_requisition_master.valid', 1)
            ->first();
        $d_challan_details = DB::table("pro_delivery_chalan_details")
            ->where("chalan_no", $id)
            ->where("status", 1)
            ->where('valid', 1)
            ->get();

        // Requisition Product
        $delivery_product_id = DB::table("pro_delivery_chalan_details")->where("chalan_no", $id)->where('valid', 1)->pluck('product_id');
        $req_details_product_id = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $d_challan_master->requisition_master_id)
            ->whereNotIn('product_id', $delivery_product_id)
            ->where('dch_status', null)
            ->pluck('product_id');

        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('.pro_product.valid', 1)
            ->whereIn('pro_product.product_id', $req_details_product_id)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();

        return view('inventory.delivery_challan_details', compact('d_challan_master', 'm_requisition_master', 'd_challan_details', 'm_product'));
    }

    public function mt_delivery_challan_details_store(Request $request, $id)
    {
        $rules = [
            'cbo_product' => 'required|integer|between:1,10000',
            'txt_quantity' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'cbo_product.integer' => 'Select Product',
            'cbo_product.between' => 'Select Product',
            'txt_quantity.required' => 'QTY is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $d_challan_master = DB::table("pro_delivery_chalan_master")->where("chalan_no", $id)->where('valid', 1)->first();
        $product = DB::table('pro_product')
            ->where('product_id', $request->cbo_product)
            ->where('valid', 1)
            ->first();

        $balance =  $request->txt_balance;
        if ($request->txt_quantity > $balance) {
            return back()->with('warning', "Deliver Qty Getter Then Balance Qty ($request->txt_quantity > $balance)");
        } else if ($balance <= 0) {
            return back()->with('warning', " Balance Qty  $balance <= 0 ");
        } else {

            // qty check
            $req_details = DB::table('pro_requisition_details')
                ->where('requisition_master_id', $request->cbo_requisition_master_id)
                ->where('product_id', $request->cbo_product)
                ->where('dch_status', null)
                ->where('valid', 1)
                ->first();
            $req_details_qty = $req_details->approved_qty - ($req_details->dch_qty == null ? '0' : $req_details->dch_qty);
            if ($request->txt_quantity > $req_details_qty) {
                return back()->with('warning', "Deliver Qty Getter Then Requiction Qty ($request->txt_quantity > $req_details_qty)");
            } else {
                $data = array();
                $data['requisition_master_id'] = $d_challan_master->requisition_master_id;
                $data['req_no'] = $d_challan_master->req_no;
                $data['req_date'] = $d_challan_master->req_date;
                $data['delivery_chalan_master_id'] = $d_challan_master->delivery_chalan_master_id;
                $data['chalan_no'] = $d_challan_master->chalan_no;
                $data['dc_date'] = $d_challan_master->dc_date;
                $data['store_id'] = $d_challan_master->store_id;
                $data['pg_id'] = $product->pg_id;
                $data['pg_sub_id'] = $product->pg_sub_id;
                $data['product_id'] = $request->cbo_product;
                $data['unit_id'] = $product->unit_id;
                $data['del_qty'] = $request->txt_quantity;
                $data['remark'] = $request->txt_remark;
                $data['user_id'] =  $m_user_id;
                $data['status'] = 1;
                $data['valid'] = 1;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:s");
                DB::table('pro_delivery_chalan_details')->insert($data);

                //update Requiction product status and qty
                if ($req_details_qty == $request->txt_quantity) {
                    DB::table('pro_requisition_details')
                        ->where('requisition_master_id', $d_challan_master->requisition_master_id)
                        ->where('product_id', $request->cbo_product)
                        ->where('dch_status', null)
                        ->where('valid', 1)
                        ->update(['dch_status' => 1, 'dch_qty' => $request->txt_quantity]);
                } else {
                    DB::table('pro_requisition_details')
                        ->where('requisition_master_id', $d_challan_master->requisition_master_id)
                        ->where('product_id', $request->cbo_product)
                        ->where('dch_status', null)
                        ->where('valid', 1)
                        ->update(['dch_qty' => $request->txt_quantity]);
                }

                //update Requiction master
                $data =  DB::table('pro_requisition_details')
                    ->where('requisition_master_id', $d_challan_master->requisition_master_id)
                    ->where('valid', 1)
                    ->count();

                $data_delivery =  DB::table('pro_requisition_details')
                    ->where('requisition_master_id', $d_challan_master->requisition_master_id)
                    ->where('dch_status', 1)
                    ->where('valid', 1)
                    ->count();

                if ($data ==  $data_delivery) {
                    DB::table('pro_requisition_master')
                        ->where('requisition_master_id', $d_challan_master->requisition_master_id)
                        ->where('valid', 1)
                        ->update(['dch_status' => 1]);
                }

                return back()->with('success', "Add Successfully!");
            } //if ($request->txt_quantity > $req_details_qty) {

        } //  if ($request->txt_quantity > $balance) {
    }

    public function mt_delivery_challan_final($id)
    {
        DB::table("pro_delivery_chalan_master")->where('chalan_no', $id)->where('valid', 1)->update(['status' => 2]);
        DB::table("pro_delivery_chalan_details")->where('chalan_no', $id)->where('valid', 1)->update(['status' => 2]);

        $m_challan_details = DB::table("pro_delivery_chalan_details")
            ->where('chalan_no', $id)
            ->where('valid', 1)
            ->where('status', 2)
            ->get();

        //Stock table update data
        foreach ($m_challan_details as $row) {
            $product = DB::table('pro_product')
                ->where('product_id', $row->product_id)
                ->first();

            $total_product_qty = DB::table('pro_product_stock')
                ->where('product_id', $row->product_id)
                ->orderByDesc('stock_id')
                ->first();
            if (isset($total_product_qty)) {
                $total_stock =  $total_product_qty->total_stock - $row->del_qty;
            } else {
                $total_stock = 0 - $row->del_qty;
            }

            $data  = array();
            $data['chalan_no'] = $row->chalan_no;
            $data['dc_date'] = $row->dc_date;
            $data['pg_id'] = $product->pg_id;
            $data['pg_sub_id'] = $product->pg_sub_id;
            $data['product_id'] = $product->product_id;
            $data['qty'] = $row->del_qty;
            $data['total_stock'] = $total_stock;
            $data['status'] = 2;
            $data['request_status'] = 2;
            $data['store_id'] = $row->store_id;
            $data['user_id'] = Auth::user()->emp_id;
            $data['valid'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            DB::table('pro_product_stock')->insert($data);
        }

        return redirect()->route('rpt_mt_delivery_challan_view', $id);
    }

    public function rpt_mt_delivery_challan()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $d_challan =  DB::table("pro_delivery_chalan_master")
            ->where('status', 2)
            ->whereBetween('dc_date', [$form, $to])
            ->orderByDesc('chalan_no')
            ->get();
        return view('inventory.rpt_mt_delivery_challan', compact('d_challan', 'form', 'to'));
    }

    public function rpt_mt_delivery_datewise(Request $request)
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
        $d_challan =  DB::table("pro_delivery_chalan_master")
            ->whereBetween('dc_date', [$form, $to])
            ->where('status', 2)
            ->orderByDesc('chalan_no')
            ->get();
        return view('inventory.rpt_mt_delivery_challan',  compact('d_challan', 'form', 'to'));
    }

    public function rpt_mt_delivery_challan_view($id)
    {
        $d_challan =  DB::table("pro_delivery_chalan_master")->where('chalan_no', $id)->first();
        $d_details =  DB::table("pro_delivery_chalan_details")->where('chalan_no', $id)->get();
        return view('inventory.rpt_mt_delivery_challan_view', compact('d_challan', 'd_details'));
    }

    public function rpt_mt_delivery_challan_print(Request $request, $id)
    {

        $data = array();
        $all_product_id = DB::table('pro_delivery_chalan_details')
            ->where('chalan_no', $id)
            ->pluck('product_id');

        for ($i = 0; $i < count($all_product_id); $i++) {
            $product_id = "p$all_product_id[$i]";
            if ($request[$product_id] == $all_product_id[$i]) {
                array_push($data, $all_product_id[$i]);
            }
        }

        $d_challan =  DB::table("pro_delivery_chalan_master")->where('chalan_no', $id)->first();
        $d_details =  DB::table("pro_delivery_chalan_details")->where('chalan_no', $id)->get();
        return view('inventory.rpt_mt_delivery_challan_print', compact('d_challan', 'd_details', 'data'));
    }

    // Ajax Delivery challan
    public function GetDcProjectAddress($id)
    {
        $m_project = DB::table('pro_projects')
            ->where('project_id', $id)
            ->first();
        $data = array();
        $data['address'] =  $m_project->project_address == null ? '' : $m_project->project_address;
        return response()->json($data);
    }
    public function GetDcProductDetails($product_id, $requisition_master_id, $store_id)
    {

        //unit
        $product = DB::table('pro_product')
            ->where('product_id', $product_id)
            ->first();
        $unit = DB::table('pro_units')
            ->where('unit_id', $product->unit_id)
            ->first();
        $unit_name = $unit == null ? '' : $unit->unit_name;

        //stock
        $stock_in = DB::table('pro_product_stock')
            ->where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->where('status', 1)
            ->sum('qty');

        $stock_out = DB::table('pro_product_stock')
            ->where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->where('status', 2)
            ->sum('qty');
        $balance = $stock_in - $stock_out;

        //qty
        $req_details = DB::table('pro_requisition_details')
            ->where('requisition_master_id', $requisition_master_id)
            ->where('product_id', $product_id)
            ->where('dch_status', null)
            ->where('valid', 1)
            ->first();
        if ($req_details) {
            $qty = $req_details->approved_qty - ($req_details->dch_qty == null ? '0' : $req_details->dch_qty);
        } else {
            $qty = 0;
        }

        $data = array();
        $data['balance'] = $balance;
        $data['qty'] = $qty;
        $data['unit_name'] =  $unit_name;
        return response()->json($data);
    }


    //End Delivery challan

    //Fund  requistion
    public function fund_requisition()
    {
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->get();
        $m_projects = DB::table('pro_projects')->where('valid', 1)->get();
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('status', 1)->get();
        return view('inventory.fund_requisition', compact('m_projects', 'm_teams', 'fund_requisition_master'));
    }

    public function fund_requisition_store(Request $request)
    {
        $rules = [
            'cbo_team_id' => 'required',
            'cbo_project_id' => 'required',
        ];
        $customMessages = [
            'cbo_team_id.required' => 'Select Team',
            'cbo_project_id.required' => 'Select Project',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $last_req_no = DB::table('pro_fund_requisition_master')->orderByDesc("fund_requisition_master_id")->first();
        if (isset($last_req_no)) {
            $mnum = str_replace("FR", "", $last_req_no->fund_requisition_no);
            $req_no =  date("Ym") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "FR";
        } else {
            $req_no = date("Ym") . "00001FR";
        }

        //fund requisition master
        $data = array();
        $data['fund_requisition_no'] = $req_no;
        $data['team_id'] =  $request->cbo_team_id;
        $data['user_id'] =  $m_user_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        $fund_requisition_master_id =  DB::table('pro_fund_requisition_master')->insertGetId($data);

        DB::table('pro_fund_requisition_project')->insert([
            'fund_requisition_master_id' => $fund_requisition_master_id,
            'fund_requisition_no' =>  $req_no,
            'team_id' => $request->cbo_team_id,
            'project_id' => $request->cbo_project_id,
            'user_id' => $m_user_id,
            'status' => '1',
            'valid' => '1',
            'entry_date' =>  date("Y-m-d"),
            'entry_time' =>  date("h:i:s"),

        ]);


        return redirect()->route('fund_requisition_add_more', $fund_requisition_master_id)->with('success', 'Add Successfull');
    }

    public function fund_requisition_add_more($id)
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('team_id', $fund_requisition_master->team_id)
            ->first();
        $get_requisition_project_id = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->pluck('project_id');
        $m_projects = DB::table('pro_projects')
            ->whereNotIn('project_id', $get_requisition_project_id)
            ->where('valid', 1)
            ->get();
        $fund_requisition_project = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->get();
        return view('inventory.fund_requisition_add_more', compact('m_projects', 'm_teams', 'fund_requisition_master', 'fund_requisition_project'));
    }

    public function fund_requisition_add_more_store(Request $request, $id)
    {
        $rules = [
            'cbo_project_id' => 'required',
        ];
        $customMessages = [
            'cbo_project_id.required' => 'Select Project',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();

        $data = array();
        $data['fund_requisition_master_id'] =  $fund_requisition_master->fund_requisition_master_id;
        $data['fund_requisition_no'] =  $fund_requisition_master->fund_requisition_no;
        $data['team_id'] =  $fund_requisition_master->team_id;
        $data['project_id'] =  $request->cbo_project_id;
        $data['user_id'] =  $m_user_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        DB::table('pro_fund_requisition_project')->insert($data);
        return back()->with('success', 'Add Successfull');
    }

    public function fund_requisition_details($id)
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('team_id', $fund_requisition_master->team_id)
            ->first();
        $fund_requisition_project = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->get();
        $fund_requisition_details = DB::table('pro_fund_requisition_details')->where('fund_requisition_master_id', $id)->get();
        return view('inventory.fund_requisition_details', compact('m_teams', 'fund_requisition_master', 'fund_requisition_project', 'fund_requisition_details'));
    }

    public function fund_requisition_details_store(Request $request, $id)
    {
        $rules = [
            'txt_description' => 'required',
            'txt_rate' => 'required',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'txt_description.required' => 'Select Project',
            'txt_rate.required' => 'Rate is Required',
            'txt_qty.required' => 'Qty is Required',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();

        $data = array();
        $data['fund_requisition_master_id'] =  $fund_requisition_master->fund_requisition_master_id;
        $data['fund_requisition_no'] =  $fund_requisition_master->fund_requisition_no;
        $data['description'] =  $request->txt_description;
        $data['rate'] =  $request->txt_rate;
        $data['qty'] =  $request->txt_qty;
        $data['unit_name'] =  $request->txt_unit;
        $data['user_id'] =  $m_user_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        DB::table('pro_fund_requisition_details')->insert($data);
        return back()->with('success', 'Add Successfull');
    }

    public function fund_requisition_final($id)
    {
        DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->update(['status' => 2]);
        DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->update(['status' => 2]);
        DB::table('pro_fund_requisition_details')->where('fund_requisition_master_id', $id)->update(['status' => 2]);
        return redirect()->route('rpt_fund_requisition_view', $id)->with('success', 'Add Successfull');
    }
    public function rpt_fund_requisition_list()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->whereBetween('entry_date', [$form, $to])->where('status', 2)->get();
        return view('inventory.rpt_fund_requisition_list', compact('fund_requisition_master', 'form', 'to'));
    }

    public function rpt_fund_requisition_view($id)
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('team_id', $fund_requisition_master->team_id)
            ->first();
        $fund_requisition_project = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->get();
        $fund_requisition_details = DB::table('pro_fund_requisition_details')->where('fund_requisition_master_id', $id)->get();
        return view('inventory.rpt_fund_requisition_view', compact('fund_requisition_master', 'm_teams', 'fund_requisition_project', 'fund_requisition_details'));
    }

    public function rpt_fund_requisition_print($id)
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('team_id', $fund_requisition_master->team_id)
            ->first();
        $fund_requisition_project = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->get();
        $fund_requisition_details = DB::table('pro_fund_requisition_details')->where('fund_requisition_master_id', $id)->get();
        return view('inventory.rpt_fund_requisition_print', compact('fund_requisition_master', 'm_teams', 'fund_requisition_project', 'fund_requisition_details'));
    }

    public function rpt_fund_requisition_search(Request $request)
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

        $search_fund_requisition = DB::table('pro_fund_requisition_master')
            ->where('status', 2)
            ->whereBetween('entry_date', [$request->txt_from, $request->txt_to])
            ->where('valid', 1)
            ->get();

        $form = $request->txt_from;
        $to = $request->txt_to;

        return view('inventory.rpt_fund_requisition_list', compact('search_fund_requisition', 'form', 'to'));
    }


    public function fund_requisition_02()
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('status', 2)->get();
        return view('inventory.fund_requisition_02', compact('fund_requisition_master'));
    }

    public function fund_requisition_details_02($id)
    {
        $fund_requisition_master = DB::table('pro_fund_requisition_master')->where('fund_requisition_master_id', $id)->first();
        $m_teams = DB::table("pro_teams")
            ->leftJoin("pro_employee_info", "pro_teams.team_leader_id", "pro_employee_info.employee_id")
            ->leftJoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_teams.*", "pro_employee_info.employee_name", "pro_department.department_name")
            ->where('team_id', $fund_requisition_master->team_id)
            ->first();
        $fund_requisition_project = DB::table('pro_fund_requisition_project')->where('fund_requisition_master_id', $id)->get();
        $fund_requisition_details = DB::table('pro_fund_requisition_details')
            ->where('fund_requisition_master_id', $id)
            ->where('status', 2)
            ->get();
        $approved_fund_requisition_details = DB::table('pro_fund_requisition_details')
            ->where('fund_requisition_master_id', $id)
            ->where('status', 3)
            ->get();
        return view('inventory.fund_requisition_details_02', compact('fund_requisition_master', 'm_teams', 'fund_requisition_project', 'fund_requisition_details', 'approved_fund_requisition_details'));
    }

    public function fund_requisition_details_02_ok(Request $request, $id)
    {
        $rules = [
            'txt_actual_rate' => 'required',
            'txt_actual_qty' => 'required',
        ];

        $customMessages = [
            'txt_actual_rate.required' => 'Actual cost is Required.',
            'txt_actual_qty.required' => 'Qty is Required.',
        ];
        $this->validate($request, $rules, $customMessages);


        //File
        $file = $request->file('txt_file');
        if ($request->hasFile('txt_file')) {
            $filename = $id . $request->file('txt_file')->getClientOriginalName();
            $upload_path = "public/image/fund_requisition/";
            $image_url = $upload_path . $filename;
            $file->move($upload_path, $filename);
            $data['file'] = $image_url;
        } else {
            $image_url = '';
        }

        DB::table('pro_fund_requisition_details')
            ->where('fund_requisition_details_id', $id)
            ->update([
                'actual_rate' => $request->txt_actual_rate,
                'actual_qty' => $request->txt_actual_qty,
                'file' => $image_url,
                'status' => 3,
                'approved_id' => Auth::user()->emp_id,
            ]);

        return back()->with('success', "Update Successfull");
    }


    //End Fund requistion


    //material return 

    public function material_return()
    {
        //alredy challan inserted
        $alredy_chalan_no =  DB::table("pro_material_return_01")->where('valid', 1)->pluck('chalan_no');
        $d_challan =  DB::table("pro_delivery_chalan_master")
            ->whereNotIn('chalan_no', $alredy_chalan_no)
            ->select('pro_delivery_chalan_master.chalan_no', 'pro_delivery_chalan_master.dc_date')
            ->where('status', 2)
            ->orderByDesc('chalan_no')
            ->get();

        $m_material_return =  DB::table("pro_material_return_01")
            ->leftJoin('pro_projects', 'pro_material_return_01.project_id', 'pro_projects.project_id')
            ->select('pro_material_return_01.*', 'pro_projects.project_name')
            ->where('pro_material_return_01.status', 1)
            ->orderByDesc('return_no')
            ->get();


        $m_store = DB::table('pro_store_details')->where('valid', 1)->get();
        return view('inventory.material_return', compact('d_challan', 'm_material_return', 'm_store'));
    }

    public function GetDeliveryChallanDetails($id)
    {
        $data =  DB::table("pro_delivery_chalan_master")
            ->leftJoin('pro_projects', 'pro_delivery_chalan_master.project_id', 'pro_projects.project_id')
            ->select('pro_delivery_chalan_master.req_no', 'pro_projects.project_name', 'pro_delivery_chalan_master.req_date')
            ->where('pro_delivery_chalan_master.chalan_no', $id)
            ->where('pro_delivery_chalan_master.status', 2)
            ->first();
        return response()->json($data);
    }

    public function material_return_store(Request $request)
    {
        $rules = [
            'cbo_challan_no' => 'required',
            'txt_return_date' => 'required',
            'cbo_store_id' => 'required',
        ];

        $customMessages = [
            'cbo_challan_no.required' => 'Challan NO is Required.',
            'txt_return_date.required' => 'Return date is Required.',
            'cbo_store_id.required' => 'Select Warehouse',
        ];
        $this->validate($request, $rules, $customMessages);

        $last_return_no = DB::table('pro_material_return_01')->orderByDesc("return_id")->first();
        if (isset($last_return_no)) {
            $mnum = str_replace("MR", "", $last_return_no->return_no);
            $return_no =  date("Ym") . str_pad((substr($mnum, -5) + 1), 5, '0', STR_PAD_LEFT) . "MR";
        } else {
            $return_no = date("Ym") . "00001MR";
        }

        $m_user_id = Auth::user()->emp_id;
        $d_challan =  DB::table("pro_delivery_chalan_master")
            ->where('pro_delivery_chalan_master.chalan_no', $request->cbo_challan_no)
            ->where('pro_delivery_chalan_master.status', 2)
            ->first();

        $data = array();
        $data['return_no'] =  $return_no;
        $data['return_date'] =  $request->txt_return_date;
        $data['chalan_no'] =  $request->cbo_challan_no;
        $data['dc_date'] =  $d_challan->dc_date;
        $data['req_no'] =  $d_challan->req_no;
        $data['req_date'] =  $d_challan->req_date;
        $data['project_id'] =  $d_challan->project_id;
        $data['store_id'] =  $request->cbo_store_id;
        $data['remark'] =  $request->txt_remark;
        $data['user_id'] =  $m_user_id;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");
        DB::table('pro_material_return_01')->insert($data);

        return redirect()->route('material_return_details', $return_no);
    }

    public function material_return_details($id)
    {
        $m_material_return =  DB::table("pro_material_return_01")
            ->leftJoin('pro_projects', 'pro_material_return_01.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_store_details', 'pro_material_return_01.store_id', 'pro_store_details.store_id')
            ->select('pro_material_return_01.*', 'pro_projects.project_name', 'pro_store_details.store_name')
            ->where('pro_material_return_01.return_no', $id)
            ->first();

        $m_material_return_product_id = DB::table("pro_material_return_02")
            ->where("pro_material_return_02.return_no", $id)
            ->where("pro_material_return_02.status", 1)
            ->pluck('product_id');

        $d_challan_details = DB::table("pro_delivery_chalan_details")
            ->leftJoin('pro_product', 'pro_delivery_chalan_details.product_id', 'pro_product.product_id')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select('pro_delivery_chalan_details.*',  'pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where("pro_delivery_chalan_details.chalan_no", $m_material_return->chalan_no)
            ->whereNotIn("pro_delivery_chalan_details.product_id", $m_material_return_product_id)
            ->where("pro_delivery_chalan_details.status", 2)
            ->where('pro_delivery_chalan_details.valid', 1)
            ->get();

        $m_material_return_details = DB::table("pro_material_return_02")
            ->leftJoin('pro_product', 'pro_material_return_02.product_id', 'pro_product.product_id')
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select('pro_material_return_02.*', 'pro_product.*', 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where("pro_material_return_02.return_no", $id)
            ->where("pro_material_return_02.status", 1)
            ->get();

        return view('inventory.material_return_details', compact('m_material_return', 'm_material_return_details', 'd_challan_details'));
    }

    public function material_return_details_store(Request $request)
    {
        // $rules = [
        //     'txt_good_qty' => 'required',
        //     'txt_bad_qty' => 'required',
        // ];

        // $customMessages = [
        //     'txt_good_qty.required' => 'Good QTY is Required.',
        //     'txt_bad_qty.required' => 'Bad QTY is Required.',
        // ];
        // $this->validate($request, $rules, $customMessages);

        $good_qty =  $request->txt_good_qty == null ? 0 : $request->txt_good_qty;
        $bad_qty = $request->txt_bad_qty == null ? 0 : $request->txt_bad_qty;
        $request_qty = $good_qty + $bad_qty;

        if ($request_qty > $request->txt_qty) {
            return back()->with('warning', "Request Quantity greater then challan Quantity.");
        }

        $m_user_id = Auth::user()->emp_id;
        $d_challan_details = DB::table("pro_delivery_chalan_details")
            ->where("pro_delivery_chalan_details.delivery_chalan_details_id", $request->txt_delivery_chalan_details_id)
            ->where('pro_delivery_chalan_details.valid', 1)
            ->first();
        $product = DB::table('pro_product')
            ->where('product_id', $d_challan_details->product_id)
            ->where('valid', 1)
            ->first();
        $m_material_return =  DB::table("pro_material_return_01")
            ->where('pro_material_return_01.return_no', $request->txt_return_no)
            ->first();

        $check =  DB::table("pro_material_return_02")
            ->where('pro_material_return_02.return_no', $request->txt_return_no)
            ->where('pro_material_return_02.product_id', $d_challan_details->product_id)
            ->first();

        if (isset($check)) {
            return back()->with('warning', "Alredy Data Entry.");
        } else {

            $data = array();
            $data['return_no'] =  $request->txt_return_no;
            $data['return_date'] =  $m_material_return->return_date;
            $data['chalan_no'] =  $m_material_return->chalan_no;
            $data['dc_date'] =  $m_material_return->dc_date;
            $data['req_no'] =  $m_material_return->req_no;
            $data['req_date'] =  $m_material_return->req_date;
            $data['project_id'] =  $m_material_return->project_id;
            $data['pg_id'] = $product->pg_id;
            $data['pg_sub_id'] = $product->pg_sub_id;
            $data['product_id'] = $product->product_id;
            $data['unit_id'] = $product->unit_id;
            $data['good_qty'] = $good_qty;
            $data['bad_qty'] = $bad_qty;
            $data['remark'] =  $request->txt_remark;
            $data['user_id'] =  $m_user_id;
            $data['status'] = 1;
            $data['valid'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            DB::table('pro_material_return_02')->insert($data);
            return back()->with('success', "Add Successfull!");
        }
    }

    public function material_return_final($id)
    {
        DB::table("pro_material_return_01")
            ->where('pro_material_return_01.return_no', $id)
            ->update(['status' => 2]);
        DB::table("pro_material_return_02")
            ->where('pro_material_return_02.return_no', $id)
            ->update(['status' => 2]);


        //stock table update data
        $m_return_details = DB::table('pro_material_return_02')
            ->where('pro_material_return_02.return_no', $id)
            ->where('status', 2)
            ->get();

        foreach ($m_return_details as $row) {
            $product = DB::table('pro_product')
                ->where('product_id', $row->product_id)
                ->first();

            $total_product_qty = DB::table('pro_product_stock')
                ->where('product_id', $row->product_id)
                ->orderByDesc('stock_id')
                ->first();
            if (isset($total_product_qty)) {
                $total_stock =  $total_product_qty->total_stock + $row->good_qty;
            } else {
                $total_stock = 0 + $row->good_qty;
            }

            $data  = array();
            $data['return_no'] = $row->return_no;
            $data['return_date'] = $row->return_date;
            $data['pg_id'] = $product->pg_id;
            $data['pg_sub_id'] = $product->pg_sub_id;
            $data['product_id'] = $product->product_id;
            $data['qty'] = $row->good_qty;
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

        return redirect()->route('material_return')->with('success', "Add Successfull!");
    }

    //Report
    public function rpt_material_return()
    {
        $form = date('Y-m-d');
        $to = date('Y-m-d');

        $m_material_return =  DB::table("pro_material_return_01")
            ->leftJoin('pro_employee_info', 'pro_material_return_01.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_projects', 'pro_material_return_01.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_store_details', 'pro_material_return_01.store_id', 'pro_store_details.store_id')
            ->select('pro_material_return_01.*', 'pro_projects.project_name', 'pro_employee_info.employee_name', 'pro_store_details.store_name')
            ->where('pro_material_return_01.status', 2)
            ->whereBetween('return_date', [$form, $to])
            ->orderByDesc('return_no')
            ->get();

        return view('inventory.rpt_material_return', compact('m_material_return', 'form', 'to'));
    }

    public function rpt_material_return_datewise(Request $request)
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

        $m_material_return =  DB::table("pro_material_return_01")
            ->leftJoin('pro_employee_info', 'pro_material_return_01.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_projects', 'pro_material_return_01.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_store_details', 'pro_material_return_01.store_id', 'pro_store_details.store_id')
            ->select('pro_material_return_01.*', 'pro_projects.project_name', 'pro_employee_info.employee_name', 'pro_store_details.store_name')
            ->where('pro_material_return_01.status', 2)
            ->whereBetween('return_date', [$form, $to])
            ->orderByDesc('return_no')
            ->get();
        return view('inventory.rpt_material_return', compact('m_material_return', 'form', 'to'));
    }

    public function rpt_material_return_view($id)
    {
        $m_material_return =  DB::table("pro_material_return_01")
            ->leftJoin('pro_employee_info', 'pro_material_return_01.user_id', 'pro_employee_info.employee_id')
            ->leftJoin('pro_projects', 'pro_material_return_01.project_id', 'pro_projects.project_id')
            ->leftJoin('pro_store_details', 'pro_material_return_01.store_id', 'pro_store_details.store_id')
            ->select('pro_material_return_01.*', 'pro_projects.project_name', 'pro_employee_info.employee_name', 'pro_store_details.store_name')
            ->where('pro_material_return_01.return_no', $id)
            ->where('pro_material_return_01.status', 2)
            ->where('pro_material_return_01.valid', 1)
            ->first();

        $m_material_return_details = DB::table("pro_material_return_02")
            ->leftJoin('pro_product', 'pro_material_return_02.product_id', 'pro_product.product_id')
            ->select('pro_material_return_02.*', 'pro_product.product_name')
            ->where("pro_material_return_02.return_no", $id)
            ->where("pro_material_return_02.status", 2)
            ->where("pro_material_return_02.valid", 1)
            ->get();

        return view('inventory.rpt_material_return_view', compact('m_material_return', 'm_material_return_details'));
    }



    //End material return


    //
    public function product_stock_month_close()
    {
        return view('inventory.product_stock_month_close');
    }

    public function product_stock_month_close_final(Request $request)
    {
        $rules = [
            'txt_month' => 'required',
        ];

        $customMessages = [
            'txt_month.required' => 'Month is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_first_date = date('Y-m-01', strtotime($request->txt_month));
        $m_last_date = date('Y-m-t', strtotime($request->txt_month));
        $m_year = date('Y', strtotime($request->txt_month));
        $m_month = date('m', strtotime($request->txt_month));

        if ($m_month == '01') {
            $closing_year = $m_year - 1;
            $closing_month = '12';
        } elseif ($m_month > '01') {
            $closing_year = $m_year;
            $closing_month = str_pad(($m_month - 1), 2, '0', STR_PAD_LEFT);
        }
        $stock_close_table = "pro_stock_close_$m_year" . "_$m_month";
        $previous_stock_close_table = "pro_stock_close_$closing_year" . "_$closing_month";

        if (Schema::hasTable("$stock_close_table")) {
        } else {
            //create table
            Schema::create("$stock_close_table", function (Blueprint $table1) {
                $table1->increments('stock_id');
                $table1->integer('pg_id')->length(11);
                $table1->integer('pg_sub_id')->length(11);
                $table1->integer('product_id')->length(11);
                $table1->double('qty', 15, 2)->default(0);
                $table1->integer('unit_id')->length(2);
                $table1->string('user_id', 8);
                $table1->date('entry_date');
                $table1->time('entry_time');
                $table1->integer('valid')->length(1);
                $table1->string('year', 4);
                $table1->string('month', 2);
            });
        }

        $m_product = DB::table('pro_product')
            ->where('valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();

        foreach ($m_product as $row) {
            $previous_product_qty = DB::table("$previous_stock_close_table")
                ->where('product_id', $row->product_id)
                ->where('month', $closing_month)
                ->where('valid', 1)
                ->first();
            $opening_balance =  $previous_product_qty == null ? 0 : $previous_product_qty->qty;

            $sum_purchase_master_qty = DB::table('pro_purchase_details')
                ->where('product_id', $row->product_id)
                ->whereBetween('purchase_invoice_date', [$m_first_date, $m_last_date])
                ->where('status', 3)
                ->where('valid', 1)
                ->sum('qty');
            $sum_delivary_challan = DB::table('pro_delivery_chalan_details')
                ->where('product_id', $row->product_id)
                ->whereBetween('dc_date', [$m_first_date, $m_last_date])
                ->where('status', 2)
                ->where('valid', 1)
                ->sum('del_qty');

            $sum_material_return = DB::table('pro_material_return_02')
                ->where('product_id', $row->product_id)
                ->whereBetween('return_date', [$m_first_date, $m_last_date])
                ->where('status', 2)
                ->where('valid', 1)
                ->sum('good_qty');

            $balance = ($opening_balance + $sum_purchase_master_qty + $sum_material_return) - $sum_delivary_challan;

            $data = array();
            $data['pg_id'] = $row->pg_id;
            $data['pg_sub_id'] = $row->pg_sub_id;
            $data['product_id'] = $row->product_id;
            $data['qty'] =  $balance;
            $data['unit_id'] =  $row->unit_id;
            $data['user_id'] = Auth::user()->emp_id;
            $data['valid'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            $data['year'] = $m_year;
            $data['month'] = $m_month;
            $check = DB::table("$stock_close_table")->where('product_id', $row->product_id)->first();
            if ($check) {
                DB::table("$stock_close_table")->where('product_id', $row->product_id)->update($data);
            } else {
                DB::table("$stock_close_table")->insert($data);
            }
        }

        return back()->with('success', "$request->txt_month Add Successfull");
    }



    //product stock
    public function rpt_product_stock()
    {
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();
        return view('inventory.rpt_product_stock', compact('m_product'));
    }
    public function rpt_product_stock_list(Request $request)
    {
        $rules = [
            'cbo_product' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product ',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();

        if ($request->cbo_product == 0) {
            $all_product = DB::table('pro_product')
                ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
                ->select("pro_product.product_id", "pro_product.product_name", "pro_product.product_des", 'pro_sizes.size_name', 'pro_origins.origin_name', 'pro_units.unit_name')
                ->where('pro_product.valid', 1)
                ->orderBy('pro_product.product_name', "ASC")
                ->get();
            $product_id = 0;
        } else {
            $all_product = DB::table('pro_product')
                ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
                ->select("pro_product.product_id", "pro_product.product_name", "pro_product.product_des", 'pro_sizes.size_name', 'pro_origins.origin_name', 'pro_units.unit_name')
                ->where('product_id', $request->cbo_product)
                ->where('pro_product.valid', 1)
                ->orderBy('pro_product.product_name', "ASC")
                ->get();
            $product_id = $request->cbo_product;
        }

        return view('inventory.rpt_product_stock_list', compact('all_product', 'm_product', 'product_id'));
    }

    public function rpt_product_stock_details($product_id)
    {

        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.product_id', $product_id)
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->first();

        $m_store =  DB::table("pro_store_details")
            ->where('valid', 1)
            ->get();

        return view('inventory.rpt_product_stock_details', compact('m_store', 'm_product'));
    }


    //product stock
    public function product_stock()
    {
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.*", 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();
        $m_wearhouse =  DB::table("pro_store_details")
            ->select("store_name", "store_id")
            ->where('valid', 1)
            ->get();

        return view('inventory.product_stock', compact('m_product', 'm_wearhouse'));
    }


    //status -> 1 in , 2 out product
    //request -> 5 opening, 2 delivery , 1 purchase , 4 return , 3 transfer
    public function product_stock_store(Request $request)
    {
        $rules = [
            'cbo_product' => 'required',
            'cbo_store_id' => 'required',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product.',
            'cbo_store_id.required' => 'Select Warehouse.',
            'txt_qty.required' => 'Qty is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $product = DB::table('pro_product')
            ->where('product_id', $request->cbo_product)
            ->first();

        $stock_product = DB::table('pro_product_stock')
            ->where('product_id', $request->cbo_product)
            ->sum('qty');
        $alredy_insert_check = DB::table('pro_product_stock')
            ->where('product_id', $request->cbo_product)
            ->where('store_id', $request->cbo_store_id)
            ->first();

        $data  = array();
        $data['pg_id'] = $product->pg_id;
        $data['pg_sub_id'] = $product->pg_sub_id;
        $data['product_id'] = $product->product_id;
        $data['qty'] = $request->txt_qty;
        $data['status'] = 1;
        $data['request_status'] = 5;
        $data['store_id'] = $request->cbo_store_id;
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        if ($alredy_insert_check != null) {
            $total_stock = ($stock_product + $request->txt_qty) - $alredy_insert_check->qty;
            $data['total_stock'] = $total_stock;
            DB::table('pro_product_stock')
                ->where('product_id', $request->cbo_product)
                ->where('store_id', $request->cbo_store_id)
                ->update($data);
            return back()->with('success', "Update Successfully");
        } else {
            $total_stock = $stock_product + $request->txt_qty;
            $data['total_stock'] = $total_stock;
            DB::table('pro_product_stock')->insert($data);
            return back()->with('success', "Add Successfully");
        }
    }



    public function product_transfer()
    {
        $m_wearhouse = DB::table('pro_store_details')->where('valid', 1)->get();
        $m_product =  DB::table("pro_product")
            ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
            ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
            ->select("pro_product.product_id", "pro_product.product_name", 'pro_product.product_des', 'pro_sizes.size_name', 'pro_origins.origin_name')
            ->where('pro_product.valid', 1)
            ->orderBy('pro_product.product_name', "ASC")
            ->get();
        return view('inventory.product_transfer', compact('m_product', 'm_wearhouse'));
    }

    public function GetProductDetails($product_id, $store_id)
    {
        //stock
        $stock_in = DB::table('pro_product_stock')
            ->where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->where('status', 1)
            ->sum('qty');

        $stock_out = DB::table('pro_product_stock')
            ->where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->where('status', 2)
            ->sum('qty');
        $balance = $stock_in - $stock_out;

        $data = array();
        $data['balance'] = $balance;
        return response()->json($data);
    }

    public function product_transfer_store(Request $request)
    {
        $rules = [
            'cbo_product' => 'required',
            'cbo_store_id' => 'required',
            'cbo_transfer_store_id' => 'required',
            'txt_transfer_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Product.',
            'cbo_store_id.required' => 'Select Warehouse.',
            'cbo_transfer_store_id.required' => 'Select Transfer Warehouse.',
            'txt_transfer_qty.required' => 'Transfer Qty is Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->txt_transfer_qty > $request->txt_balance) {
            return back()->with('warning', "Request qty greater then stock qty.");
        } elseif ($request->txt_transfer_qty < 0) {
            return back()->with('warning', "Request qty less then 0.");
        } else {
            $product = DB::table('pro_product')
                ->where('product_id', $request->cbo_product)
                ->first();

            $m_stock_product = DB::table('pro_product_stock')
                ->where('product_id', $request->cbo_product)
                ->orderByDesc('stock_id')
                ->first();
            $total_stock = $m_stock_product->total_stock;


            //first out warehouse
            $data  = array();
            $data['pg_id'] = $product->pg_id;
            $data['pg_sub_id'] = $product->pg_sub_id;
            $data['product_id'] = $product->product_id;
            $data['qty'] = $request->txt_transfer_qty;
            $data['total_stock'] = $total_stock;
            $data['status'] = 2;
            $data['request_status'] = 3;
            $data['store_id'] = $request->cbo_store_id;
            $data['user_id'] = Auth::user()->emp_id;
            $data['valid'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:s");
            DB::table('pro_product_stock')->insert($data);

            //Second In warehouse
            $data2  = array();
            $data2['pg_id'] = $product->pg_id;
            $data2['pg_sub_id'] = $product->pg_sub_id;
            $data2['product_id'] = $product->product_id;
            $data2['qty'] = $request->txt_transfer_qty;
            $data2['total_stock'] = $total_stock;
            $data2['status'] = 1;
            $data2['request_status'] = 3;
            $data2['store_id'] = $request->cbo_transfer_store_id;
            $data2['user_id'] = Auth::user()->emp_id;
            $data2['valid'] = 1;
            $data2['entry_date'] = date("Y-m-d");
            $data2['entry_time'] = date("h:i:s");
            DB::table('pro_product_stock')->insert($data2);

            return back()->with('success', "Transfer Successfully");
        }
        //if( $request->txt_transfer_qty > $request->txt_balance)
    }
}
