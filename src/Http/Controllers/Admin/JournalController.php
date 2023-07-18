<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Journal;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\JournalRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\JournalRepositoryInterface;

class JournalController extends Controller
{
    protected $journalRepositoryInterface;

    public function __construct(JournalRepositoryInterface $journalRepositoryInterface)
    {
        $this->journalRepositoryInterface = $journalRepositoryInterface;
        $this->authorizeResource(Journal::class, 'journal');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.journal.index', $this->journalRepositoryInterface->indexJournal());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.journal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\JournalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JournalRequest $request)
    {
        $this->journalRepositoryInterface->storeJournal($request);
        return redirect(adminRedirectRoute('journal'))->withSuccess('Journal Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        return view('account::admin.journal.show', $this->journalRepositoryInterface->showJournal($journal));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        return view('account::admin.journal.edit', $this->journalRepositoryInterface->editJournal($journal));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\JournalRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(JournalRequest $request, Journal $journal)
    {
        $this->journalRepositoryInterface->updateJournal($request, $journal);
        return redirect(adminRedirectRoute('journal'))->withInfo('Journal Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        $this->journalRepositoryInterface->destroyJournal($journal);
        return redirect(adminRedirectRoute('journal'))->withFail('Journal Deleted Successfully.');
    }
}
