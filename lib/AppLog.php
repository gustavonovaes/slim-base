<?php namespace SlimBase;

/**
 * Class AppLog
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */
class AppLog
{
    /**
     * @var array same of \Slim\Log::$levels
     */
    protected $levels = array(
        1 => 'EMERGENCY',
        2 => 'ALERT',
        3 => 'CRITICAL',
        4 => 'ERROR',
        5 => 'WARNING',
        6 => 'NOTICE',
        7 => 'INFO',
        8 => 'DEBUG'
    );

    /**
     * @var string
     */
    private $filepath = null;

    /**
     * Prevents new instance
     */
    protected function __construct()
    {
    }

    /**
     * Prevents clone
     */
    private function __clone()
    {
    }

    /**
     * Impede serialização
     */
    private function __wakeup()
    {
    }

    /**
     * @return static AppLog
     */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Setup filepath where the log is stored
     *
     * @param $filepath string
     */
    public function setup($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * Method used as the Slim LogWriter
     *
     * @param $message string
     * @param $level string
     */
    public function write($message, $level)
    {
        $level_description = 'UNDEFINED';

        if (isset($this->levels[$level]))
            $level_description = $this->levels[$level];

        $content = "[" . $level_description . "] " . date('d/m/Y H:i:s') . PHP_EOL . $message . PHP_EOL . PHP_EOL;
        file_put_contents($this->filepath, $content, FILE_APPEND);

    }
}