<?php

namespace App\Logging;

class CustomizeFormatter
{
    /**
     * 渡されたロガーインスタンスのカスタマイズ
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $formatter = new LineFormatter();
            $formatter->includeStacktraces(true);
            $handler->setFormatter($formatter);
        }
    }
}