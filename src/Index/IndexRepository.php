<?php

namespace IndexedSearch\Index\IndexRepository;

interface IndexRepository
{
    public function create(string $name): int;
}
