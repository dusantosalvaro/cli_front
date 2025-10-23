<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property int $cliente_id
 * @property int $usuario_id
 * @property string $descricao
 * @property string $status
 * @property string|null $data_atendimento
 */
class TbAtendimento extends BaseModel
{
    public static $table_name = 'tb_atendimentos';
    public static $belongs_to = [
        ['cliente', 'class_name' => TbCliente::class, 'foreign_key' => 'cliente_id'],
        ['profissional', 'class_name' => TbUser::class, 'foreign_key' => 'usuario_id'],
    ];
}
