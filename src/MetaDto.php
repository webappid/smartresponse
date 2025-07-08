<?php

namespace WebAppId\SmartResponse;

class MetaDto
{
    /**
     * Current page number
     */
    public int $page = 1;

    /**
     * Items per page
     */
    public int $perPage = 10;

    /**
     * Last page number
     */
    public int $lastPage = 1;

    /**
     * Convert MetaDto to array
     */
    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'perPage' => $this->perPage,
            'lastPage' => $this->lastPage,
        ];
    }
}
