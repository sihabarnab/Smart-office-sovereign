<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">QUOTATION DETAILS LIST</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">SL No</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Product Details</th>
                                <th class="text-center">Origin</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">Rate</th>
                                <th class="text-right">Total</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grand_total = 0;
                            @endphp
                            @foreach ($all_quotation_details as $key => $row)
                                @php
                                    $product = DB::table('pro_product')
                                        ->leftJoin('pro_sizes', 'pro_product.size_id', 'pro_sizes.size_id')
                                        ->leftJoin('pro_origins', 'pro_product.origin_id', 'pro_origins.origin_id')
                                        ->leftJoin('pro_units', 'pro_product.unit_id', 'pro_units.unit_id')
                                        ->select(
                                            'pro_product.*',
                                            'pro_sizes.size_name',
                                            'pro_origins.origin_name',
                                            'pro_units.unit_name',
                                        )
                                        ->Where('product_id', $row->product_id)
                                        ->first();
                                    $grand_total += $row->total;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        @isset($product->product_des)
                                            {{ $product->product_des }}
                                        @endisset
                                        @isset($product->size_name)
                                            -{{ $product->size_name }}
                                        @endisset

                                    </td>
                                    <td class="text-center">{{ $product->origin_name }}</td>
                                    <td class="text-center">{{ $product->unit_name }}</td>
                                    <td class="text-center">{{ number_format($row->qty, 2) }}</td>
                                    <td class="text-center">{{ number_format($row->rate, 2) }}</td>
                                    <td class="text-right">{{ number_format($row->total, 2) }}</td>
                                    <td> <a class="btn btn-primary"
                                            href="{{ route('mt_quotation_details_edit', $row->quotation_details_id) }}">Edit</a>
                                    </td>
                                    <td>
                                        <!-- Reject trigger modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#confirmModal"
                                            onclick='RemoveQutation("{{ $row->quotation_details_id }}")'>
                                            Remove
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td colspan="1" class="text-right">{{ number_format($grand_total, 2) }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@isset($m_quotation_master->reject_comment)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">REJECT COMMENT</h1>
                </div><!-- /.col -->

                <div class="col-12">
                    <textarea class="form-control" name="txt_comment" placeholder="Reject Comment" id="txt_comment" cols="30"
                        rows="2" readonly>{{ $m_quotation_master->reject_comment }}</textarea>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endisset

<!--Reject Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border border-success">
            <div class="modal-body text-center">
                <h2>Are You Confirm ?</h2> <br>
                <form action="{{ route('mt_quotation_details_remove') }}" method="GET">
                    @csrf
                    <input type="hidden" name="txt_details" id="txt_details">
                    <button type="button" class="btn btn-danger float-center m-1" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success float-center m-1">Yes</button>
                </form>

            </div>
        </div>
    </div>
</div>
