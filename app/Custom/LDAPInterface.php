<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 14.08.17
 * Time: 08:43
 */

namespace App\Custom;


interface LDAPInterface
{
    public function getProviders();
    public function authenticateUser($user_data);
}