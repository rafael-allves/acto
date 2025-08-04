<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form\Form as FormModel;
use App\Utils\SqlUtil;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Unique;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationLabel(): string
    {
        return __('form.plural');
    }

    public static function getModelLabel(): string
    {
        return __('form.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('form.plural');
    }


    public static function getFormSchema(?FormModel $record = null): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label(__('form.title'))
                ->placeholder(__('form.title_placeholder'))
                ->required()
                ->maxLength(255)
                ->unique(
                    table: FormModel::class,
                    column: 'title',
                    ignorable: $record,
                    modifyRuleUsing: fn(Unique $rule) => $rule->where('owner_id', auth()->id())
                ),

            Forms\Components\RichEditor::make('description')
                ->fileAttachmentsDisk(env('FILESYSTEM_DISK'))
                ->fileAttachmentsDirectory('attachments.forms')
                ->fileAttachmentsVisibility('public')
                ->label(__('form.description'))
                ->placeholder(__('form.description_placeholder'))
                ->maxLength(SqlUtil::TEXT),

            Forms\Components\Toggle::make('is_active')
                ->label(__('form.is_active'))
                ->default(true),

            Forms\Components\Repeater::make('questions')
                ->label(__('form.question.title'))
                ->relationship()
                ->schema([
                    Forms\Components\RichEditor::make('text')
                        ->fileAttachmentsDisk(env('FILESYSTEM_DISK'))
                        ->fileAttachmentsDirectory('attachments.forms.questions')
                        ->fileAttachmentsVisibility('public')
                        ->label(__('form.question.text'))
                        ->maxLength(SqlUtil::TEXT)
                        ->required(),

                    Forms\Components\Select::make('type')
                        ->label(__('Type'))
                        ->options([
                            'multiple_choice' => __('form.question.multiple_choice'),
                            'open' => __('form.question.open'),
                        ])
                        ->live()
                        ->required(),

                    Forms\Components\Toggle::make('mandatory')
                        ->label(__('form.question.mandatory'))
                        ->default(true),

                    Forms\Components\Repeater::make('alternatives')
                        ->relationship()
                        ->label('Alternativas')
                        ->schema([
                            Forms\Components\RichEditor::make('text')
                                ->fileAttachmentsDisk(env('FILESYSTEM_DISK'))
                                ->fileAttachmentsDirectory('attachments.forms.questions.alternatives')
                                ->fileAttachmentsVisibility('public')
                                ->label(__('form.question.alternatives.text'))
                                ->maxLength(SqlUtil::TEXT)
                                ->required(),
                            Forms\Components\Toggle::make('is_correct')
                                ->label('Correta')->default(false),
                        ])
                        ->columns(1)
                        ->hidden(fn($get) => $get('type') !== 'multiple_choice')
                        ->collapsible(),
                ])
                ->collapsible()
                ->addActionLabel(__('form.question.add'))
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema($form->getRecord()))->columns(1);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->query(
                FormModel::query()
                    ->where('owner_id', auth()->id())
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('form.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('form.description'))
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('form.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('form.created_at'))
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('form.status_filter'))
                    ->trueLabel(__('form.active'))
                    ->falseLabel(__('form.inactive'))
                    ->placeholder(__('form.all')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('form.create'))
                    ->form(static::getFormSchema())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // future: QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes();
    }
}
