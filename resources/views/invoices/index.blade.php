@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create New Invoice</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Subtotal</th>
                    <th>Discount Percentage</th>
                    <th>Discount Amount</th>
                    <th>Tax Percentage</th>
                    <th>Tax Amount</th>
                    <th>Total Bill Amount</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($invoice->subtotal, 2) }}</td>
                        <td>{{ $invoice->discount_percentage ?? 0 }}%</td> 
                        <td>{{ number_format($invoice->discount, 2) }}</td>
                        <td>{{ $invoice->tax_percentage ?? 0 }}%</td>
                        <td>{{ number_format($invoice->tax, 2) }}</td>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        <td>{{ ucfirst($invoice->payment_method) }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
