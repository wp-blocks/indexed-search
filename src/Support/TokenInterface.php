<?php

namespace WpBlocks\Search\Support;

interface TokenInterface
{
    public function getPosition();

    public function getTag(): ?string;

    public function getValue(): string;

    public function isMetaword(): bool;
}
