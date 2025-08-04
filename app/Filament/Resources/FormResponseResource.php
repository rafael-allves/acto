<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResponseResource\Pages;
use App\Models\Form\Response;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('form.response.plural');
    }

    public static function getModelLabel(): string
    {
        return __('form.response.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('form.response.plural');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label(__('form.response.id'))->sortable(),
                TextColumn::make('user.name')->label(__('form.response.user_name'))->sortable()->searchable(),
                TextColumn::make('form.title')->label(__('form.response.form_title'))->sortable()->searchable(),
                TextColumn::make('created_at')->label(__('form.response.created_at'))->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\Filter::make('my_responses')
                    ->label(__('form.response.filter.my_responses'))
                    ->query(fn ($query) => $query->where('user_id', auth()->id())),

                Tables\Filters\Filter::make('responses_to_my_forms')
                    ->label(__('form.response.filter.responses_to_my_forms'))
                    ->query(fn ($query) => $query->whereHas('form', fn ($q) => $q->where('owner_id', auth()->id())))
            ])
            ->actions([
                Action::make('visualizar')
                    ->label(__('form.response.view'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn(Response $record): string => route(
                        'forms.responses.show',
                        ['form' => $record->form_id, 'response' => $record]
                    ))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([
                //Tables\Actions\ExportAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //ExportBulkAction::make(),
                ]),
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
            'index' => Pages\ListFormResponses::route('/')
        ];
    }
}
