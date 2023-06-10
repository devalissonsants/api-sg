<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $with = ['city'];
    private $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $model = Utils::search($this->model, $request->all());
        return Utils::pagination($model->with($this->with), $request->all());
    }

    public function store(Request $request)
    {
        $model = $this->model->create($request->all());
        return $this->model->with($this->with)->findOrFail($model->id);
    }

    public function show(string $id)
    {
        return $this->model->with($this->with)->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($request->all())->save();
        return $this->model->with($this->with)->findOrFail($id);
    }

    public function destroy(string $id)
    {
        return $this->model->with($this->with)->findOrFail($id)->delete();
    }
}
