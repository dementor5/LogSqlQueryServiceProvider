<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LogSqlQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->logSqlQuery();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function logSqlQuery()
    {
        \DB::listen(function ($query) {
            $str = date("d.m.Y H:i:s") . ' ';
            $str .= '(' . print_r($query->time, true) . ")\n";
            $str .= print_r($query->sql, true) . "\n";
            if (count($query->bindings)) {
                $str .= print_r($query->bindings, true);
            }

            \Storage::disk('logs')->append('sql.log', $str);
        });
    }
}
