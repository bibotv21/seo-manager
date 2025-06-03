<?php

namespace App\Services\Interfaces;

/**
 * Interface TextLinkServiceInterface
 * @package App\Services\Interfaces
 */
interface TextLinkServiceInterface
{
    public function create($request);

    public function update($request);

    public function delete($request);
}
