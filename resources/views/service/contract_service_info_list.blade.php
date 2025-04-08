<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Description</th>
                                <th>Contact Start</th>
                                <th>Contact End</th>
                                <th>Service Bill</th>
                                <th>Remark</th>
                                <th>File</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contact_services as $key => $contact_service)
                                @php
                                    $ci_bill_type = DB::table('pro_bill_type')
                                        ->Where('bill_type_id', $contact_service->bill_type_id)
                                        ->first();
                                    $m_lift = DB::table('pro_lifts')
                                        ->where('lift_id', $contact_service->lift_id)
                                        ->where('valid', '1')
                                        ->first();
                                    if($contact_service->file){
                                      $url = url('/');
                                        $url_pdf = "$url/$contact_service->file"; 
                                    }else{
                                        $url_pdf =""; 
                                    }
                                   
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                         Project: {{ $contact_service->project_name }} <br>
                                         Customer: {{ $contact_service->customer_name }} <br>
                                         @if (isset($m_lift))
                                         Lift: {{ $m_lift->lift_name }} | {{ $m_lift->remark }}
                                         @endif
                                    </td>
                                    <td>{{ $contact_service->ct_period_start }}</td>
                                    <td>{{ $contact_service->ct_period_end }}</td>
                                    <td>{{ $contact_service->service_bill }}<BR>{{ $ci_bill_type->bill_type_name }}</td>
                                    <td>{{ $contact_service->remark }}</td>
                                    <td>
                                        @if ($contact_service->file)
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfshowmodal" onclick='showPdf("{{$url_pdf}}")'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('contract_service_info_edit', $contact_service->ct_service_id) }}"class="btn btn-info btn-sm"><i
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

{{-- pdf show modal --}}
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="pdfshowmodal" tabindex="-1" role="dialog" aria-labelledby="pdfshowmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <iframe class="border border-primary" src="" title="description" id="setPdf" height="500" width="100%"></iframe>
      </div>
    </div>
  </div>