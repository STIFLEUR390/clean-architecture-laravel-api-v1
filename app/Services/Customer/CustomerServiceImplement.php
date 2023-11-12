<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Repositories\Customer\CustomerRepositoryImplement;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;

class CustomerServiceImplement extends ServiceApi implements CustomerService
{
    /**
     * set message api for CRUD
     *
     * @param  string  $title
     * @param  string  $create_message
     * @param  string  $update_message
     * @param  string  $delete_message
     */
    protected $title = 'Client';

    protected $create_message = 'Le client a été créer avec succèss';

    protected $update_message = 'Le client a été mis à jour avec succèss';

    protected $delete_message = 'Le client a été supprimer avec succèss';

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CustomerRepositoryImplement $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function find($id): Customer
    {
        try {
            return $this->mainRepository->find($id);
        } catch (Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function findOrFail($id): Customer
    {
        try {
            return $this->mainRepository->findOrFail($id);
        } catch (Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function all()
    {
        try {
            return $this->mainRepository->all();
        } catch (Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function create($data): Customer
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $data['password'] = empty($data['password']) ? bcrypt('password') : bcrypt($data['password']);

            return $this->mainRepository->create($data);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function update($id, array $data): Customer
    {
        DB::beginTransaction();
        try {
            DB::commit();
            if (! empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            return $this->mainRepository->update($id, $data);
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }
}
