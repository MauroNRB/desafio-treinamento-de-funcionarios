<?php

namespace App\Entity;

interface EntityBaseInterface
{
    /**
     * @return integer
     */
    public function getId(): ?int;

    /**
     * Retorna todos os atributos
     *
     * @return array
     */
    public function getArrayEntity(): array;

    /**
     * Somente atributos que envolvem a classe, sem os que tem relacionamentos
     *
     * @return array
     */
    public function getArrayBaseEntity(): array;
}