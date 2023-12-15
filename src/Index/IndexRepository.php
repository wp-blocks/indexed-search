<?php

namespace WpBlocks\Search\Index\IndexRepository;

interface IndexRepository
{
    public function create(string $name): int;
}
