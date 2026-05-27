<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NestableTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (nestedset: plain delete is fine)
        Category::truncate();
        Tag::truncate();

        // ── Categories ─────────────────────────────────────────────────────────

        Category::rebuildTree([
            [
                'title' => 'Electronics',
                'children' => [
                    [
                        'title' => 'Phones',
                        'children' => [
                            ['title' => 'Smartphones'],
                            ['title' => 'Flip Phones'],
                        ]
                    ],
                    [
                        'title' => 'Laptops',
                        'children' => [
                            ['title' => 'Gaming Laptops'],
                            ['title' => 'Ultrabooks'],
                        ]
                    ],
                    [
                        'title' => 'Accessories',
                        'children' => [
                            ['title' => 'Cables & Adapters'],
                            ['title' => 'Chargers'],
                        ]
                    ],
                ],
            ],
            [
                'title' => 'Clothing',
                'children' => [
                    [
                        'title' => "Men's Wear",
                        'children' => [
                            ['title' => 'Shirts'],
                            ['title' => 'Trousers'],
                        ]
                    ],
                    [
                        'title' => "Women's Wear",
                        'children' => [
                            ['title' => 'Dresses'],
                            ['title' => 'Tops'],
                        ]
                    ],
                    ['title' => "Kids' Wear"],
                ]
            ],
            [
                'title' => 'Home & Garden',
                'children' => [
                    [
                        'title' => 'Furniture',
                        'children' => [
                            ['title' => 'Sofas & Chairs'],
                            ['title' => 'Tables & Desks'],
                        ]
                    ],
                    [
                        'title' => 'Lighting',
                        'children' => [
                            ['title' => 'Floor Lamps'],
                            ['title' => 'Ceiling Lights'],
                        ],
                    ],
                    [
                        'title' => 'Garden Tools',
                    ],
                ],
            ]
        ]);

        $electronics = Category::firstWhere('title', 'Electronics');
        $clothing = Category::firstWhere('title', 'Clothing');
        $home = Category::firstWhere('title', 'Home & Garden');

        // ── Tags (partitioned by category_id for the cross-tree drag demo) ─────

        Tag::rebuildTree([
            [
                'name' => 'Technology', 'category_id' => $electronics->id,
                'children' => array_map(fn ($tag) => $tag + ['category_id' => $electronics->id], [
                    ['name' => 'Artificial Intelligence'],
                    ['name' => 'Cloud Computing'],
                    ['name' => 'Web Development'],
                ])
            ],
            [
                'name' => 'Science', 'category_id' => $clothing->id,
                'children' => array_map(fn ($tag) => $tag + ['category_id' => $clothing->id], [
                    ['name' => 'Physics'],
                    ['name' => 'Biology'],
                    ['name' => 'Chemistry'],
                ])
            ],
            [
                'name' => 'Arts & Culture', 'category_id' => $home->id,
                'children' => array_map(fn ($tag) => $tag + ['category_id' => $home->id], [
                    ['name' => 'Music'],
                    ['name' => 'Cinema'],
                    ['name' => 'Literature'],
                ])
            ],
        ]);
    }
}
