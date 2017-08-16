<?php
namespace App\Laudatio\HUAuth;
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 14.08.17
 * Time: 08:45
 */
use App\Custom\LDAPInterface;
use Adldap\AdldapInterface;
use Adldap\Adldap;
use Adldap\Auth\BindException;

class LDAPService implements LDAPInterface
{
    protected $config;
    protected $adldap;
    /**
     * Constructor.
     *
     * @param AdldapInterface $adldap
     */
    public function __construct(AdldapInterface $adldap)
    {
        $this->adldap = $adldap;
    }

    public function getProviders(){
        return $this->adldap->getProviders();
    }

    public function authenticateUser($user_data){
        // Authenticating against your LDAP server.
        return Adldap::auth()->attempt($user_data->username, $user_data->password);
    }
}