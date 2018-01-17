<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions()
    {
        return [
            'view_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
            'assign_roles',

            'view_projects',
            'add_projects',
            'edit_projects',
            'delete_projects',

            'view_corpora',
            'add_corpora',
            'edit_corpora',
            'delete_corpora',
            'publish_corpora',

            'upload_header',
            'download_header',
            'update_header',

            'upload_data',
            'download_data',
            'update_data',
        ];
    }
}
