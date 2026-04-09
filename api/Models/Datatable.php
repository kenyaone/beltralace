<?php

namespace App\Models;

class Datatable
{
    public $draw = null;
    public $columns = null;
    public $start = 0;
    public $length = null;
    public $search = null;
    public $order = null;

    public function __construct($data = array())
    {
        $this->draw = $data['draw'] ?? null;
        $this->columns = $data['columns'] ?? null;
        $this->start = $data['start'] ?? null;
        $this->length = $data['length'] ?? null;
        $this->search = $data['search'] ?? null;
        $this->order = $data['order'] ?? null;
    }
}