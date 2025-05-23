<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaptopResource\Pages;
use App\Filament\Resources\LaptopResource\RelationManagers;
use App\Models\CabangModel;
use App\Models\Laptop;
use App\Models\LaptopModel;
// use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\Action;

use App\Models\PerpindahanAsetModel;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;

class LaptopResource extends Resource
{
    protected static ?string $model = LaptopModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $slug = 'desktop';

    protected static ?string $navigationLabel = 'PC & Laptop';

    protected static ?string $navigationGroup = 'Data Asset';

    protected static ?string $label = 'Data PC & Laptop';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('jenis')->required(),
            TextInput::make('nama_aset')->required(),
            TextInput::make('kode_aset'),
            Select::make('kategori_id')
                ->relationship('kategori', 'nama_kategori')
                ->required(),
            Select::make('cabang_id')
                ->relationship('cabang', 'nama_cabang')
                ->required(),
            TextInput::make('merek'),
            TextInput::make('processor'),
            TextInput::make('ram'),
            TextInput::make('storage'),
            Select::make('kondisi')
                ->options([
                    'Aktif' => 'Aktif',
                    'Rusak' => 'Rusak',
                    'Cadangan' => 'Cadangan',
                ]),
            TextInput::make('user'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('jenis')->searchable(),
            TextColumn::make('nama_aset')->searchable()->wrap(),
            // TextColumn::make('kode_aset')->searchable()->label('No. Asset'),
            TextColumn::make('processor')->searchable(),
            TextColumn::make('ram')->searchable(),
            TextColumn::make('storage')->searchable(),
            TextColumn::make('cabang.nama_cabang')->searchable(),
            TextColumn::make('user')
                ->searchable()
                ->formatStateUsing(fn($state) => !empty(trim($state)) ? $state : '-'),
            SelectColumn::make('kondisi')
                ->options([
                    'Aktif' => 'Aktif',
                    'Rusak' => 'Rusak',
                    'Cadangan' => 'Cadangan',
                ])
        ])

            ->filters([
                TrashedFilter::make(), // Untuk soft deletes
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),

                    Action::make('send')
                        ->label('Send')
                        ->icon('heroicon-m-paper-airplane')
                        ->form([
                            Select::make('cabang_tujuan_id')
                                ->label('Cabang Tujuan')
                                ->options(\App\Models\CabangModel::pluck('nama_cabang', 'id'))
                                ->searchable()
                                ->required(),

                            TextInput::make('user_baru')
                                ->label('User Baru')
                                ->required(),

                            Textarea::make('keterangan')
                                ->label('Keterangan')
                                ->rows(2),
                        ])
                        ->action(function (array $data, $record) {
                            // dd($record->kategori_id, $record->toArray());
                            $laptop = \App\Models\LaptopModel::find($record->id);
                            \App\Models\PerpindahanAsetModel::create([
                                'kategori_id' => $laptop->kategori_id,
                                'asset_id' => $laptop->id,
                                'cabang_asal_id' => $laptop->cabang_id ?? null,
                                'cabang_tujuan_id' => $data['cabang_tujuan_id'],
                                'user_baru' => $data['user_baru'],
                                'keterangan' => $data['keterangan'],
                                'tanggal_pindah' => now(),
                            ]);

                            // Update laptop (atau asset lain)
                            $laptop->update([
                                'cabang_id' => $data['cabang_tujuan_id'],
                                'user' => $data['user_baru'],
                            ]);

                            Notification::make()
                                ->title('Berhasil!')
                                ->body('Aset berhasil dipindahkan.')
                                ->success()
                                ->send();
                        })
                        ->color('success')
                        ->modalHeading('Kirim Aset')
                        ->modalButton('Kirim'),

                    Action::make('history')
                        ->label('Lihat History')
                        ->icon('heroicon-m-clock')
                        ->modalHeading('Riwayat Perpindahan Aset')
                        ->modalSubmitAction(false) // tidak ada tombol submit
                        ->modalCancelActionLabel('Tutup')
                        ->modalContent(function ($record) {
                            $history = \App\Models\PerpindahanAsetModel::where('asset_id', $record->id)
                                ->where('kategori_id', $record->kategori_id)
                                ->with(['cabangAsal', 'cabangTujuan'])
                                ->latest('tanggal_pindah')
                                ->get();

                            return view('components.history-modal', compact('history'));
                        })
                ])
                    ->label('More options')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('primary')
                    ->size(\Filament\Support\Enums\ActionSize::Small),



            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaptops::route('/'),
            'create' => Pages\CreateLaptop::route('/create'),
            'edit' => Pages\EditLaptop::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        return parent::getEloquentQuery()
            ->with(['kategori']) // <-- Tambahkan ini
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
