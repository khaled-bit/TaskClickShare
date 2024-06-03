<div class="container mt-4">


    <input type="text" wire:model.live.debounce.500ms="searchTerm" placeholder="Search by name or phone" class="form-control mb-3" />

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Client Name</th>
                <th>Phone Number</th>
                <th>Product Code</th>
                <th>Final Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->client_name }}</td>
                <td>{{ $order->phone_number }}</td>
                <td>{{ $order->product_code }}</td>
                <td>{{ $order->final_price }}</td>
                <td>{{ $order->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</div>
