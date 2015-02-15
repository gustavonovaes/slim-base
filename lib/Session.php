<?php namespace SlimBase;

/**
 * Class SessionKeyNotExists
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */
class SessionKeyNotExists extends \Exception
{
}

;

/**
 * Class Session
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */
class Session implements \SlimBase\iSession
{
    /**
     * Impede nova instancia
     */
    protected function __construct()
    {
    }

    /**
     * @return static Session
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
     * Retorna o valor da chave na sessão
     *
     * @param string $key
     *
     * @return mixed
     * @throws SessionKeyNotExists
     */
    public function get($key)
    {
        $this->start();
        $this->close();

        if (!$this->has($key))
            throw new SessionKeyNotExists('Key ' . $key . ' not exist.');

        return $_SESSION[$key];
    }

    /**
     * Inicia sessão
     */
    private function start()
    {
        session_start();
    }

    /**
     * Fecha a sessão para escrita
     *
     * Impede que outros scripts php parem enquanto aguardam o primeiro que ainda está sendo executado com a
     * escrita na sessão disponível apenas para ele durante sua execução.
     */
    private function close()
    {
        session_write_close();
    }

    /**
     * Verifica existência da chave na sessão
     *
     * @param string $key Nome da chave
     *
     * @return bool
     */
    public function has($key)
    {
        $this->start();
        $this->close();

        return isset($_SESSION[$key]);
    }

    /**
     * Armazena valor na sessão
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->start();

        $_SESSION[$key] = $value;

        $this->close();
    }

    /**
     * Remove chave da sessão
     *
     * @param string $key
     */
    public function del($key)
    {
        $this->start();

        unset($_SESSION[$key]);

        $this->close();
    }

    /**
     * Destroi a sessão
     */
    public function destroy()
    {
        $this->start();
        session_destroy();
    }

    /**
     * Impede clone
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
}