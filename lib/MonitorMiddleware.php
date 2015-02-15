<?php namespace SlimBase;

/**
 * Class MonitorMiddleware
 *
 * Collects information, such as duration and peak memory and displays on the screen.
 *
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */
class MonitorMiddleware extends \Slim\Middleware
{
    public function call()
    {
        $time = microtime(true);

        $app = $this->app;
        $res = $app->response;

        $this->next->call();

        $duration = number_format((microtime(true) - $time), 3);

        $body = $res->getBody();

        $memory = (memory_get_peak_usage(true) / 1024 / 1024);
        $memory = $memory > 1024 ? ($memory / 1024) . ' MB' : $memory . ' KB';

        $html = '<div style="position: fixed; left: 4px; bottom: 10px; padding: 2px; background-color: rgba(255,255,255,.6); border-radius: 5px;"
            <span><strong>Duration: </strong>' . $duration . '</span>
            <span><strong>Memory: </strong>' . $memory . '</span>
        </div>';

        if ($pos = strpos($body, "</body>")) {
            $body = substr_replace($body, $html, $pos);

            $res->setBody($body);
        }
    }
}