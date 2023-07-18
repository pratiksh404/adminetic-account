<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Transfer;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\TransferRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\TransferRepositoryInterface;

class TransferController extends Controller
{
    protected $transferRepositoryInterface;

    public function __construct(TransferRepositoryInterface $transferRepositoryInterface)
    {
        $this->transferRepositoryInterface = $transferRepositoryInterface;
        $this->authorizeResource(Transfer::class, 'transfer');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.transfer.index', $this->transferRepositoryInterface->indexTransfer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.transfer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\TransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferRequest $request)
    {
        $this->transferRepositoryInterface->storeTransfer($request);
        return redirect(adminRedirectRoute('transfer'))->withSuccess('Transfer Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        return view('account::admin.transfer.show', $this->transferRepositoryInterface->showTransfer($transfer));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        return view('account::admin.transfer.edit', $this->transferRepositoryInterface->editTransfer($transfer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\TransferRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(TransferRequest $request, Transfer $transfer)
    {
        $this->transferRepositoryInterface->updateTransfer($request, $transfer);
        return redirect(adminRedirectRoute('transfer'))->withInfo('Transfer Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        $this->transferRepositoryInterface->destroyTransfer($transfer);
        return redirect(adminRedirectRoute('transfer'))->withFail('Transfer Deleted Successfully.');
    }
}
