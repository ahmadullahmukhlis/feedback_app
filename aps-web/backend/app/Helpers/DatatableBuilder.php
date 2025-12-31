<?php

namespace App\Helpers;

class DatatableBuilder
{
    private $query;
    private array $search_columns;

    public function __construct($query, $search_columns = []){
        $this->query = $query;
        $this->search_columns = $search_columns;
    }
    public function build(){
        $search_columns = $this->search_columns;
        $limit = 10;
        $order_by = 'id';
        $order_direction = 'desc';
        if(request()->has('filter') && request()->get('filter') != 'null'){
            $this->query = $this->query->where(function($whereCondition) use($search_columns) {
                $whereCondition->where($search_columns[0], 'LIKE', '%'.request()->get('filter').'%');
                foreach (array_slice($search_columns, 1) as $column){
                    $whereCondition->orWhere($column, 'LIKE', '%'.request()->get('filter').'%');
                }
            });
        }
        if(request()->has('limit')){
            $limit = request()->get('limit');
            if($limit > 500){
                return back()->with(['message' => 'Number of record per page cannot be greater than 100', 'type' => 'error']);
            }
        }

        if(request()->has('order_by')){
            $order_by = request()->get('order_by');
        }
        if(request()->has('direction')){
            $order_direction = request()->get('direction');
        }

        return $this->query->orderBy($order_by, $order_direction)->paginate($limit);
    }
}
