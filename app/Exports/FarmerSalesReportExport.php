<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FarmerSalesReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
{
    protected $salesItems;
    protected $startDate;
    protected $endDate;
    protected $totalSales;
    protected $totalOrders;
    protected $totalQuantity;

    public function __construct(
        Collection $salesItems,
        $startDate,
        $endDate,
        $totalSales,
        $totalOrders,
        $totalQuantity
    ) {
        $this->salesItems = $salesItems;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->totalSales = $totalSales;
        $this->totalOrders = $totalOrders;
        $this->totalQuantity = $totalQuantity;
    }

    public function collection(): Enumerable
    {
        return $this->salesItems;
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Customer Name',
            'Quantity Sold',
            'Price',
            'Subtotal',
            'Order Date',
        ];
    }

    public function map($item): array
    {
        return [
            $item->product->name ?? 'Product Unavailable',
            $item->order->user->name ?? 'Customer Unavailable',
            $item->quantity,
            $item->price,
            $item->price * $item->quantity,
            $item->order->created_at->format('Y-m-d'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $row = $event->sheet->getHighestRow() + 2;

                $event->sheet->setCellValue('A' . $row, 'SALES SUMMARY');

                $event->sheet->setCellValue('A' . ($row + 1), 'Report Period');
                $event->sheet->setCellValue(
                    'B' . ($row + 1),
                    $this->startDate . ' to ' . $this->endDate
                );

                $event->sheet->setCellValue('A' . ($row + 2), 'Total Sales');
                $event->sheet->setCellValue('B' . ($row + 2), $this->totalSales);

                $event->sheet->setCellValue('A' . ($row + 3), 'Total Completed Orders');
                $event->sheet->setCellValue('B' . ($row + 3), $this->totalOrders);

                $event->sheet->setCellValue('A' . ($row + 4), 'Total Products Sold');
                $event->sheet->setCellValue('B' . ($row + 4), $this->totalQuantity);

                $event->sheet->getStyle('A' . $row)->getFont()->setBold(true);
                $event->sheet->getStyle('A' . ($row + 2) . ':B' . ($row + 4))
                    ->getFont()->setBold(true);

                $event->sheet->getStyle('B' . ($row + 2))
                    ->getNumberFormat()
                    ->setFormatCode('"₱"#,##0.00');
            },
        ];
    }
}