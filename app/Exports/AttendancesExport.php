<?php

namespace App\Exports;

use App\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendancesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::all();
    }

    public function headings(): array
    {
        return [
            'Department',
            'Name',
            'No.',
            'Date/Time',
            'Status',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->department,
            'Mr. ' . $attendance->name,
            $attendance->no,
            $attendance->date_time,
            $attendance->status,
        ];
    }


}
