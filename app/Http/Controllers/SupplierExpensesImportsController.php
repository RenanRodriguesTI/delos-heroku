<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;
use Delos\Dgp\Entities\SupplierExpensesImports;

class SupplierExpensesImportsController extends AbstractController
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = ($this->request->input('status')) ? $this->request->input('status') : '0';
        $last = SupplierExpensesImports::orderBy('created_at', 'desc')->first();
        $date = null;
        if ($last) {
            $date = $last->created_at->format('d/m/Y H:i');
        }

        switch ($filter) {
            case '1':
                $proposalvalues = SupplierExpensesImports::where('status', 'success')->paginate(15);
                break;
            case '2':
                $proposalvalues = SupplierExpensesImports::where('status', 'error')->paginate(15);
                break;
            default:
                $proposalvalues = SupplierExpensesImports::paginate(15);
                break;
        }

        return view('supplier-expenses-imports.index', compact('proposalvalues', 'filter', 'date'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $this->service->validateFile($this->request->all());
            if ($this->request->has('files') && $this->request->file('files')->isValid()) {
                Storage::disk('local')->put('fileSupplierExpensesImports.xlsx', file_get_contents($this->request->file('files')));
                $this->service->import();
            }

            return redirect()->route('supplierExpensesImport.index');
        } catch (ValidatorException $e) {
            $fileerrors = collect($e->getMessageBag()->messages());
            return view('supplier-expenses-imports.error', compact('fileerrors'));
        }
    }
}
