<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequest;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Change Request List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $changeRequests = ChangeRequest::with([
                'quotation.client',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'change-requests.index',
            compact('changeRequests')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Change Request
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Available Quotations
        |--------------------------------------------------------------------------
        */

        $quotations = Quotation::with('client')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Pre-selected Quotation
        |--------------------------------------------------------------------------
        |
        | This allows:
        |
        | /change-requests/create?quotation=1
        |
        | So when the user clicks "Create Change Request"
        | from quotation details, that quotation is automatically selected.
        |
        */

        $selectedQuotation = null;

        if ($request->filled('quotation')) {

            $selectedQuotation = Quotation::with('client')
                ->find($request->quotation);

        }


        return view(
            'change-requests.create',
            compact(
                'quotations',
                'selectedQuotation'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Change Request
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'quotation_id' => [
                'required',
                'exists:quotations,id',
            ],

            'request_date' => [
                'required',
                'date',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Draft,Pending Approval',
            ],

            /*
            |--------------------------------------------------------------------------
            | Change Request Items
            |--------------------------------------------------------------------------
            */

            'item_description' => [
                'required',
                'array',
                'min:1',
            ],

            'item_description.*' => [
                'required',
                'string',
            ],

            'item_amount' => [
                'required',
                'array',
                'min:1',
            ],

            'item_amount.*' => [
                'required',
                'numeric',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Make Sure Description & Amount Count Match
        |--------------------------------------------------------------------------
        */

        if (
            count($validated['item_description'])
            !==
            count($validated['item_amount'])
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'items' =>
                        'Change request items are invalid. Please check the descriptions and amounts.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        |
        | Never trust a total sent from JavaScript.
        | Calculate it again on the server.
        |
        */

        $total = collect(
            $validated['item_amount']
        )->sum();


        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */

        $changeRequest = DB::transaction(
            function () use (
                $validated,
                $total
            ) {

                /*
                |--------------------------------------------------------------------------
                | Generate CR Number
                |--------------------------------------------------------------------------
                */

                $latestChangeRequest = ChangeRequest::latest('id')
                    ->lockForUpdate()
                    ->first();


                if ($latestChangeRequest) {

                    $lastNumber = (int) substr(
                        $latestChangeRequest->change_request_no,
                        -3
                    );

                    $nextNumber = $lastNumber + 1;

                } else {

                    $nextNumber = 1;

                }


                $changeRequestNo =
                    'CR-'
                    .
                    str_pad(
                        $nextNumber,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Change Request
                |--------------------------------------------------------------------------
                */

                $changeRequest = ChangeRequest::create([

                    'quotation_id' =>
                        $validated['quotation_id'],

                    'change_request_no' =>
                        $changeRequestNo,

                    'request_date' =>
                        $validated['request_date'],

                    'title' =>
                        $validated['title'],

                    'description' =>
                        $validated['description'] ?? null,

                    'total' =>
                        $total,

                    'status' =>
                        $validated['status'],

                    'approved_date' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Create Change Request Items
                |--------------------------------------------------------------------------
                */

                foreach (
                    $validated['item_description']
                    as $index => $description
                ) {

                    $changeRequest->items()->create([

                        'description' =>
                            $description,

                        'amount' =>
                            $validated['item_amount'][$index],

                    ]);

                }


                return $changeRequest;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'change-requests.show',
                $changeRequest
            )
            ->with(
                'success',
                'Change request created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Change Request
    |--------------------------------------------------------------------------
    */

    public function show(ChangeRequest $changeRequest)
    {
        $changeRequest->load([

            'quotation.client',

            'items',

            'invoiceItems.invoice',

        ]);


        return view(
            'change-requests.show',
            compact('changeRequest')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Change Request
    |--------------------------------------------------------------------------
    */

    public function edit(ChangeRequest $changeRequest)
    {
        /*
        |--------------------------------------------------------------------------
        | Approved CR Should Not Be Edited
        |--------------------------------------------------------------------------
        */

        if ($changeRequest->status === 'Approved') {

            return redirect()
                ->route(
                    'change-requests.show',
                    $changeRequest
                )
                ->with(
                    'error',
                    'An approved change request cannot be edited.'
                );
        }


        $changeRequest->load([
            'quotation.client',
            'items',
        ]);


        $quotations = Quotation::with('client')
            ->latest()
            ->get();


        return view(
            'change-requests.edit',
            compact(
                'changeRequest',
                'quotations'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Change Request
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        ChangeRequest $changeRequest
    ) {

        /*
        |--------------------------------------------------------------------------
        | Approved CR Should Not Be Updated
        |--------------------------------------------------------------------------
        */

        if ($changeRequest->status === 'Approved') {

            return redirect()
                ->route(
                    'change-requests.show',
                    $changeRequest
                )
                ->with(
                    'error',
                    'An approved change request cannot be modified.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'quotation_id' => [
                'required',
                'exists:quotations,id',
            ],

            'request_date' => [
                'required',
                'date',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Draft,Pending Approval',
            ],

            'item_description' => [
                'required',
                'array',
                'min:1',
            ],

            'item_description.*' => [
                'required',
                'string',
            ],

            'item_amount' => [
                'required',
                'array',
                'min:1',
            ],

            'item_amount.*' => [
                'required',
                'numeric',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Check Item Count
        |--------------------------------------------------------------------------
        */

        if (
            count($validated['item_description'])
            !==
            count($validated['item_amount'])
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'items' =>
                        'Change request items are invalid.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $total = collect(
            $validated['item_amount']
        )->sum();


        /*
        |--------------------------------------------------------------------------
        | Update Transaction
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $changeRequest,
                $validated,
                $total
            ) {

                /*
                |--------------------------------------------------------------------------
                | Update Main CR
                |--------------------------------------------------------------------------
                */

                $changeRequest->update([

                    'quotation_id' =>
                        $validated['quotation_id'],

                    'request_date' =>
                        $validated['request_date'],

                    'title' =>
                        $validated['title'],

                    'description' =>
                        $validated['description'] ?? null,

                    'total' =>
                        $total,

                    'status' =>
                        $validated['status'],

                ]);


                /*
                |--------------------------------------------------------------------------
                | Replace Existing Items
                |--------------------------------------------------------------------------
                |
                | Because CRs normally have only a small number of items,
                | deleting and recreating them is simpler and reliable.
                |
                */

                $changeRequest->items()->delete();


                foreach (
                    $validated['item_description']
                    as $index => $description
                ) {

                    $changeRequest->items()->create([

                        'description' =>
                            $description,

                        'amount' =>
                            $validated['item_amount'][$index],

                    ]);

                }

            }
        );


        return redirect()
            ->route(
                'change-requests.show',
                $changeRequest
            )
            ->with(
                'success',
                'Change request updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Change Request
    |--------------------------------------------------------------------------
    */

    public function approve(ChangeRequest $changeRequest)
    {
        /*
        |--------------------------------------------------------------------------
        | Already Approved
        |--------------------------------------------------------------------------
        */

        if ($changeRequest->status === 'Approved') {

            return redirect()
                ->route(
                    'change-requests.show',
                    $changeRequest
                )
                ->with(
                    'info',
                    'This change request has already been approved.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Only Pending Approval Can Be Approved
        |--------------------------------------------------------------------------
        */

        if ($changeRequest->status !== 'Pending Approval') {

            return redirect()
                ->route(
                    'change-requests.show',
                    $changeRequest
                )
                ->with(
                    'error',
                    'Only a change request with Pending Approval status can be approved.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Approve
        |--------------------------------------------------------------------------
        */

        $changeRequest->update([

            'status' =>
                'Approved',

            'approved_date' =>
                now()->toDateString(),

        ]);


        return redirect()
            ->route(
                'change-requests.show',
                $changeRequest
            )
            ->with(
                'success',
                'Change request approved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Change Request
    |--------------------------------------------------------------------------
    */

    public function destroy(ChangeRequest $changeRequest)
    {
        /*
        |--------------------------------------------------------------------------
        | Approved CR Cannot Be Deleted
        |--------------------------------------------------------------------------
        */

        if ($changeRequest->status === 'Approved') {

            return redirect()
                ->route(
                    'change-requests.show',
                    $changeRequest
                )
                ->with(
                    'error',
                    'An approved change request cannot be deleted.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $changeRequest->delete();


        return redirect()
            ->route('change-requests.index')
            ->with(
                'success',
                'Change request deleted successfully.'
            );
    }
}