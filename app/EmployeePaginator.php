<?php
  namespace App;

  use Illuminate\Pagination\LengthAwarePaginator;

  class EmployeePaginator {
    protected static $perPage = 50;

    /**
     * Returns a custom paginator.
     *
     * @param array $employees
     * @param Request $request
     */
    static function paginate($employees, $request) {
      $page = $request->page;
      $offset = ($page * self::$perPage) - self::$perPage;
      return new LengthAwarePaginator(
          array_slice($employees, $offset, self::$perPage, true),
          count($employees),
          self::$perPage,
          $page,
          ['path' => $request->url(), 'query' => $request->query()]
      );
    }
  }