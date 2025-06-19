<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
// WithAutoSize sudah dihapus dari sini
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BarangsExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::orderBy('id', 'asc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Nama Orang',
            'Kuantitas',
            'Harga Per Satuan',
            'Harga Total',
            'Tanggal',
            'Keterangan',
        ];
    }
    
    /**
     * @param mixed $barang
     * @return array
     */
    public function map($barang): array
    {
        $hargaTotal = $barang->kuantitas * $barang->harga_per_satuan;
        return [
            $barang->id,
            $barang->nama_barang,
            $barang->nama_orang,
            $barang->kuantitas,
            $barang->harga_per_satuan,
            $hargaTotal,
            $barang->tanggal ? $barang->tanggal->format('Y-m-d') : '-',
            $barang->keterangan,
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',
            'E' => '"Rp "#,##0',
            'F' => '"Rp "#,##0',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();
            
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(40);

            $totalKuantitas = Barang::sum('kuantitas');
            $grandTotalHarga = Barang::sum(DB::raw('kuantitas * harga_per_satuan'));
            
            $summaryRow = $sheet->getHighestRow() + 2;

            $sheet->mergeCells("B{$summaryRow}:C{$summaryRow}");
            $sheet->setCellValue("B{$summaryRow}", 'TOTAL KUANTITAS');
            $sheet->setCellValue("D{$summaryRow}", $totalKuantitas);
            $sheet->getStyle("B{$summaryRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $nextSummaryRow = $summaryRow + 1;
            $sheet->mergeCells("B{$nextSummaryRow}:E{$nextSummaryRow}");
            $sheet->setCellValue("B{$nextSummaryRow}", 'TOTAL HARGA');
            $sheet->setCellValue("F{$nextSummaryRow}", $grandTotalHarga); 
            $sheet->getStyle("B{$nextSummaryRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            $styleArray = ['font' => ['bold' => true]];
            $sheet->getStyle("B{$summaryRow}:F{$nextSummaryRow}")->applyFromArray($styleArray);

            $sheet->getStyle("F{$nextSummaryRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');

            $sheet->getStyle("D{$summaryRow}")->getNumberFormat()->setFormatCode('#,##0');
        },
    ];
}
}