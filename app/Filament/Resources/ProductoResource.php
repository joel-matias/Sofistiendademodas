<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $pluralModelLabel = 'Productos';

    protected static ?string $modelLabel = 'Producto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // ==============================
                // ✅ SECCIÓN: INFORMACIÓN
                // ==============================
                Forms\Components\Section::make('Información del producto')
                    ->schema([

                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\Textarea::make('descripcion')
                            ->rows(4)
                            ->nullable(),

                        Forms\Components\TextInput::make('precio')
                            ->numeric()
                            ->required()
                            ->prefix('$'),

                        Forms\Components\Toggle::make('oferta')
                            ->label('¿Está en oferta?')
                            ->default(false)
                            ->live(),

                        Forms\Components\TextInput::make('precio_oferta')
                            ->numeric()
                            ->prefix('$')
                            ->visible(fn (Forms\Get $get) => $get('oferta') === true)
                            ->required(fn (Forms\Get $get) => $get('oferta') === true),

                        Forms\Components\Toggle::make('activo')
                            ->default(true),

                    ])
                    ->columns(2),

                // ==============================
                // ✅ SECCIÓN: CATEGORÍAS/TALLAS/COLORES
                // ✅ (con crear desde el mismo select)
                // ==============================
                Forms\Components\Section::make('Categorías / Tallas / Colores')
                    ->schema([

                        // ✅ Categorías
                        Forms\Components\Select::make('categorias')
                            ->relationship('categorias', 'nombre')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique('categorias', 'slug'),

                                Forms\Components\Textarea::make('descripcion')
                                    ->nullable(),

                                Forms\Components\FileUpload::make('imagen')
                                    ->image()
                                    ->directory('categorias')
                                    ->imageEditor()
                                    ->nullable(),
                            ]),

                        // ✅ Tallas
                        Forms\Components\Select::make('tallas')
                            ->relationship('tallas', 'nombre')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique('tallas', 'slug'),
                            ]),

                        // ✅ Colores
                        Forms\Components\Select::make('colores')
                            ->relationship('colores', 'nombre')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique('colores', 'slug'),

                                Forms\Components\TextInput::make('hex')
                                    ->label('HEX (opcional)')
                                    ->placeholder('#000000')
                                    ->nullable(),
                            ]),

                    ])
                    ->columns(3),

                // ==============================
                // ✅ SECCIÓN: IMÁGENES (máx 4 total)
                // ✅ principal cuenta
                // ==============================
                Forms\Components\Section::make('Imágenes (máx 4 en total)')
                    ->schema([

                        // ✅ Imagen principal (columna productos.imagen)
                        Forms\Components\FileUpload::make('imagen')
                            ->label('Imagen principal (cuenta dentro de las 4)')
                            ->image()
                            ->directory('productos')
                            ->imageEditor()
                            ->nullable()
                            ->live(), // 👈 importante para recalcular el max del repeater

                        // ✅ Galería (tabla imagenes_producto)
                        Forms\Components\Repeater::make('imagenes')
                            ->relationship('imagenes')
                            ->label('Galería de imágenes')
                            ->minItems(0)
                            ->maxItems(fn (Forms\Get $get) => $get('imagen') ? 3 : 4) // ✅ máximo dinámico
                            ->schema([
                                Forms\Components\FileUpload::make('url')
                                    ->label('Imagen')
                                    ->image()
                                    ->directory('productos/galeria')
                                    ->imageEditor()
                                    ->required(),

                                Forms\Components\TextInput::make('orden')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\Toggle::make('principal')
                                    ->label('¿Principal?')
                                    ->default(false),
                            ])
                            ->columns(3)
                            ->helperText(fn (Forms\Get $get) => $get('imagen')
                                ? 'Ya tienes una imagen principal, puedes agregar máximo 3 más.'
                                : 'Puedes agregar hasta 4 imágenes si no tienes imagen principal.'
                            ),

                    ]),

                // ==============================
                // ✅ SECCIÓN: DETALLES
                // ==============================
                Forms\Components\Section::make('Detalles del producto')
                    ->schema([
                        Forms\Components\Repeater::make('detalles')
                            ->relationship('detalles')
                            ->label('Lista de detalles')
                            ->schema([
                                Forms\Components\TextInput::make('texto')
                                    ->label('Detalle')
                                    ->required(),

                                Forms\Components\TextInput::make('orden')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->helperText('Estos detalles se mostrarán como lista en el producto.'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->circular(),

                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('precio')
                    ->money('MXN')
                    ->sortable(),

                Tables\Columns\IconColumn::make('oferta')
                    ->boolean(),

                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo'),
                Tables\Filters\TernaryFilter::make('oferta'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
