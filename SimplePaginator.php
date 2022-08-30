<?php

class SimplePaginator
{

    private static array $dataRows;
    private static int $numberOfPages;
    private static array $instances = [];

    public static function getInstance($file): SimplePaginator
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
            $fullDataString = file_get_contents($file);
            $fulDataArray = json_decode($fullDataString, true);
            self::$dataRows = $fulDataArray['data'];
            self::getData();
        }
        return self::$instances[$cls];
    }

    private function __construct()
    {

    }

    public static function getDataRows($page): mixed
    {
        return self::$dataRows[$page];
    }

    public static function getData()
    {
        $rows = self::$dataRows;
        $i = 0;
        $counter = 0;
        $dataForPage = [];
        $pages = [];

        foreach ($rows as $v) {
            $i++;
            $dataForPage[] = [
                'title'=>$v['title'],
                'author'=> $v['author'],
               'content'=> $v['content']
            ];

            if (gmp_mod($i, 5) == 0)//каждый 5ый элемент - новая страница данных
            {
                $counter++;
                $page = new stdClass();
                $page->index = $counter;
                $page->rows = $dataForPage;
                $dataForPage = [];
                $pages[$page->index] = $page;
            }
        }
        self::$dataRows = $pages;
        self::$numberOfPages =ceil(count($pages));
        return $pages;
    }

    public static function getNumberOfPages()
    {
        return self::$numberOfPages;
    }


}