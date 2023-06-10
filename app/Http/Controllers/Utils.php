<?php

namespace App\Http\Controllers;

class Utils
{
    const defaultPerPage = 20;
    const defaultOrderBy = 'id';
    const defaultOrder = 'desc';

    public static function pagination($model, $requestInfo)
    {
        $orderBy = $requestInfo['orderBy'] ?? self::defaultOrderBy;
        $order = $requestInfo['order'] ?? self::defaultOrder;
        $perPage = $requestInfo['perPage'] ?? self::defaultPerPage;
        $columnRelationshipOrderBy = explode('.', $orderBy);
        if (count($columnRelationshipOrderBy) == 1) {
            $model = $model->orderBy($orderBy, $order);
        } else {
            $columnFilter = last($columnRelationshipOrderBy);
            $table = '';
            switch ($columnRelationshipOrderBy[0]) {
                case 'provider':
                    $table = 'providers';
                    break;
                case 'company':
                    $table = 'companies';
                    break;
                case 'cost_center':
                    $table = 'cost_center';
                    break;
                case 'chart_of_accounts':
                    $table = 'chart_of_accounts';
                    break;
            }
            $model
                ->join('providers', 'providers.id', '=', 'payment_requests.provider_id')
                ->join('companies', 'companies.id', '=', 'payment_requests.company_id')
                ->join('cost_center', 'cost_center.id', '=', 'payment_requests.cost_center_id')
                ->join('chart_of_accounts', 'chart_of_accounts.id', '=', 'payment_requests.chart_of_account_id')
                ->orderBy($table . '.' . $columnFilter, $order);
        }

        return $model->paginate($perPage);
    }

    public static function getDeleteKeys($nestable)
    {
        $arrayIds = [];
        foreach ($nestable as $key => $value) {
            array_push($arrayIds, $nestable[$key]['id']);
            if (sizeof($nestable[$key]['children']) > 0) {
                $auxArray = self::getDeleteKeys($nestable[$key]['children']);
                foreach ($auxArray as $element) {
                    array_push($arrayIds, $element);
                }
            }
        }
        return $arrayIds;
    }

    public static function validateDate($date, $format = 'd/m/Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function formatDate($date)
    {
        $date = explode('/', $date);
        $year = $date[2];
        $date[2] = $date[0];
        $date[0] = $year;
        return $date = implode('-', $date);
    }

    public static function search($model, $requestInfo, $excludeFields = null)
    {
        $fillable = $model->getFillable();
        if ($excludeFields != null) {
            foreach ($fillable as $key => $value) {
                if (in_array($fillable[$key], $excludeFields)) {
                    unset($fillable[$key]);
                }
            }
        }
        $query = $model->query();
        if (array_key_exists('search', $requestInfo)) {

            if (self::validateDate($requestInfo['search'], 'd/m/Y')) {
                $requestInfo['search'] = self::formatDate($requestInfo['search']);
            }
            if (array_key_exists('searchFields', $requestInfo)) {
                $query->whereLike($requestInfo['searchFields'], "%{$requestInfo['search']}%");
            } else {
                $query->whereLike($fillable, "%{$requestInfo['search']}%");
            }
        }
        return $query;
    }

}
