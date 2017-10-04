<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Riego;
use App\Planificacionriego;
use App\Fumigacion;
use App\Planificacionfumigacion;
use Mail;
use DateTime;

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
        $date_pre = date_create(date("Y-m-d"));
        date_time_set($date_pre, date("H")-4, date("i")-1);
        $date_pos = date_create(date("Y-m-d"));
        date_time_set($date_pos, date("H")-4, date("i")+1);
        $planificacionriegos = Planificacionriego::with(['riego', 'riego.siembra', 'riego.siembra.preparacionterreno', 'riego.siembra.preparacionterreno.tecnico'])->whereYear('fecha_planificacion', '=', date('Y'))->whereMonth('fecha_planificacion', '=', date('m'))->whereDay('fecha_planificacion', '=', date('d'))->where('fecha_planificacion','>=', $date_pre)->where('fecha_planificacion','<=',$date_pos)->get();
        $planificacionfumigacions = Planificacionfumigacion::with(['fumigacion', 'fumigacion.siembra', 'fumigacion.siembra.preparacionterreno', 'fumigacion.siembra.preparacionterreno.tecnico'])->whereYear('fecha_planificacion', '=', date('Y'))->whereMonth('fecha_planificacion', '=', date('m'))->whereDay('fecha_planificacion', '=', date('d'))->where('fecha_planificacion','>=', $date_pre)->where('fecha_planificacion','<=',$date_pos)->get();

        foreach($planificacionriegos as $planificacionriego) {

            $email_tecnico = $planificacionriego['riego']['siembra']['preparacionterreno']['tecnico']['email'];
            Mail::queue('emails.riego', ['planificacionriego' => $planificacionriego], function ($mail) use ($email_tecnico) {
                $mail->to($email_tecnico)
                    ->from('noreply@toco.com', 'Toco')
                    ->subject('Alerta Planificacion de Riego!');
            });
        }

        foreach($planificacionfumigacions as $planificacionfumigacion) {

            $email_tecnico = $planificacionfumigacion['fumigacion']['siembra']['preparacionterreno']['tecnico']['email'];
            Mail::queue('emails.fumigacion', ['planificacionfumigacion' => $planificacionfumigacion], function ($mail) use ($email_tecnico) {
                $mail->to($email_tecnico)
                    ->from('noreply@toco.com', 'Toco')
                    ->subject('Alerta Planificacion de Fumigacion!');
            });

        }

        $this->info('Mensages de planificacion enviados!');
    }
}
