<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * Get all paginated items
     *
     */
    public function findAll(): Collection;

    /**
     * Get a specific item
     *
     */
    public function get(int $identifier);

    /**
     * Create a specific item
     *
     */
    public function store(array $data);

    /**
     * Update a specific item
     *
     */
    public function update(array $data, int $identifier);

    /**
     * Delete a specific item
     *
     */
    public function delete(string $identifier);

}