<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice_{{ $invoice->invoice_no }}</title>
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

        /* Payment Instruction Box */
        .instruction-box {
            background-color: #F8FAFC;
            border-left: 2px solid #9A7B56;
            padding: 8px 10px;
            font-size: 9.5px;
            color: #475569;
            border-top: 1px solid #E2E8F0;
            border-right: 1px solid #E2E8F0;
            border-bottom: 1px solid #E2E8F0;
            border-radius: 0 4px 4px 0;
            line-height: 1.35;
        }

        /* Change Items Sub-List Styling */
        .cr-sub-container {
            padding: 4px 6px 6px 6px;
            background: #F8FAFC;
            border-radius: 3px;
        }
        .cr-sub-item {
            padding: 1px 0;
            color: #475569;
            font-size: 8.5px;
            line-height: 1.3;
        }
    </style>
</head>
<body>

    <!-- Top Corporate Branding Block Header Frame (PRESERVED EXACTLY) -->
    <table class="header-boundary">
        <tr>
            <!-- Left Grid Pane: Identity info details -->
            <td width="65%">
                @if($company && $company->logo)
                    <img src="{{ public_path('storage/'.$company->logo) }}" style="max-height: 38px; max-width: 140px; object-fit: contain; margin-bottom: 4px; display: block;">
                @endif
                <div class="brand-title">{{ $company->company_name }}</div>
                @if($company->company_tagline)
                    <div class="brand-accent">{{ $company->company_tagline }}</div>
                @endif
                <div class="brand-meta">
                    {!! nl2br(e($company->address)) !!}<br>
                    <strong>T:</strong> {{ $company->phone }} &nbsp;&bull;&nbsp; <strong>E:</strong> {{ $company->email }}
                    @if($company->website) &nbsp;&bull;&nbsp; <strong>W:</strong> {{ $company->website }}@endif
                </div>
            </td>
            
            <!-- Right Grid Pane: Tracking metrics data variables -->
            <td width="35%" class="text-right" style="vertical-align: bottom;">
                <div class="doc-header-title text-uppercase">Invoice</div>
                <div class="profile-text">
                    <strong>Invoice No:</strong> <span class="font-monospace" style="color: #9A7B56; font-weight: bold;">{{ $invoice->invoice_no }}</span><br>
                    <strong>Issue Date:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Structural Layout Section Pane: Client Account vs Project Overview -->
    <table style="margin-bottom: 6px;">
        <tr>
            <!-- Left Side Column Panel: Client Information -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Bill To</div>
                </div>
                <div class="profile-header">{{ $invoice->quotation->client->company_name }}</div>
                <div class="profile-text">
                    @if($invoice->quotation->client->contact_person)<strong>Attn:</strong> {{ $invoice->quotation->client->contact_person }}<br>@endif
                    @if($invoice->quotation->client->phone)<strong>Phone:</strong> {{ $invoice->quotation->client->phone }}<br>@endif
                    @if($invoice->quotation->client->email)<strong>Email:</strong> {{ $invoice->quotation->client->email }}<br>@endif
                    <strong>Address:</strong><br>
                    <span style="color: #64748B; font-size: 9px;">{!! nl2br(e($invoice->quotation->client->address ?: '-')) !!}</span>
                </div>
            </td>
            
            <td width="4%"></td> <!-- Layout Spacer -->
            
            <!-- Right Side Column Panel: Project Information -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Project Details</div>
                </div>
                <div class="profile-header" style="color: #9A7B56;">{{ $invoice->quotation->project_name }}</div>
                <div class="profile-text">
                    <strong>Quotation No:</strong> <span class="font-monospace fw-semibold text-dark">{{ $invoice->quotation->quotation_no }}</span><br>
                </div>
            </td>
        </tr>
    </table>

    <!-- INVOICE ITEMS SECTION -->
    <div class="section-divider" style="margin-top: 6px;">
        <div class="section-title text-uppercase">Invoice Items</div>
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
            @forelse($invoice->items as $item)
                {{-- MAIN INVOICE ITEM --}}
                <tr>
                    <td class="text-center font-monospace" style="color:#64748B;">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    <td style="color:#0F172A;">
                        <strong style="display:block; font-size:10px;">
                            {{ $item->title ?? $item->description }}
                        </strong>

                        {{-- PAYMENT PHASE SUBTEXT --}}
                        @if(($item->item_type ?? $item->type) === 'payment_phase')
                            @if($item->paymentTerm && $item->paymentTerm->description)
                                <div style="color:#64748B; font-size:8.5px; line-height:1.3; margin-top:1px;">
                                    {{ $item->paymentTerm->description }}
                                </div>
                            @elseif($item->percentage)
                                <div style="color:#64748B; font-size:8.5px; margin-top:1px;">
                                    Payment Phase &bull; {{ number_format($item->percentage, 2) }}%
                                </div>
                            @endif
                        @endif

                        {{-- CHANGE REQUEST SUBTEXT --}}
                        @if(($item->item_type ?? $item->type) === 'change_request')
                            <div style="color:#9A7B56; font-size:8.5px; margin-top:1px;">
                                Additional Change Request
                            </div>
                        @endif
                    </td>

                    <td class="text-right font-monospace" style="font-weight:700; color:#0F172A;">
                        RM {{ number_format($item->amount, 2) }}
                    </td>
                </tr>

                {{-- CHANGE REQUEST ITEM DESCRIPTIONS (NO INDIVIDUAL PRICES) --}}
                @if((($item->item_type ?? $item->type) === 'change_request') && $item->changeRequest && $item->changeRequest->items->count())
                    <tr>
                        <td></td>
                        <td colspan="2" style="padding: 3px 6px 6px 6px;">
                            <div class="cr-sub-container">
                                <table style="width:100%; margin:0; border-collapse:collapse;">
                                    @foreach($item->changeRequest->items as $changeItem)
                                        <tr class="cr-sub-item">
                                            <td width="5%" style="color:#64748B; font-size:8.5px; vertical-align:top;">
                                                &bull;
                                            </td>
                                            <td style="color:#334155; font-size:8.5px; vertical-align:top;">
                                                {{ $changeItem->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan="3" class="text-center" style="padding:15px; color:#94A3B8;">
                        No invoice items available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pricing Calculation Ledger & Bank Details Side-by-Side -->
    <table style="margin-top: 8px; page-break-inside: avoid;">
        <tr>
            <!-- Left Side Element: Bank Account Details -->
            <td width="55%" style="vertical-align: bottom;">
                <div class="instruction-box">
                    <strong style="color: #0F172A; text-transform: uppercase; display: block; margin-bottom: 2px; font-size: 7.5px; letter-spacing: 0.3px;">Payment Details</strong>
                    <div style="margin-bottom: 3px;">
                        @php
                            $projectInitials = collect(
                                preg_split('/\s+/', trim($invoice->quotation->project_name))
                            )
                            ->filter()
                            ->map(function ($word) {
                                return strtoupper(substr($word, 0, 1));
                            })
                            ->implode('');

                            $invoiceSequence = substr($invoice->invoice_no, -3);
                            $paymentReference = $projectInitials . '-' . $invoiceSequence;
                        @endphp

                        Kindly process billing to the account details stated below.<br>
                        Please use <strong>{{ $paymentReference }}</strong> as payment reference.
                    </div>
                    <strong>Bank Name:</strong> {{ $company->bank_name ?: '-' }}<br>
                    <strong>Account Holder:</strong> {{ $company->bank_holder ?: '-' }}<br>
                    <strong>Account Number:</strong> <span class="font-monospace" style="font-weight: bold; color: #0F172A; font-size: 9.5px;">{{ $company->bank_account ?: '-' }}</span>
                </div>
            </td>
            
            <td width="5%"></td> <!-- Spatial Gap -->
            
            <!-- Right Side Element: Subtotal / Discount / Tax / Total Ledger -->
            <td width="40%">
                <table class="ledger-box" style="width: 100%; margin: 0;">
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Subtotal</td>
                        <td class="text-right font-monospace" style="color: #334155;">RM {{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Discount Rebate</td>
                        <td class="text-right font-monospace text-danger">- RM {{ number_format($invoice->discount, 2) }}</td>
                    </tr>
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Service Tax (SST)</td>
                        <td class="text-right font-monospace" style="color: #334155;">RM {{ number_format($invoice->tax, 2) }}</td>
                    </tr>
                    <tr class="ledger-row-grand">
                        <td style="text-transform: uppercase; letter-spacing: 0.5px;">Total Due</td>
                        <td class="text-right font-monospace">RM {{ number_format($invoice->total, 2) }}</td>
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
                <div style="font-size: 9px; color: #64748B; margin-bottom: 2px; font-weight: 500;">Signature,</div>
                
                <div style="min-height: 35px; vertical-align: middle; margin-bottom: 2px;">
                    @if($company->signature)
                        <img src="{{ public_path('storage/'.$company->signature) }}" style="max-height: 32px; max-width: 110px; object-fit: contain; display: block;">
                    @else
                        <div style="height: 32px;"></div>
                    @endif
                </div>
                
                <div style="border-top: 1px solid #E2E8F0; padding-top: 3px; font-weight: 700; color: #0F172A; font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $company->company_name }}
                </div>
            </td>
            <!-- Right Spacer -->
            <td width="60%"></td>
        </tr>
    </table>

    <!-- Page Footer -->
    <div style="position: fixed; bottom: -5px; left: 0; right: 0; text-align: center; color: #94A3B8; font-size: 8px; font-family: sans-serif;">
        Thank You! We appreciate your business partnership and trust.
    </div>

</body>
</html>