<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Ledger;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\LedgerRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\LedgerRepositoryInterface;

class LedgerController extends Controller
{
    protected $ledgerRepositoryInterface;

    public function __construct(LedgerRepositoryInterface $ledgerRepositoryInterface)
    {
        $this->ledgerRepositoryInterface = $ledgerRepositoryInterface;
        $this->authorizeResource(Ledger::class, 'ledger');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.ledger.index', $this->ledgerRepositoryInterface->indexLedger());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.ledger.create', $this->ledgerRepositoryInterface->createLedger());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\LedgerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LedgerRequest $request)
    {
        $this->ledgerRepositoryInterface->storeLedger($request);
        return redirect(adminRedirectRoute('ledger'))->withSuccess('Ledger Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        return view('account::admin.ledger.show', $this->ledgerRepositoryInterface->showLedger($ledger));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        return view('account::admin.ledger.edit', $this->ledgerRepositoryInterface->editLedger($ledger));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\LedgerRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(LedgerRequest $request, Ledger $ledger)
    {
        $this->ledgerRepositoryInterface->updateLedger($request, $ledger);
        return redirect(adminRedirectRoute('ledger'))->withInfo('Ledger Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $ledger)
    {
        $this->ledgerRepositoryInterface->destroyLedger($ledger);
        return redirect(adminRedirectRoute('ledger'))->withFail('Ledger Deleted Successfully.');
    }
}
