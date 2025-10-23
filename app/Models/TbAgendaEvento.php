<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property string $titulo
 * @property string $inicio
 * @property string $fim
 * @property int|null $cliente_id
 */
class TbAgendaEvento extends BaseModel
{
    public static $table_name = 'tb_agenda_eventos';
    public static $belongs_to = [
        ['cliente', 'class_name' => TbCliente::class, 'foreign_key' => 'cliente_id'],
    ];
}
