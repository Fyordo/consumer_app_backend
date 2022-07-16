<?php

namespace App\Console\Commands;

use App\Events\SensorActivity;
use App\Models\Flat;
use App\Models\Sensor;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Console\Command;

class CheckSensors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensor:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка дома сенсором';

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
     * @return int
     */
    public function handle()
    {
        $sensors = Sensor::all();

        foreach ($sensors as $sensor) {
            try {
                $error_simulation = rand(0, 100) <= 10;
                if ($error_simulation) {
                    $random_flat = Flat::where('id', '=', rand(1, Flat::all()->count() - 1))->first();

                    $error_text = $this->getErrorText($sensor);

                    $message = "ВНИМАНИЕ! " . $sensor->title . " обнаружил опасную активность! " . $error_text;
                    $status = 1;
                    echo "Бан\n";
                } else {
                    $message = $sensor->title . " работает нормально, опасности не выявлено.";
                    $status = 0;
                    echo "Не бан\n";
                }

                broadcast(new SensorActivity($sensor, $message, $status))->toOthers();
            }
            catch (BroadcastException $ex){
                $message = "ВНИМАНИЕ! " . $sensor->title . " перестал функционировать!";
                $status = -1;
                echo "Бан х2\n";
                broadcast(new SensorActivity($sensor, $message, $status))->toOthers();
            }
        }

        return 0;
    }

    private function getErrorText(Sensor $sensor){
        switch ($sensor->id){
            case 1:
                $errors = [
                    'Обнаружен повышенный уровень задымления воздуха, включаю систему пожаротушения'
                ];
                return $errors[rand(0, count($errors) - 1)];
            case 2:
                $errors = [
                    'Отключился один из источников питания, перехожу на резервный генератор',
                    'Выявлены неполадки в работе бесперебойника, отправляю запрос в службу электро-сети',
                    'Обранужена проблема с "нулём", отправляю запрос в службу электро-сети',
                    'Обранужена проблема с "землёй", отправляю запрос в службу электро-сети',
                    'Обранужена проблема с "фазой", отправляю запрос в службу электро-сети',
                    'Выявлены неполадки в связи с контроллером технического процесса, отправляю запрос в службу электро-сети',
                ];
                return $errors[rand(0, count($errors) - 1)];
            case 3:
                $errors = [
                    'Упало давление воды, возможно отключение водоснабжения, перехожу на запасной бак',
                    'Выявлены неполадки в работе счётчика, отправляю запрос в ЖКХ',
                    'Температура воды упала, возможно отключение горячей воды, отправляю запрос в ЖКХ',
                ];
                return $errors[rand(0, count($errors) - 1)];
            case 4:
                $errors = [
                    'Температура выше нормы',
                    'Температура ниже нормы',
                    'Отключён климат-контроль, возможна неверная работа устройств контроля температуры',
                ];
                return $errors[rand(0, count($errors) - 1)];
            case 5:
                $errors = [
                    'Повышенное содержание CO2 в помещении, открываю окна для проветривания',
                    'Повышена относительная влажность, выключаю увлажнитель воздуха',
                    'Понижена относительная влажность, включаю увлажнитель воздуха',
                    'Температура воздуха повышена, включаю кондиционер',
                    'Повышено атмосферное давление',
                    'Понижено атмосферное давление',
                ];
                return $errors[rand(0, count($errors) - 1)];
        }
    }
}
