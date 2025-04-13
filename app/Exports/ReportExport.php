<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles, WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_DARKGREEN],
            ],
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
        ]);
    }

    public function defaultStyles(Style $defaultStyle)
    {
        // Or return the styles array
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            "الشهر",
            "ايرادات",
            "خامات",
            "نثريات",
            "شراء بضاعة",
            "اجمالى الارباح",
            "ارباح تم صرفها",
            "الخزنة",
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [];
        foreach ($this->data as $item) {
            $data[] = [
                $item['month'],
                isset($item['total_price']) ? number_format($item['total_price'], 2) . " جنية" : "",
                isset($item['total_unit_price']) ? number_format($item['total_unit_price'], 2) . " جنية" : "",
                isset($item['expenses']) ? number_format($item['expenses'], 2) . " جنية" : "",
                isset($item['products_expenses']) ? number_format($item['products_expenses'], 2) . " جنية" : "",
                isset($item['profits']) ? number_format($item['profits'], 2) . " جنية" : "",
                isset($item['paid_profits']) ? number_format($item['paid_profits'], 2) . " جنية" : "",
                isset($item['safe']) ? number_format($item['safe'], 2) . " جنية" : "",
            ];
        }

        return collect($data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // Set the worksheet direction to RTL
        $sheet->setRightToLeft(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
