<div class="tab-pane fade" id="v-pills-reservation" role="tabpanel"
aria-labelledby="v-pills-reservation-tab">
<div class="fp_dashboard_body">
    <h3>Reservations</h3>
    <div class="fp_dashboard_order">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr class="t_header">
                        <th>No</th>
                        <th>Reservation ID</th>
                        <th>Date/Time</th>
                        <th>Status</th>
                        <th>Person</th>
                    </tr>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>
                                <h5>#{{ ++$loop->index }}</h5>
                            </td>
                            <td>
                                <p>{{ $reservation->reservation_id }}</p>
                            </td>

                            <td>
                                <p>{{ $reservation->date }} | {{ $reservation->time }}</p>
                            </td>
                            <td>
                                @if ($reservation->status === 'pending')
                                    <span class="active"> <p>Pending</p></span>
                                @elseif($order->status === 'approved')
                                    <span class="active">Approved</span>
                                @elseif($order->status === 'completed')
                                    <span class="complete">Completed</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="cancel">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <p>{{ $reservation->persons }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
