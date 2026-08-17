<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt_{{ $receipt->receipt_no }}</title>
    <style>
        /* Minimalist Print Layout Structural Rules - Single Page Bounded */
        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, 'DejaVu Sans', sans-serif;
        }
        body {
            font-size: 10.5px;
            color: #334155;
            line-height: 1.4;
            margin: 0;
            padding: 15px 20px;
            background-color: #FFFFFF;
        }

        /* Typography */
        h1, h2, h3, h4 {
            color: #0F172A;
            margin: 0;
            font-weight: 700;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-monospace { font-family: 'DejaVu Sans Mono', monospace; }
        .text-uppercase { text-transform: uppercase; }

        /* Tables & Structural Grid */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        td {
            vertical-align: top;
            padding: 0;
        }

        /* Header Frame */
        .header-boundary {
            border-bottom: 2px solid #0F172A;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        
        /* Company Name Styling matching Invoice Header */
        .brand-title {
            font-size: 20px;
            color: #0F172A;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        .brand-accent {
            font-size: 10px;
            color: #9A7B56; /* Accent Bronze */
            font-weight: 500;
            margin-top: 1px;
            margin-bottom: 4px;
        }
        .brand-meta {
            font-size: 9.5px;
            color: #64748B;
            line-height: 1.3;
        }
        .doc-header-title {
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 2px;
            color: #0F172A;
            line-height: 1;
            margin-bottom: 8px;
        }

        /* Dividers & Subheadings */
        .section-divider {
            border-bottom: 1px solid #9A7B56;
            margin-top: 2px;
            margin-bottom: 8px;
            padding-bottom: 2px;
        }
        .section-title {
            font-size: 9.5px;
            font-weight: 700;
            color: #0F172A;
            letter-spacing: 0.8px;
        }

        /* Profile Meta Blocks */
        .profile-header {
            font-size: 11.5px;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 3px;
        }
        .profile-text {
            font-size: 10px;
            color: #334155;
            line-height: 1.4;
        }

        /* Itemization Table */
        .clean-table {
            width: 100%;
            margin-top: 2px;
            margin-bottom: 12px;
        }
        .clean-table th {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748B;
            letter-spacing: 0.8px;
            padding: 6px 8px;
            border-bottom: 1px solid #0F172A;
        }
        .clean-table td {
            padding: 7px 8px;
            border-bottom: 1px solid #E2E8F0;
            color: #334155;
        }

        /* Calculation Ledger */
        .ledger-box {
            width: 280px;
            margin-left: auto;
            margin-top: 0;
        }
        .ledger-row td {
            padding: 4px 8px;
            font-size: 10px;
            color: #475569;
        }
        .ledger-row-grand td {
            padding: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #0F172A;
            border-top: 1px solid #0F172A;
            border-bottom: 2px double #0F172A;
        }

        /* Payment Confirmation Box */
        .confirmation-box {
            background-color: #F0FDF4;
            border-left: 2.5px solid #166534;
            padding: 8px 10px;
            font-size: 9px;
            color: #166534;
            border-top: 1px solid #DCFCE7;
            border-right: 1px solid #DCFCE7;
            border-bottom: 1px solid #DCFCE7;
            border-radius: 0 4px 4px 0;
            line-height: 1.35;
        }

        /* Paid Pill Badge */
        .paid-badge {
            display: inline-block;
            padding: 2px 8px;
            background-color: #DCFCE7;
            color: #166534;
            border-radius: 12px;
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <!-- Top Corporate Branding Block Header Frame -->
    <table class="header-boundary">
        <tr>
            <!-- Left Grid Pane: Identity info details -->
            <td width="65%">
                @if($company && $company->logo)
                    <img src="{{ public_path('storage/'.$company->logo) }}" style="max-height: 38px; max-width: 140px; object-fit: contain; margin-bottom: 4px; display: block;">
                @endif
                <div class="brand-title">{{ $company->company_name ?? 'KOFI AND KOD' }}</div>
                @if($company && $company->company_tagline)
                    <div class="brand-accent">{{ $company->company_tagline }}</div>
                @endif
                <div class="brand-meta">
                    @if($company && $company->address){!! nl2br(e($company->address)) !!}<br>@endif
                    @if($company && $company->phone)<strong>T:</strong> {{ $company->phone }} &nbsp;&bull;&nbsp; @endif
                    @if($company && $company->email)<strong>E:</strong> {{ $company->email }}@endif
                    @if($company && $company->website) &nbsp;&bull;&nbsp; <strong>W:</strong> {{ $company->website }}@endif
                </div>
            </td>
            
            <!-- Right Grid Pane: Document Header & Tracking Variables -->
            <td width="35%" class="text-right" style="vertical-align: bottom;">
                <div class="doc-header-title text-uppercase">Receipt</div>
                <div class="profile-text">
                    <strong>Receipt No:</strong> <span class="font-monospace" style="color: #9A7B56; font-weight: bold;">{{ $receipt->receipt_no }}</span><br>
                    <strong>Payment Date:</strong> {{ $receipt->payment_date->format('d M Y') }}<br>
                    <span class="paid-badge">PAID IN FULL</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Structural Layout Section Pane: Received From vs Payment & Project Details -->
    <table style="margin-bottom: 6px;">
        <tr>
            <!-- Left Side Column Panel: Client Information -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Received From</div>
                </div>
                <div class="profile-header">{{ $receipt->invoice->quotation->client->company_name }}</div>
                <div class="profile-text">
                    @if($receipt->invoice->quotation->client->contact_person)<strong>Attn:</strong> {{ $receipt->invoice->quotation->client->contact_person }}<br>@endif
                    @if($receipt->invoice->quotation->client->phone)<strong>Phone:</strong> {{ $receipt->invoice->quotation->client->phone }}<br>@endif
                    @if($receipt->invoice->quotation->client->email)<strong>Email:</strong> {{ $receipt->invoice->quotation->client->email }}<br>@endif
                    @if($receipt->invoice->quotation->client->address)
                        <strong>Address:</strong><br>
                        <span style="color: #64748B; font-size: 9px;">{!! nl2br(e($receipt->invoice->quotation->client->address)) !!}</span>
                    @endif
                </div>
            </td>
            
            <td width="4%"></td> <!-- Layout Spacer -->
            
            <!-- Right Side Column Panel: Payment & Project Meta -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Payment Details</div>
                </div>
                <div class="profile-header" style="color: #9A7B56;">{{ $receipt->invoice->quotation->project_name }}</div>
                <div class="profile-text">
                    <strong>Invoice No:</strong> <span class="font-monospace fw-semibold text-dark">{{ $receipt->invoice->invoice_no }}</span><br>
                    <strong>Payment Method:</strong> {{ $receipt->payment_method }}<br>
                    <strong>Payment Reference:</strong> <span class="font-monospace">{{ $receipt->reference_no ?: '-' }}</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- PAYMENT FOR (INVOICE ITEMS) SECTION -->
    <div class="section-divider" style="margin-top: 6px;">
        <div class="section-title text-uppercase">Payment For</div>
    </div>

    <table class="clean-table">
        <thead>
            <tr>
                <th width="7%" class="text-center">No.</th>
                <th>Description</th>
                <th width="25%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receipt->invoice->items as $item)
                <tr>
                    {{-- NUMBER --}}
                    <td class="text-center font-monospace" style="color:#64748B;">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- DESCRIPTION --}}
                    <td style="color:#0F172A;">
                        <strong style="display:block; font-size:10px;">
                            @if(($item->item_type ?? $item->type) === 'payment_phase' && $item->paymentTerm)
                                {{ $item->paymentTerm->title }}
                            @elseif(($item->item_type ?? $item->type) === 'change_request' && $item->changeRequest)
                                {{ $item->changeRequest->title }}
                            @else
                                {{ $item->title ?? $item->description }}
                            @endif
                        </strong>

                        {{-- SUBTEXT --}}
                        @if(($item->item_type ?? $item->type) === 'payment_phase' && $item->paymentTerm && $item->paymentTerm->description)
                            <div style="color:#64748B; font-size:8.5px; line-height:1.3; margin-top:1px;">
                                {{ $item->paymentTerm->description }}
                            </div>
                        @elseif(($item->item_type ?? $item->type) === 'change_request')
                            <div style="color:#9A7B56; font-size:8.5px; margin-top:1px;">
                                Additional Change Request Scope
                            </div>
                        @endif
                    </td>

                    {{-- AMOUNT --}}
                    <td class="text-right font-monospace" style="font-weight:700; color:#0F172A;">
                        RM {{ number_format($item->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center" style="padding:15px; color:#94A3B8;">
                        Payment for invoice {{ $receipt->invoice->invoice_no }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pricing Calculation Ledger & Confirmation Box Side-by-Side -->
    <table style="margin-top: 8px; page-break-inside: avoid;">
        <tr>
            <!-- Left Side Element: Official Confirmation Box -->
            <td width="55%" style="vertical-align: bottom;">
                <div class="confirmation-box">
                    <strong style="color: #166534; text-transform: uppercase; display: block; margin-bottom: 3px; font-size: 8px; letter-spacing: 0.3px;">Official Payment Confirmation</strong>
                    <div>
                        This receipt officially confirms that a payment of <strong>RM {{ number_format($receipt->amount_received, 2) }}</strong> was received on <strong>{{ $receipt->payment_date->format('d M Y') }}</strong> for invoice <strong>{{ $receipt->invoice->invoice_no }}</strong>.<br>
                        No outstanding balance remains for this transaction.
                    </div>
                </div>
            </td>
            
            <td width="5%"></td> <!-- Spatial Gap -->
            
            <!-- Right Side Element: Total Summary Ledger -->
            <td width="40%">
                <table class="ledger-box" style="width: 100%; margin: 0;">
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Invoice Total</td>
                        <td class="text-right font-monospace" style="color: #334155;">RM {{ number_format($receipt->invoice->total, 2) }}</td>
                    </tr>
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Amount Received</td>
                        <td class="text-right font-monospace text-success">RM {{ number_format($receipt->amount_received, 2) }}</td>
                    </tr>
                    <tr class="ledger-row-grand">
                        <td style="text-transform: uppercase; letter-spacing: 0.5px;">Total Settled</td>
                        <td class="text-right font-monospace">RM {{ number_format($receipt->amount_received, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Signature Row Block -->
    <table style="margin-top: 15px; page-break-inside: avoid;">
        <tr>
            <!-- Left-aligned Signature Block -->
            <td width="40%" class="text-left" style="vertical-align: bottom;">
                <div style="font-size: 9px; color: #64748B; margin-bottom: 2px; font-weight: 500;">Authorized Sign-off,</div>
                
                <div style="min-height: 35px; vertical-align: middle; margin-bottom: 2px;">
                    @if($company && $company->signature)
                        <img src="{{ public_path('storage/'.$company->signature) }}" style="max-height: 32px; max-width: 110px; object-fit: contain; display: block;">
                    @else
                        <div style="height: 32px;"></div>
                    @endif
                </div>
                
                <div style="border-top: 1px solid #E2E8F0; padding-top: 3px; font-weight: 700; color: #0F172A; font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $company->company_name ?? 'KOFI AND KOD' }}
                </div>
            </td>
            <!-- Right Spacer -->
            <td width="60%"></td>
        </tr>
    </table>

    <!-- Page Footer -->
    <div style="position: fixed; bottom: -5px; left: 0; right: 0; text-align: center; color: #94A3B8; font-size: 8px; font-family: sans-serif;">
        This is an official payment receipt generated by {{ $company->company_name ?? 'KOFI AND KOD' }}. @if($company && $company->website) &bull; {{ $company->website }} @endif
    </div>

</body>
</html>