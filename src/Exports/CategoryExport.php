<?php

namespace ManaCMS\ManaCategories\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use ManaCMS\ManaCategories\Models\Category;

class CategoryExport implements FromQuery, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'id',	'level',	'parent', 'title',	'slug',	'description',
        ];
    }

    public function query()
    {
        return Category::query();
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->level,
            $category->parent_id,
            $category->title,
            $category->slug,
            $category->desc,
        ];
    }
}
