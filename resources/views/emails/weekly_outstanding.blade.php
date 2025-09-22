@extends('emails.layout')

@section('content')
    <h2>Weekly Outstanding Invoices</h2>
    <p>Hi {{ $invoices[0]->org->org_name }},</p>
    <p>This is a weekly reminder of your outstanding invoices. Please find the details below:</p>

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
        Please make payments to payment@emetrotel.com at your earliest convenience.
        If you have already made payments for any of these invoices, please disregard that portion of this notice.
    </p>

    <p>Thank you for your prompt attention to this matter.</p>
    <p>Best regards,<br>E-Metrotel</p>
@endsection
