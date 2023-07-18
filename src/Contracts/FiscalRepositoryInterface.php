<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Fiscal;
use Adminetic\Account\Http\Requests\FiscalRequest;

interface FiscalRepositoryInterface
{
    public function indexFiscal();

    public function createFiscal();

    public function storeFiscal(FiscalRequest $request);

    public function showFiscal(Fiscal $Fiscal);

    public function editFiscal(Fiscal $Fiscal);

    public function updateFiscal(FiscalRequest $request, Fiscal $Fiscal);

    public function destroyFiscal(Fiscal $Fiscal);
}
