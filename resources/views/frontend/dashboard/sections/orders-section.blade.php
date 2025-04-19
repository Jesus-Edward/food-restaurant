<div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
aria-labelledby="v-pills-profile-tab">
<div class="fp_dashboard_body">
    <h3>order list</h3>
    <div class="fp_dashboard_order">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr class="t_header">
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <h5>#{{ $order->invoice_id }}</h5>
                            </td>
                            <td>
                                <p>{{ date('F d, Y', strtotime($order->created_at)) }}</p>
                            </td>
                            <td>
                                @if ($order->order_status === 'pending')
                                    <span class="active"> <p>Pending</p></span>
                                @elseif($order->order_status === 'processing')
                                    <span class="active">Processing</span>
                                @elseif($order->order_status === 'delivered')
                                    <span class="complete">Delivered</span>
                                @elseif($order->order_status === 'declined')
                                    <span class="cancel">Declined</span>
                                @endif
                            </td>
                            <td>
                                <h5>{{ currencyPosition($order->grand_total) }}</h5>
                            </td>
                            <td><a class="view_invoice" onclick="viewInvoice('{{ $order->id }}')">View Details</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @foreach($orders as $order)
        <div class="fp__invoice invoice_details_{{ $order->id }}">
            <a class="go_back  d-print-none"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
            <div class="fp__track_order d-print-none">
                <ul>
                    @if ($order->order_status === 'declined')
                        <li class=" declined_status {{ in_array($order->order_status, ['declined']) ? 'active' : '' }}">order declined</li>
                    @else
                        <li class="{{ in_array($order->order_status, ['pending', 'processing', 'delivered', 'declined']) ? 'active' : '' }}">order pending</li>
                        <li class="{{ in_array($order->order_status, ['processing', 'delivered', 'declined']) ? 'active' : '' }}">order processing</li>
                        <li class="{{ in_array($order->order_status, ['delivered']) ? 'active' : '' }}">order delivered</li>
                    @endif
                    
                    {{-- <li class="active">order declined</li> --}}
                </ul>
            </div>
            <div class="fp__invoice_header">
                <div class="header_address">
                    <h4>invoice to</h4>
                    <p>{{ @$order->userAddress->first_name }}</p>
                    <p>{{ @$order->address }}</p>
                    <p>{{ @$order->userAddress->phone }}</p>
                </div>
                <div class="header_address" style="width: 60%">
                    <p><b style="width: 140px">invoice no: </b><span>#{{ @$order->invoice_id }}</span></p>
                    <p><b style="width: 140px">Payment Status: </b> <span>{{ @$order->payment_status }}</span></p>
                    <p><b style="width: 140px">Payment Method: </b> <span>{{ @$order->payment_method }}</span></p>
                    {{-- <p><b style="width: 150px">Transaction ID: </b> <span>{{ @$order->transaction_id }}</span></p> --}}
                    <p><b>Date:</b style="width: 140px"> <span>{{ date('F d, Y', strtotime($order->created_at)) }}</span></p>
                </div>
            </div>
            <div class="fp__invoice_body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr class="border_none">
                                <th class="sl_no">SL</th>
                                <th class="package">item description</th>
                                <th class="price">Price</th>
                                <th class="qnty">Quantity</th>
                                <th class="total">Total</th>
                            </tr>
                            @foreach ($order->orderItems as $orderItem)
                            @php
                                $size = json_decode($orderItem->product_size);
                                $options = json_decode($orderItem->product_option);

                                $qty = $orderItem->qty;
                                            $sizePrice = $size->price ?? 0;
                                            $unit_price = $orderItem->unit_price;
                                            $optionPrice = 0;
                                            foreach ($options as $option) {
                                                $optionPrice += $option->price;
                                            }

                                $productTotal = ($sizePrice + $optionPrice + $unit_price) * $qty;
                            @endphp
                                <tr>
                                    <td class="sl_no">{{ ++$loop->index }}</td>
                                    <td class="package">
                                        <p>{{ $orderItem->product_name }}</p>
                                        <span class="size">{{ @$size->name }} {{ @$size->price ? currencyPosition(@$size->price): '' }}</span>
                                        <br>
                                        @foreach ($options as $option)
                                            <span class="coca_cola">{{ @$option->name }} ({{ @$option->price ? currencyPosition(@$option->price): '' }})</span>
                                        @endforeach
                                        
                                    </td>
                                    <td class="price">
                                        <b>{{ currencyPosition($orderItem->unit_price) }}</b>
                                    </td>
                                    <td class="qnty">
                                        <b>{{ $orderItem->qty }}</b>
                                    </td>
                                    <td class="total">
                                        <b>{{ currencyPosition($productTotal) }}</b>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>sub total</b>
                                </td>
                                <td class="qnty">
                                    <b>-</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($order->subtotal) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coupon" colspan="3">
                                    <b>(-) Discount coupon</b>
                                </td>
                                <td class="qnty">
                                    <b>-</b>
                                </td>
                                <td class="total coupon">
                                    <b>{{ currencyPosition($order->discount) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coast" colspan="3">
                                    <b>(+) Shipping Cost</b>
                                </td>
                                <td class="qnty">
                                    <b>-</b>
                                </td>
                                <td class="total coast">
                                    <b>{{ currencyPosition($order->delivery_charge) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>Total Paid</b>
                                </td>
                                <td class="qnty">
                                    <b>-</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($order->grand_total) }}</b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <a class="print_btn common_btn  d-print-none" onclick="printInvoice('{{ $order->id }}')" href="javascript:;"><i class="far fa-print"></i> print
                PDF</a>

        </div>
    @endforeach
</div>
</div>

@push('scripts')
    <script>
        function viewInvoice(id){
            $(".fp_dashboard_order").fadeOut();
            $(".invoice_details_"+id).fadeIn();
        }

        function printInvoice(id) {
            let printContent = $('.invoice_details_'+id).html();

                let printWindow = window.open('', '', 'width=600, height=600');
                printWindow.document.open();
                printWindow.document.write('<html>');

                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">');

                printWindow.document.write('<body>');
                printWindow.document.write(printContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.print();
                printWindow.close();
        }
    </script>
@endpush
