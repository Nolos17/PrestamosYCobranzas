<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    public function index()
    {
        $backups = [];
        $files = Storage::disk('local')->files('Laravel'); // Lista los archivos en storage/app/Laravel

        foreach ($files as $file) {
            $backups[] = [
                'nombre' => basename($file),
                'fecha' => \Carbon\Carbon::createFromTimestamp(Storage::disk('local')->lastModified($file))->toDateTimeString(),
            ];
        }

        return view('admin.backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Configuración de la base de datos desde .env
            $dbName = env('DB_DATABASE', 'sisbanco1');
            $dbUser = env('DB_USERNAME', 'root');
            $dbPass = env('DB_PASSWORD', ''); // Vacío en tu caso
            $mysqlDumpPath = 'C:/xampp/mysql/bin/mysqldump.exe'; // Ruta completa a mysqldump.exe

            // Nombre del archivo de backup
            $backupFileName = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
            $backupPath = storage_path('app/Laravel/' . $backupFileName);

            // Asegúrate de que el directorio exista
            Storage::disk('local')->makeDirectory('Laravel');

            // Comando para ejecutar mysqldump
            $command = [
                $mysqlDumpPath,
                "--user=$dbUser",
            ];

            // Agregar contraseña solo si existe
            if (!empty($dbPass)) {
                $command[] = "--password=$dbPass";
            }

            // Especificar la base de datos
            $command[] = $dbName;
            $command[] = "--result-file=$backupPath"; // Guardar en el archivo

            // Ejecutar el proceso
            $process = new Process($command);
            $process->setTimeout(3600); // Timeout de 1 hora
            $process->run();

            // Verificar si el proceso falló
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            Log::info('Backup creado exitosamente: ' . $backupPath);

            // Redirigir a la lista sin descargar inmediatamente
            return redirect()->route('admin.backups.index')
                ->with('mensaje', 'Se creó el backup correctamente: ' . $backupFileName)
                ->with('icono', 'success');
        } catch (\Exception $e) {
            Log::error('Error al crear el backup: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());

            return redirect()->route('admin.backups.index')
                ->with('mensaje', 'Error al crear el backup: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }

    public function download($filename)
    {
        try {
            // Ruta del archivo en storage/app/Laravel
            $filePath = storage_path('app/Laravel/' . $filename);

            // Verificar que el archivo exista
            if (!file_exists($filePath)) {
                throw new \Exception('El archivo de backup no existe: ' . $filename);
            }

            // Descargar el archivo
            return response()->download($filePath, $filename, [
                'Content-Type' => 'application/sql',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al descargar el backup: ' . $e->getMessage());

            return redirect()->route('admin.backups.index')
                ->with('mensaje', 'Error al descargar el backup: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }
}
