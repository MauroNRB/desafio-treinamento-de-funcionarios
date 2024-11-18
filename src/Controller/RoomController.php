<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;

class RoomController extends BaseController
{
    public function __construct()
    {
        $this->entity = new Room();
        $this->formType = RoomType::class;
        $this->path = 'room';
        $this->entityType = Room::class;
    }

    protected function create($em, $arr)
    {

    }

    protected function update($em, $arr)
    {

    }
}
