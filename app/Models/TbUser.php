<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string|null $role
 * @property string|null $permissions
 */
class TbUser extends BaseModel
{
    public static $table_name = 'tb_users';

    public function get_permissions_list(): array
    {
        if (!$this->permissions) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $this->permissions)));
    }
}
