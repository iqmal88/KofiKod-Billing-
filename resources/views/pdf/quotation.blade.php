<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quotation_{{ $quotation->quotation_no }}</title>
    <style>
        /* Minimalist Print Layout Structural Rules */
        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, 'DejaVu Sans', sans-serif;
        }
        body {
            font-size: 11px;
            color: #334155;
            line-height: 1.6;
            margin: 0;
            padding: 25px;
            background-color: #FFFFFF;
        }
        
        /* Typography System */
        h1, h2, h3, h4 {
            color: #0F172A;
            margin: 0;
            font-weight: 700;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-monospace { font-family: 'DejaVu Sans Mono', monospace; }
        .text-uppercase { text-transform: uppercase; }
        .tracking-wider { letter-spacing: 1px; }
        
        /* Layout Grid Helpers */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        td {
            vertical-align: top;
            padding: 0;
        }
        
        /* Top Branding Header */
        .header-boundary {
            border-bottom: 2px solid #0F172A;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .brand-title {
            font-size: 24px;
            color: #0F172A;
            letter-spacing: -0.5px;
        }
        .brand-accent {
            font-size: 11px;
            color: #9A7B56; /* Accent Bronze */
            font-weight: 500;
            margin-top: 1px;
            margin-bottom: 6px;
        }
        .brand-meta {
            font-size: 10px;
            color: #64748B;
            line-height: 1.4;
        }
        .doc-header-title {
            font-size: 26px;
            font-weight: 300;
            letter-spacing: 3px;
            color: #0F172A;
            line-height: 1;
            margin-bottom: 15px;
        }
        
        /* Refined Section Sub-Dividers */
        .line-divider {
            border-bottom: 1px solid #9A7B56; /* Thin bronze separator line */
            margin-top: 5px;
            margin-bottom: 12px;
            padding-bottom: 3px;
        }
        .line-title {
            font-size: 10px;
            font-weight: 700;
            color: #0F172A;
            letter-spacing: 1px;
        }
        
        /* Profile Details Info */
        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748B;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 11px;
            color: #0F172A;
            font-weight: 500;
            margin-bottom: 4px;
        }
        
        /* Elegant Clean Minimalist Itemization Table */
        .clean-table {
            width: 100%;
            margin-top: 5px;
        }
        .clean-table th {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748B;
            letter-spacing: 0.8px;
            padding: 8px 10px;
            border-bottom: 1px solid #0F172A; /* Crisp black row split */
        }
        .clean-table td {
            padding: 10px 10px;
            border-bottom: 1px solid #E2E8F0;
            color: #334155;
        }
        
        /* Bottom Calculation Ledger Alignments */
        .ledger-box {
            width: 300px;
            margin-left: auto;
            margin-top: 10px;
        }
        .ledger-row td {
            padding: 6px 10px;
            font-size: 11px;
            color: #475569;
        }
        .ledger-row-grand td {
            padding: 10px 10px;
            font-size: 13px;
            font-weight: 700;
            color: #0F172A;
            border-top: 1px solid #0F172A;
            border-bottom: 2px double #0F172A; /* Professional double underline accounting finish */
        }
        
        /* Rich Text Blocks Styles */
        .block-markup {
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
        }
    </style>
</head>
<body>

@php
    $company = \App\Models\CompanySetting::first();
@endphp

    <!-- Top Corporate Branding Block Header Frame -->
    <table class="header-boundary">
        <tr>
            <!-- Left Grid Pane: Identity info details -->
            <td width="65%">
                @if($company && $company->logo)
                    <img src="{{ public_path('storage/'.$company->logo) }}" style="max-height: 50px; max-width: 160px; object-fit: contain; margin-bottom: 8px; display: block;">
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
                <div class="doc-header-title text-uppercase">Quotation</div>
                <div class="profile-text" style="line-height: 1.4;">
                    <strong>Quotation No:</strong> <span class="font-monospace" style="color: #9A7B56; font-weight: bold;">{{ $quotation->quotation_no }}</span><br>
                    <strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}<br>
                    <strong>Validity:</strong> {{ $quotation->validity_days }} Days
                </div>
            </td>
        </tr>
    </table>

    <!-- Structural Layout Section Pane: Client vs Assignment Target metadata information -->
    <table style="margin-bottom: 10px;">
        <tr>
            <!-- Left Side Column Panel Frame: Client Information -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Client Details</div>
                </div>
                <div class="profile-header" style="font-size: 13px;">{{ $quotation->client->company_name }}</div>
                <div class="profile-text">
                    <strong>To:</strong> {{ $quotation->client->person_in_charge }}<br>
                    @if($quotation->client->phone)<strong>Phone:</strong> {{ $quotation->client->phone }}<br>@endif
                    @if($quotation->client->email)<strong>Email:</strong> {{ $quotation->client->email }}<br>@endif
                    <strong>Address:</strong><br>
                    <span style="color: #64748B; font-size: 10px;">{!! nl2br(e($quotation->client->address ?: '-')) !!}</span>
                </div>
            </td>
            
            <td width="4%"></td> <!-- Layout Spacer Block Column Padding -->
            
            <!-- Right Side Column Panel Frame: Project Information -->
            <td width="48%">
                <div class="section-divider">
                    <div class="section-title text-uppercase">Project Details</div>
                </div>
                <div class="profile-header" style="color: #9A7B56; font-size: 13px;">{{ $quotation->project_name }}</div>
                <div class="profile-text" style="margin-bottom: 8px;">
                    <strong>Timeline:</strong> <br>
                    {{ $quotation->project_start ? \Carbon\Carbon::parse($quotation->project_start)->format('d M Y') : '—' }} 
                    to 
                    {{ $quotation->project_end ? \Carbon\Carbon::parse($quotation->project_end)->format('d M Y') : '—' }}
                </div>
                @if($quotation->project_description)
                    <div class="block-markup" style="border-top: 1px dashed #E2E8F0; padding-top: 6px; font-size: 10px;">
                        <strong>Project Description:</strong> <br>
                        {!! strip_tags($quotation->project_description, '<b><strong><i><u><br><p>') !!}
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Main Table Module Component Section: Scope items list worksheet lines -->
    <div class="section-divider" style="font-size: 11px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; margin-bottom: 10px; page-break-inside: avoid;">
        <div class="section-title text-uppercase">Scope of Work</div>
    </div>
    <table class="clean-table">
        <thead>
            <tr>
                <th class="text-center" width="6%">#</th>
                <th class="text-left">Item</th>
                <th class="text-center" width="8%">Qty</th>
                <th class="text-right" width="18%">Unit Price</th>
                <th class="text-right" width="20%">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
                <tr>
                    <td class="text-center" style="color: #94A3B8; font-weight: bold; font-size: 10px;">{{ sprintf('%02d', $loop->iteration) }}</td>
                    <td style="font-weight: 600; color: #0F172A; font-size: 11px;">{{ $item->item_name }}</td>
                    <td class="text-center font-monospace" style="color: #475569;">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right font-monospace" style="color: #475569;">RM {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right font-monospace" style="font-weight: 700; color: #0F172A;">RM {{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Sequential Section Frame block: Installment Milestone payment tracking schedule distribution list -->
    @if($quotation->paymentTerms && $quotation->paymentTerms->count())
        <table class="clean-table" style="margin-top: 25px; margin-bottom: 15px; page-break-inside: avoid;">
            <thead>
                <!-- Section Accent Header Row Embedded Directly Inside Table -->
                <tr>
                    <th colspan="2" style="background-color: #FFFFFF; padding: 0 0 4px 0; text-align: left; border-bottom: 1px solid #0F172A;">
                        <span style="font-size: 11px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 1px;">Payment Schedule</span>
                    </th>
                </tr>
                <!-- Sub-column Titles -->
                <tr>
                    <th class="text-left" style="border-bottom: 1px solid #8C6D53; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #64748B; letter-spacing: 0.8px; padding: 8px 10px;">Phase</th>
                    <th class="text-right" style="border-bottom: 1px solid #8C6D53; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #64748B; letter-spacing: 0.8px; padding: 8px 10px;" width="20%">Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->paymentTerms as $term)
                    <tr>
                        <td style="padding: 10px 10px; border-bottom: 1px solid #E2E8F0;">
                            <strong style="color: #0F172A;">{{ $term->title }}</strong>
                            @if($term->description)<br><span style="font-size: 9px; color: #64748B;">{{ $term->description }}</span>@endif
                        </td>
                        <td class="text-right font-monospace" style="font-weight: 700; color: #9A7B56; font-size: 11px; padding: 10px 10px; border-bottom: 1px solid #E2E8F0;">
                            {{ number_format($term->percentage, 0) }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Dynamic Sequential Section block: Pricing Calculation ledger summary metrics aligned strictly on the right edge layout -->
    <table style="margin-top: 15px; page-break-inside: avoid;">
        <tr>
            <!-- Left Side Element: Bank Account pathways detail data box wrapper information frame alignment -->
            <td width="55%" style="vertical-align: bottom;">
                <div style="background-color: #F8FAFC; border-left: 2px solid #0F172A; padding: 10px 12px; font-size: 10px; color: #475569; border-top: 1px solid #E2E8F0; border-right: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0; border-radius: 0 4px 4px 0;">
                    <strong style="color: #0F172A; text-transform: uppercase; display: block; margin-bottom: 3px; font-size: 8.5px; letter-spacing: 0.3px;">Bank Details</strong>
                    <strong>Bank Name:</strong> {{ $company->bank_name ?: '-' }}<br>
                    <strong>Account Holder:</strong> {{ $company->bank_holder ?: '-' }}<br>
                    <strong>Account Number:</strong> <span class="font-monospace" style="font-weight: bold; color: #0F172A;">{{ $company->bank_account ?: '-' }}</span>
                </div>
            </td>
            
            <td width="5%"></td> <!-- Layout spatial separator element -->
            
            <!-- Right Side Element: The right edge aligned calculation ledger data values metrics block -->
            <td width="40%">
                <table class="ledger-box" style="width: 100%; margin: 0;">
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Subtotal</td>
                        <td class="text-right font-monospace" style="color: #334155;">RM {{ number_format($quotation->subtotal, 2) }}</td>
                    </tr>
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Discount</td>
                        <td class="text-right font-monospace text-danger">- RM {{ number_format($quotation->discount, 2) }}</td>
                    </tr>
                    <tr class="ledger-row">
                        <td style="color: #64748B; font-weight: 500;">Service Tax (SST)</td>
                        <td class="text-right font-monospace" style="color: #334155;">RM {{ number_format($quotation->tax, 2) }}</td>
                    </tr>
                    <tr class="ledger-row-grand">
                        <td style="text-transform: uppercase; letter-spacing: 0.5px;">Grand Total</td>
                        <td class="text-right font-monospace">RM {{ number_format($quotation->total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Legal Baseline conditions clauses parameters footnote block section wrapper panel grid frame -->
    @if($company->terms_conditions)
        <div class="section-divider" style="margin-top: 25px; page-break-inside: avoid;">
            <div class="section-title text-uppercase">Terms & Conditions</div>
        </div>
        <div class="block-markup" style="font-size: 9px; color: #64748B; text-align: justify; padding: 0 4px; line-height: 1.5; page-break-inside: avoid;">
            {!! strip_tags($company->terms_conditions, '<b><strong><i><u><br><p><ol><ul><li>') !!}
        </div>
    @endif

    <!-- Authorized validation sign-off verification signature sectional footers panel alignment row -->
    <table style="margin-top: 40px; page-break-inside: avoid;">
        <tr>
            <td width="60%"></td>
            <td width="40%" class="text-center" style="vertical-align: bottom;">
                <div style="font-size: 10px; color: #64748B; margin-bottom: 4px; font-weight: 500;">Signature</div>
                
                <div style="min-height: 55px; vertical-align: middle; margin-bottom: 4px;">
                    @if($company->signature)
                        <img src="{{ public_path('storage/'.$company->signature) }}" style="max-height: 40px; max-width: 130px; object-fit: contain;">
                    @else
                        <div style="height: 40px;"></div>
                    @endif
                </div>
                
                <div style="border-top: 1px solid #E2E8F0; padding-top: 5px; font-weight: 700; color: #0F172A; font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $company->company_name }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>