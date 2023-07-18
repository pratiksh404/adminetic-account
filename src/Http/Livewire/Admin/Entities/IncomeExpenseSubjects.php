<?php

namespace Adminetic\Account\Http\Livewire\Admin\Entities;

use Livewire\Component;
use Pratiksh\Adminetic\Models\Admin\Data;

class IncomeExpenseSubjects extends Component
{
    public $type;

    public $data = [];
    public $income_subjects;
    public $expense_subjects;

    public function mount()
    {
        $this->income_subjects = Data::firstOrCreate([
            'name' => 'income_subjects'
        ], [
            'content' => []
        ]);
        $this->expense_subjects = Data::firstOrCreate([
            'name' => 'expense_subjects'
        ], [
            'content' => []
        ]);
        $this->type = income_flag();
        $this->updatedType();
    }

    public function updatedType()
    {
        if ($this->type == income_flag()) {
            $this->data = $this->income_subjects->content;
        } elseif ($this->type == expense_flag()) {
            $this->data = $this->expense_subjects->content;
        }
    }

    public function add()
    {
        $this->data[] = [
            'name' => '',
            'color' => '#000000',
            'icon' => 'fa fa-money-bill',
        ];
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:' . income_flag() . ',' . expense_flag(),
            'data.*.name' => 'required|max:100',
            'data.*.color' => 'nullable',
            'data.*.icon' => 'nullable'
        ]);
        $this->save_subject();
    }

    public function remove($index)
    {
        $data = $this->data;
        unset($data[$index]);
        $this->data = $data;
        $this->save_subject();
    }


    public function render()
    {
        return view('account::livewire.admin.entities.income-expense-subjects');
    }

    private function save_subject()
    {
        if ($this->type == income_flag()) {
            $this->income_subjects->update([
                'content' => $this->data
            ]);
            $this->data = $this->income_subjects->content;
            $this->emit('income_expense_subjects_success', 'Income Subject Saved Sucessfully');
        } elseif ($this->type == expense_flag()) {
            $this->expense_subjects->update([
                'content' => $this->data
            ]);
            $this->data = $this->expense_subjects->content;
            $this->emit('income_expense_subjects_success', 'Expense Subject Saved Sucessfully');
        }
    }
}
