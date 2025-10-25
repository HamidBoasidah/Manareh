<?php

namespace App\Services;

use App\Repositories\CertificateIssuedRepository;

class CertificateIssuedService
{
    protected CertificateIssuedRepository $issued;

    public function __construct(CertificateIssuedRepository $issued)
    {
        $this->issued = $issued;
    }

    public function all(array $with = [])
    {
        return $this->issued->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->issued->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->issued->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->issued->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->issued->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->issued->delete($id);
    }

    public function activate($id)
    {
        return $this->issued->activate($id);
    }

    public function deactivate($id)
    {
        return $this->issued->deactivate($id);
    }
}
