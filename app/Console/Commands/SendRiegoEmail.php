<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Riego;
use App\Planificacionriego;
use App\Fumigacion;
use App\Simulador;
use App\Planificacionfumigacion;
use Mail;
use DateTime;
use Illuminate\Support\Facades\Artisan;

class SendRiegoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:riego';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Riego pendiente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while (true) {
            $current_date = date_create(date("Y-m-d"));
            date_time_set($current_date, date("H"), date("i"));
            echo date_format($current_date,"Y-m-d H:i:s");

            $planificacionriegos = Planificacionriego::with(['riego', 'riego.siembra', 'riego.siembra.preparacionterreno', 'riego.siembra.preparacionterreno.tecnico'])->whereYear('fecha_planificacion', '=', date('Y'))->whereMonth('fecha_planificacion', '=', date('m'))->whereDay('fecha_planificacion', '=', date('d'))->where('estado','=','Planificado')->where('fecha_planificacion','<=',$current_date)->get();
            $planificacionfumigacions = Planificacionfumigacion::with(['fumigacion', 'fumigacion.siembra', 'fumigacion.siembra.preparacionterreno', 'fumigacion.siembra.preparacionterreno.tecnico'])->whereYear('fecha_planificacion', '=', date('Y'))->whereMonth('fecha_planificacion', '=', date('m'))->whereDay('fecha_planificacion', '=', date('d'))->where('estado','=','Planificado')->where('fecha_planificacion','<=',$current_date)->get();

            foreach($planificacionriegos as $planificacionriego) {
                Planificacionriego::where('id', $planificacionriego['id'])
                    ->update([
                        'estado' => 'Ejecutado',
                    ]);
                $email_tecnico = $planificacionriego['riego']['siembra']['preparacionterreno']['tecnico']['email'];
                Mail::queue('emails.riego', ['planificacionriego' => $planificacionriego], function ($mail) use ($email_tecnico) {
                    $mail->to($email_tecnico)
                        ->from('noreply@toco.com', 'Toco')
                        ->subject('Alerta Planificacion de Riego!');
                });

//                Simulador::create([
//                    'numero_simulacion' => 2,
//                    'problemas' => $request['simulador_problemas'],
//                    'altura' => $request['simulador_altura'],
//                    'humedad' => $request['simulador_humedad'],
//                    'rendimiento' => $request['simulador_rendimiento'],
//                    'tipo' => "Siembra",
//                    'siembra_id' => $siembra['id'],
//                    'preparacionterreno_id' => $siembra['preparacionterreno_id'],
//                ]);
                $this->info('Send email riego, id='. $planificacionriego['id']);
            }

            foreach($planificacionfumigacions as $planificacionfumigacion) {
                Planificacionfumigacion::where('id', $planificacionfumigacion['id'])
                    ->update([
                        'estado' => 'Ejecutado',
                    ]);
                $email_tecnico = $planificacionfumigacion['fumigacion']['siembra']['preparacionterreno']['tecnico']['email'];
                Mail::queue('emails.fumigacion', ['planificacionfumigacion' => $planificacionfumigacion], function ($mail) use ($email_tecnico) {
                    $mail->to($email_tecnico)
                        ->from('noreply@toco.com', 'Toco')
                        ->subject('Alerta Planificacion de Fumigacion!');
                });
                $this->info('Send email fumigacion, id='. $planificacionfumigacion['id']);

            }

            $this->info('Mensages de planificacion enviados!');
            sleep(60);
        }
    }
}
