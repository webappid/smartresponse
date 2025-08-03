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
    public int $per_page = 10;

    /**
     * Last page number
     */
    public int $last_page = 1;

    /**
     * Convert MetaDto to array
     */
    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->per_page,
            'last_page' => $this->last_page,
        ];
    }
}
