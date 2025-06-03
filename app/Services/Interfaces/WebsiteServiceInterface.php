<?php

namespace App\Services\Interfaces;

/**
 * Interface WebsiteServiceInterface
 * @package App\Services\Interfaces
 */
interface WebsiteServiceInterface
{
    public function create($request);

    public function update($request);

    public function delete($request);
}
