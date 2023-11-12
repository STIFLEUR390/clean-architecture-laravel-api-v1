<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Repositories\Address\AddressRepositoryImplement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;

class AddressServiceImplement extends ServiceApi implements AddressService
{
    /**
     * set message api for CRUD
     *
     * @param  string  $title
     * @param  string  $create_message
     * @param  string  $update_message
     * @param  string  $delete_message
     */
    protected $title = '';

    protected $create_message = '';

    protected $update_message = '';

    protected $delete_message = '';

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(AddressRepositoryImplement $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function find($id): Address
    {
        try {
            return $this->mainRepository->find($id);
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function findOrFail($id): Address
    {
        try {
            return $this->mainRepository->findOrFail($id);
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function all()
    {
        try {
            return $this->mainRepository->all();
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function create($data): Address
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->create($data);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function update($id, array $data): Address
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->update($id, $data);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->delete($id);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function destroy(array $data)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->destroy($data);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }
}
