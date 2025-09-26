<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('enrollments')
    ->timezone('America/Sao_Paulo')
   ->everyMinute()
  // ->everyThreeHours()
   // ->hourly()
    ->onOneServer()
    ->runInBackground();


Schedule::command('financial')
    ->timezone('America/Sao_Paulo')
   ->everyMinute()
  // ->everyThreeHours()
   // ->hourly()
    ->onOneServer()
    ->runInBackground();
