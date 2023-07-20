<?php declare(strict_types=1);

namespace App\Core\Response;

class JsonResponse implements Response
{
    private array $data;

    public function __construct(array $data){
        $this->data = $data;
    }

    public function getJson()
    {
        return json_encode($this->data);
    }

}