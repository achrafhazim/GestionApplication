<?php

namespace Kernel\INTENT;

use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Tools\Tools;
use TypeError;

class Intent
{

    private $entitysSchema;
    private $entitysDataTable;
    private $mode;

    public function __construct(EntitysSchema $entitysSchema, array $entitysDataTables, array $mode)
    {
        $this->mode = $mode;
        $this->entitysSchema = $entitysSchema;
        $this->entitysDataTable = $entitysDataTables;
    }

    public function getEntitysSchema(): EntitysSchema
    {
        return $this->entitysSchema;
    }

    public function getEntitysDataTable()
    {
        return $this->entitysDataTable;
    }

    public function getMode(): array
    {
        return $this->mode;
    }

    // TOOLS
/// plus
}
