<?php

namespace App\Exports;

use App\Models\BagAdaInput;
use App\Models\Satker;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BagAdaInputExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = BagAdaInput::with(['satker', 'pelakuPengadaan', 'metodePengadaan'])->latest();
        $user = Auth::user();

        if ($user->isAdminSatker()) {
            $query->where('satker_id', $user->satker_id);
        } else if ($this->request->filled('satker_id')) {
            $query->where('satker_id', $this->request->satker_id);
        }

        if ($this->request->filled('pelaku_pengadaan_id')) {
            $query->where('pelaku_pengadaan_id', $this->request->pelaku_pengadaan_id);
        }

        $tahun = $this->request->input('tahun', date('Y'));
        $query->whereYear('created_at', $tahun);

        $inputs = $query->get()->groupBy('satker_id');
        $satkers = Satker::whereIn('id', $inputs->keys())->get()->keyBy('id');

        return view('admin.exports.bag_ada_inputs', [
            'groupedInputs' => $inputs,
            'satkers' => $satkers,
            'year' => date('Y')
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = 'Q';

        // Styling Header Title
        $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Styling Table Headers (Rows 7, 8, 9)
        $sheet->getStyle('A7:Q9')->getFont()->setBold(true);
        $sheet->getStyle('A7:Q9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:Q9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A7:Q9')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A7:Q9')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Data Borders
        if ($lastRow >= 11) {
            $sheet->getStyle("A11:{$lastColumn}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A11:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A11:A{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $sheet->getStyle("B11:B{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            
            // Format Number for Pagu and Kontrak (Column J, K)
            $sheet->getStyle("J11:K{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
        }

        return [];
    }
}
