<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Fiscal;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\FiscalRepositoryInterface;
use Adminetic\Account\Http\Requests\FiscalRequest;

class FiscalRepository implements FiscalRepositoryInterface
{
    // Fiscal Index
    public function indexFiscal()
    {
        $fiscals = config('adminetic.caching', true)
            ? (Cache::has('fiscals') ? Cache::get('fiscals') : Cache::rememberForever('fiscals', function () {
                return Fiscal::latest()->get();
            }))
            : Fiscal::latest()->get();
        return compact('fiscals');
    }

    // Fiscal Create
    public function createFiscal()
    {
        //
    }

    // Fiscal Store
    public function storeFiscal(FiscalRequest $request)
    {
        Fiscal::create($request->validated());
    }

    // Fiscal Show
    public function showFiscal(Fiscal $fiscal)
    {
        return compact('fiscal');
    }

    // Fiscal Edit
    public function editFiscal(Fiscal $fiscal)
    {
        return compact('fiscal');
    }

    // Fiscal Update
    public function updateFiscal(FiscalRequest $request, Fiscal $fiscal)
    {
        $fiscal->update($request->validated());
    }

    // Fiscal Destroy
    public function destroyFiscal(Fiscal $fiscal)
    {
        $fiscal->delete();
    }
}
