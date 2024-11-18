<?php

namespace App\Controller;

use App\Entity\People;
use App\Form\PeopleType;

class PeopleController extends BaseController
{
    public function __construct()
    {
        $this->entity = new People();
        $this->formType = PeopleType::class;
        $this->path = 'people';
        $this->entityType = People::class;
    }

    protected function create($em, $arr)
    {

    }

    protected function update($em, $arr)
    {

    }
}
