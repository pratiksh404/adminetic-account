<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Transfer;
use Adminetic\Account\Http\Requests\TransferRequest;

interface TransferRepositoryInterface
{
    public function indexTransfer();

    public function createTransfer();

    public function storeTransfer(TransferRequest $request);

    public function showTransfer(Transfer $Transfer);

    public function editTransfer(Transfer $Transfer);

    public function updateTransfer(TransferRequest $request, Transfer $Transfer);

    public function destroyTransfer(Transfer $Transfer);
}
