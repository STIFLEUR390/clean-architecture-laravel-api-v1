<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Traits\UploadFile;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;

class ProductServiceImplement extends ServiceApi implements ProductService
{
    use UploadFile;

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

    public function __construct(ProductRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function find($id): ?Product
    {
        try {
            return $this->mainRepository->find($id);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->exceptionResponse($exception);
        }
    }

    public function findOrFail($id): ?Product
    {
        try {
            return $this->mainRepository->findOrFail($id);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->exceptionResponse($exception);
        }
    }

    public function all()
    {
        try {
            return $this->mainRepository->all();
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->exceptionResponse($exception);
        }
    }

    public function create($data): Product
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $data['slug'] = Str::slug($data['name']);
            $data['img'] = $this->uploadFile($data['img'], 'products');

            return $this->mainRepository->create($data);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);

            return $this->exceptionResponse($exception);
        }
    }

    public function update($id, array $data): Product
    {
        DB::beginTransaction();
        try {
            DB::commit();
            if (! empty($data['img'])) {
                $product = $this->findOrFail($id);
                $data['img'] = $this->uploadFile($data['img'], 'products', $product->img);
            }
            $data['slug'] = Str::slug($data['name']);

            return $this->mainRepository->update($id, $data);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);

            return $this->exceptionResponse($exception);
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

            return $this->exceptionResponse($exception);
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

            return $this->exceptionResponse($exception);
        }
    }
}
