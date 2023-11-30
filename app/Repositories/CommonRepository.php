<?php

namespace App\Repositories;

use App\Helpers\LoggerHelper;
use App\Models\Article;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CommonRepository extends AbstractRepository
{
    private static $instance;
    private Builder $query;

    public static function take(): static
    {
        return static::$instance ?? (static::$instance = new static());
    }

    public function getConfigurationData()
    {
        $sql = "SELECT * FROM configurators";
        return collect($this->executeSelectAll($sql));
    }

    public function updateConfigurationData(array $data)
    {
        $when = "UPDATE configurators SET `value` = CASE `key` ";
        $keys = [];
        foreach ($data as $key => $value) {
            $keys[] = "'$key'";
            $when .= "WHEN '$key' THEN '$value' ";
        }
//        array_keys($data)
//        dd($keys);
        $whereIn = implode(',', $keys);

        $sql = $when . "ELSE null END WHERE `key` IN ($whereIn)";

//        dd($sql);
        try {
            return self::execute($sql);
        } catch (Exception $e) {
            LoggerHelper::commonErrorVerbose($e);
            return false;
        }
    }

    public function getRelativeLastArticles(int $articleID, string $categoryCode): Collection
    {
        $sql = "
                SELECT ar.*, ac.code
                FROM articles AS ar
                LEFT JOIN article_categories AS ac ON category_id = ac.id
                WHERE ar.publication_date <= now()
                AND ar.id != $articleID
                ORDER BY field(ac.code, '$categoryCode') DESC, publication_date DESC
                LIMIT 4;
            ";

        return collect(self::executeSelectAll($sql, Article::class));
    }

    public function setExceptedID(int $id)
    {
        $this->query->where('id', '!=', $id);
        return $this;
    }

    public function getFirst(): Model|Builder|null
    {
        return $this->query->first();
    }

    public function getFirstOrFail(): Model|Builder
    {
        return $this->query->firstOrFail();
    }

    public function getAll(): iterable
    {
        return $this->query->get();
    }

    public function getPaginator(int $perPage = 8, int $page = 1): LengthAwarePaginator
    {
        return $this->query->paginate(perPage: $perPage, page: $page);
    }
}
