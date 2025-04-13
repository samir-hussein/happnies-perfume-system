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
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles, WithEvents, WithCustomStartCell
{
    public $data;
    public static $from;
    public static $to;
    public static $count;

    public function __construct($data, $from, $to)
    {
        $this->data = $data;
        self::$from = $from;
        self::$to = $to;
        self::$count = count($data);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(3)->applyFromArray([
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
            "كود المنتج",
            "اسم المنتج",
            "القسم",
            "الكمية",
            "سعر البيع",
            "الخصم",
            "السعر بعد الخصم",
            "عدد مرات البيع",
            "الكمية المباعة",
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $products = [];
        foreach ($this->data as $product) {
            $products[] = [
                $product->code,
                $product->name,
                $product->category->name,
                $product->qty->sum('qty') . " " . $product->unit,
                $product->price . " جنية",
                ($product->discount ?? 0) . " " . ($product->discount_type == 'ratio' ? '%' : 'جنية'),
                $product->priceAfterDiscount() . " جنية",
                $product->times_sold,
                $product->qty_sold,
            ];
        }

        return collect($products);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // Set the worksheet direction to RTL
        $sheet->setRightToLeft(true);

        // Insert fixed data at the top before the header
        $sheet->setCellValue('A1', "فى المدة من");
        $sheet->setCellValue('B1', self::$from);
        $sheet->setCellValue('C1', "الى");
        $sheet->setCellValue('D1', self::$to);
        $sheet->setCellValue('A2', "اجمالى عدد المنتجات");
        $sheet->setCellValue('B2', self::$count);

        // Apply styles to the first row (header)
        $sheet->getStyle('A1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
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

        // Apply styles to the first row (header)
        $sheet->getStyle('C1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
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

        // Apply styles to the first row (header)
        $sheet->getStyle('A2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }

    public function startCell(): string
    {
        return 'A3';  // Start the actual data from row 3
    }
}
