<?php

namespace App\Exports;

use App\RestArea;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;


class RestAreasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $restArea = RestArea::orderBy('name', 'asc')->get();

        $collection = collect();
        foreach ($restArea as $key => $r) {
            $parking_slot = $r->parkingSlot;

            $ratio = $parking_slot->used_slots / $parking_slot->slots;

            if ($ratio <= 2 / 5) {
                $parking_status = "Kosong";
            } else if ($ratio > 2 / 5 && $ratio <= 4.5 / 5) {
                $parking_status = "Ramai";
            } else {
                $parking_status = "Penuh";
            }

            $collection->push([
                'id' => $key + 1,
                'name' => $r->name,
                'latitude' => $r->latitude,
                'longitude' => $r->longitude,
                'highway' => $r->highway->name,
                'pertalite' => ($r->fuel->pertalite == 1) ? 'Tersedia' : 'Habis',
                'pertamax' => ($r->fuel->pertamax == 1) ? 'Tersedia' : 'Habis',
                'pertamax_plus' => ($r->fuel->pertamax_plus == 1) ? 'Tersedia' : 'Habis',
                'dexlite' => ($r->fuel->dexlite == 1) ? 'Tersedia' : 'Habis',
                'parking_slot' => $r->parkingSlot->slots,
                'parking_status' => $parking_status,
                'last_update' => $r->parkingSlot->updated_at->locale('id')->isoFormat('LLLL'),
            ]);
        }

        return $collection;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nama',
            'Latitude',
            'Longitude',
            'Jalan Tol',
            'Pertalite',
            'Pertamax',
            'Pertamax Plus',
            'Dexlite',
            'Kapasitas Parkir',
            'Status Lahan Parkir',
            'Terakhir Diperbaharui',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:L1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
