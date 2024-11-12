@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Invoice #{{ $invoice->id }}</h1>
    <hr>

    <h3>Customer Details</h3>
    <p><strong>Name:</strong> {{ $invoice->user->name ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $invoice->user->email ?? 'N/A' }}</p>

    <h3>Invoice Summary</h3>
    <p><strong>Subtotal:</strong> {{ number_format($invoice->subtotal, 2) }}</p>
    <p><strong>Discount ({{ $invoice->discount_percentage }}%):</strong> {{ number_format($invoice->discount, 2) }}</p>
    <p><strong>Tax ({{ $invoice->tax_percentage }}%):</strong> {{ number_format($invoice->tax, 2) }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method) }}</p>

    <h3>Invoice Items</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
             @foreach($invoice->invoiceItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->product->price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
