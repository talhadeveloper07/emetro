@extends('emails.layout')

@section('content')
    <h2>Overdue Invoice Alert</h2>
    <p>Hi {{ $invoices[0]->org->org_name }},</p>
    <p>The following invoices has reached its due date and remains unpaid:</p>

    <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 10px; border: 1px solid #dee2e6;">Invoice Number</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Date</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Due Date</th>
            <th style="padding: 10px; border: 1px solid #dee2e6;">Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $invoice->invoice_no }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;">{!! $invoice->org->currency_symbol !!}{{ number_format($invoice->amount, 2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>


    <p>
        Please process the payment immediately to payment@emetrotel.com to avoid any service interruptions.
    </p>

    <p>Regards,<br>E-Metrotel</p>
@endsection
