<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Fiscal;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\FiscalRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\FiscalRepositoryInterface;

class FiscalController extends Controller
{
    protected $fiscalRepositoryInterface;

    public function __construct(FiscalRepositoryInterface $fiscalRepositoryInterface)
    {
        $this->fiscalRepositoryInterface = $fiscalRepositoryInterface;
        $this->authorizeResource(Fiscal::class, 'fiscal');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.fiscal.index', $this->fiscalRepositoryInterface->indexFiscal());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.fiscal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\FiscalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalRequest $request)
    {
        $this->fiscalRepositoryInterface->storeFiscal($request);
        return redirect(adminRedirectRoute('fiscal'))->withSuccess('Fiscal Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return \Illuminate\Http\Response
     */
    public function show(Fiscal $fiscal)
    {
        return view('account::admin.fiscal.show', $this->fiscalRepositoryInterface->showFiscal($fiscal));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return \Illuminate\Http\Response
     */
    public function edit(Fiscal $fiscal)
    {
        return view('account::admin.fiscal.edit', $this->fiscalRepositoryInterface->editFiscal($fiscal));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\FiscalRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return \Illuminate\Http\Response
     */
    public function update(FiscalRequest $request, Fiscal $fiscal)
    {
        $this->fiscalRepositoryInterface->updateFiscal($request, $fiscal);
        return redirect(adminRedirectRoute('fiscal'))->withInfo('Fiscal Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fiscal $fiscal)
    {
        $this->fiscalRepositoryInterface->destroyFiscal($fiscal);
        return redirect(adminRedirectRoute('fiscal'))->withFail('Fiscal Deleted Successfully.');
    }
}
