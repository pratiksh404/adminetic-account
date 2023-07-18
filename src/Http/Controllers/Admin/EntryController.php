<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Entry;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\EntryRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\EntryRepositoryInterface;

class EntryController extends Controller
{
    protected $entryRepositoryInterface;

    public function __construct(EntryRepositoryInterface $entryRepositoryInterface)
    {
        $this->entryRepositoryInterface = $entryRepositoryInterface;
        $this->authorizeResource(Entry::class, 'entry');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.entry.index', $this->entryRepositoryInterface->indexEntry());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.entry.create', $this->entryRepositoryInterface->createEntry());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\EntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryRequest $request)
    {
        $this->entryRepositoryInterface->storeEntry($request);
        return redirect(adminRedirectRoute('entry'))->withSuccess('Entry Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        return view('account::admin.entry.show', $this->entryRepositoryInterface->showEntry($entry));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        return view('account::admin.entry.edit', $this->entryRepositoryInterface->editEntry($entry));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\EntryRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, Entry $entry)
    {
        $this->entryRepositoryInterface->updateEntry($request, $entry);
        return redirect(adminRedirectRoute('entry'))->withInfo('Entry Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $this->entryRepositoryInterface->destroyEntry($entry);
        return redirect(adminRedirectRoute('entry'))->withFail('Entry Deleted Successfully.');
    }
}
