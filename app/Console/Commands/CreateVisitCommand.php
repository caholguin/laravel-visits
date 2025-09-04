<?php

namespace App\Console\Commands;

use App\Models\Visit;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;
use function Laravel\Prompts\table;

class CreateVisitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visit:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear una nueva visita usando Laravel Prompts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('🚀 Creando una nueva visita...');
        
        // Solicitar datos al usuario
        $name = text(
            label: '¿Cuál es el nombre del visitante?',
            placeholder: 'Ej: Juan Pérez',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 2 => 'El nombre debe tener al menos 2 caracteres.',
                strlen($value) > 255 => 'El nombre no puede tener más de 255 caracteres.',
                default => null
            }
        );

        $email = text(
            label: '¿Cuál es el correo electrónico?',
            placeholder: 'Ej: juan@ejemplo.com',
            required: true,
            validate: fn (string $value) => match (true) {
                !filter_var($value, FILTER_VALIDATE_EMAIL) => 'Por favor ingresa un correo electrónico válido.',
                Visit::where('email', $value)->exists() => 'Este correo electrónico ya está registrado.',
                default => null
            }
        );

        $latitude = text(
            label: '¿Cuál es la latitud?',
            placeholder: 'Ej: 6.2476',
            required: true,
            validate: fn (string $value) => match (true) {
                !is_numeric($value) => 'La latitud debe ser un número válido.',
                (float)$value < -90 || (float)$value > 90 => 'La latitud debe estar entre -90 y 90 grados.',
                default => null
            }
        );

        $longitude = text(
            label: '¿Cuál es la longitud?',
            placeholder: 'Ej: -75.5658',
            required: true,
            validate: fn (string $value) => match (true) {
                !is_numeric($value) => 'La longitud debe ser un número válido.',
                (float)$value < -180 || (float)$value > 180 => 'La longitud debe estar entre -180 y 180 grados.',
                default => null
            }
        );

        // Mostrar resumen de los datos ingresados
        info('📋 Resumen de la visita:');
        table(
            ['Campo', 'Valor'],
            [
                ['Nombre', $name],
                ['Email', $email],
                ['Latitud', $latitude],
                ['Longitud', $longitude],
            ]
        );

        // Confirmar antes de guardar
        $confirmed = confirm(
            label: '¿Deseas guardar esta visita?',
            default: true
        );

        if (!$confirmed) {
            error('❌ Operación cancelada.');
            return Command::FAILURE;
        }

        try {
            // Crear la visita
            $visit = Visit::create([
                'name' => $name,
                'email' => $email,
                'latitude' => (float)$latitude,
                'longitude' => (float)$longitude,
            ]);

            info("✅ ¡Visita creada exitosamente!");
            info("🆔 ID de la visita: {$visit->id}");
            info("📅 Fecha de creación: {$visit->created_at->format('d/m/Y H:i:s')}");
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            error("❌ Error al crear la visita: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}