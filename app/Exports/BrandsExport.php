<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BrandsExport implements WithColumnWidths,ShouldAutoSize, FromView, WithStyles, WithEvents
{
    public function columnWidths(): array
    {
        return [
            'C' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C'.$sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:c1')->getFont()->setBold(true);
        $sheet->getStyle('A1:c1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF969696');
        $sheet->getStyle('A1:Z100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);
    }


    public function view() : View
    {
        return view('exports.brands', [
            'brands' => Brand::query()
                ->orderBy('id','desc')->get()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter('A1:c1');
            }
        ];
    }
}
