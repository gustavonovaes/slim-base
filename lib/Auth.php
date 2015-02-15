<?php namespace SlimBase;


class AuthUserNotFound extends \Exception
{
}

class AuthInvalidPassword extends \Exception
{
}

/**
 * Class Auth
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */
class Auth
{
    private $index_user = 'user';
    private $index_permission = 'permissions';
    private $index_admin = 'admin';

    private $user_table = '';

    /**
     * @type \Illuminate\Database\Connection|null
     */
    private $conn = null;

    /**
     * @type iSession|null
     */
    private $session = null;

    /**
     * @param \Illuminate\Database\Connection $conn
     * @param iSession $session
     */
    public function __construct(\Illuminate\Database\Connection $conn, iSession $session, $user_table = 'users')
    {
        $this->conn = $conn;
        $this->session = $session;

        $this->user_table = $user_table;
    }

    /**
     * Verifica se usuário está logado
     *
     * @return bool
     */
    function isLoggedIn()
    {
        return $this->session->has($this->index_user);
    }

    /**
     * Autentica usuário
     *
     * @param string $login
     * @param string $senha
     *
     * @throws AuthInvalidPassword
     * @throws AuthUserNotFound
     */
    function attempt($login, $senha)
    {
        $user = (array) $this->conn->table($this->user_table)
                        ->where('login', '=', $login)
                        ->first();

        if (count($user) == 0)
            throw new AuthUserNotFound('User not found');

        if (false === password_verify($senha, $user['pass']))
            throw new AuthInvalidPassword('Invalid Pass');

        // Clean pass before write in session
        unset($user['pass']);

        $this->session->set($this->index_user, $user);
    }


    /**
     * Desloga o usuário
     */
    function logout()
    {
        $this->session->destroy();
    }

    /**
     * Retorna login do usuário logado
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->session->get($this->index_user)['login'];
    }

    /**
     * Verifica se usuário tem acesso a permissão
     *
     * @param $descricao Descrição da permissão
     *
     * @return bool
     */
    public function havePermission($descricao)
    {
        return in_array($descricao, $this->session->get($this->index_user)[$this->index_permission]);
    }

    /**
     * Verifica se usuário é admin
     *
     * @param $level Level do admin
     *
     * @return bool
     */
    public function isAdmin($level)
    {
        return $this->session->get($this->index_user)[$this->index_admin] >= $level;
    }
}