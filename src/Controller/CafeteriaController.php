<?php

namespace App\Controller;

use App\Entity\Cafeteria;
use App\Form\CafeteriaType;

class CafeteriaController extends BaseController
{
    public function __construct()
    {
        $this->entity = new Cafeteria();
        $this->formType = CafeteriaType::class;
        $this->path = 'cafeteria';
        $this->entityType = Cafeteria::class;
    }

    protected function create($em, $arr)
    {

    }

    protected function update($em, $arr)
    {

    }
}
