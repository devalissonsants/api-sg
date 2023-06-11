<?php

namespace App\Http\Controllers\Demand;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $with = ['company'];
    private $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $model = Utils::search($this->model, $request->all());
        $model = $model->where('company_id', $request->company_id);
        return Utils::pagination($model->with($this->with), $request->all());
    }

    public function store(Request $request)
    {
        $model = $this->model->create($request->all());
        return $this->model->with($this->with)->findOrFail($model->id);
    }

    public function show(Request $request, string $id)
    {
        return $this->model->with($this->with)->where('company_id', $request->company_id)->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $model = $this->model->where('company_id', $request->company_id)->findOrFail($id);
        $model->fill($request->all())->save();
        return $this->model->with($this->with)->findOrFail($id);
    }

    public function destroy(Request $request, string $id)
    {
        return $this->model->with($this->with)->where('company_id', $request->company_id)->findOrFail($id)->delete();
    }
}
