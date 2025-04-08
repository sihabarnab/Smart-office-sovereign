<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>project Name</th>
                                <th>Customer Name</th>
                                <th>Contact Start</th>
                                <th>Contact End</th>
                                <th>lift Quantity</th>
                                <th>Service Bill</th>
                                <th>Remark</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contact_services as $key => $contact_service)
                            @php
                            $ci_bill_type=DB::table('pro_bill_type')->Where('bill_type_id',$contact_service->bill_type_id)->first();
                            @endphp
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $contact_service->project_name }}</td>
                                    <td>{{ $contact_service->customer_name }}</td>
                                    <td>{{ $contact_service->ct_period_start }}</td>
                                    <td>{{ $contact_service->ct_period_end }}</td>
                                    <td>{{ $contact_service->lift_qty }}</td>
                                    <td>{{ $contact_service->service_bill }}<BR>{{ $ci_bill_type->bill_type_name }}</td>
                                    <td>{{ $contact_service->remark }}</td>
                                    <td>
                                        <a  href="{{ route('mt_contract_service_info_edit', $contact_service->ct_service_id) }}"class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
