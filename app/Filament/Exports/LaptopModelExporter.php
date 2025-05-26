<?php

namespace App\Filament\Exports;

use App\Models\LaptopModel;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LaptopModelExporter extends Exporter
{
    protected static ?string $model = LaptopModel::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('jenis'),
            ExportColumn::make('nama_aset'),
            ExportColumn::make('kode_aset'),
            ExportColumn::make('merek'),
            ExportColumn::make('processor'),
            ExportColumn::make('ram'),
            ExportColumn::make('storage'),
            ExportColumn::make('kondisi'),
            ExportColumn::make('user'),
            ExportColumn::make('cabang.nama_cabang')->label('Cabang'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your laptop model export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public static function getDefaultFileName(): ?string
    {
        return 'laptop_export_' . now()->format('Ymd_His');
    }

}
