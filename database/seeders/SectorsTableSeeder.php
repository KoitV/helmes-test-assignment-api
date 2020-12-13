<?php

namespace Database\Seeders;

use App\Entities\Sector;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;

class SectorsTableSeeder extends Seeder
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            [
                'name' => 'Manufacturing',
                'children' => [
                    ['name' => 'Construction materials'],
                    ['name' => 'Electronics and Optics'],
                    [
                        'name' => 'Food and Beverage',
                        'children' => [
                            ['name' => 'Bakery & confectionery products'],
                            ['name' => 'Beverages'],
                            ['name' => 'Fish & fish products'],
                            ['name' => 'Meat & meat products'],
                            ['name' => 'Milk & dairy products'],
                            ['name' => 'Other'],
                            ['name' => 'Sweets & snack food'],
                        ]
                    ],
                    [
                        'name' => 'Furniture',
                        'children' => [
                            ['name' => 'Bathroom/sauna'],
                            ['name' => 'Bedroom'],
                            ['name' => 'Children’s room'],
                            ['name' => 'Kitchen'],
                            ['name' => 'Living room'],
                            ['name' => 'Office'],
                            ['name' => 'Outdoor'],
                            ['name' => 'Project furniture'],
                            ['name' => 'Other (Furniture)']
                    ]
                    ],
                    [
                        'name' => 'Machinery',
                        'children' => [
                            ['name' => 'Machinery components'],
                            ['name' => 'Machinery equipment/tools'],
                            ['name' => 'Manufacture of machinery'],
                            [
                                'name' => 'Maritime',
                                'children' => [
                                    ['name' => 'Aluminium and steel workboats'],
                                    ['name' => 'Boat/Yacht building'],
                                    ['name' => 'Ship repair and conversion'],
                                ]
                            ],
                            ['name' => 'Metal structures'],
                            ['name' => 'Repair and maintenance service'],
                            ['name' => 'Other']
                        ]
                    ],
                    [
                        'name' => 'Metalworking',
                        'children' => [
                            ['name' => 'Construction of metal structures'],
                            ['name' => 'Houses and buildings'],
                            ['name' => 'Metal products'],
                            [
                                'name' => 'Metal works',
                                'children' => [
                                    ['name' => 'CNC-machining'],
                                    ['name' => 'Forgings, Fasteners'],
                                    ['name' => 'Gas, Plasma, Laser cutting'],
                                    ['name' => 'MIG, TIG, Aluminum welding'],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Plastic and Rubber',
                        'children' => [
                            ['name' => 'Packaging'],
                            ['name' => 'Plastic goods'],
                            [
                                'name' => 'Plastic processing technology',
                                'children' => [
                                    ['name' => 'Blowing'],
                                    ['name' => 'Moulding'],
                                    ['name' => 'Plastics welding and processing'],
                                ]
                            ]
                        ]
                    ],
                    [
                        'name' => 'Printing',
                        'children' => [
                            ['name' => 'Advertising'],
                            ['name' => 'Book/Periodicals printing'],
                            ['name' => 'Labelling and packaging printing'],
                        ]
                    ],
                    [
                        'name' => 'Textile and Clothing',
                        'children' => [
                            ['name' => 'Clothing'],
                            ['name' => 'Textile'],
                        ]
                    ],
                    [
                        'name' => 'Wood',
                        'children' => [
                            ['name' => 'Wooden building materials'],
                            ['name' => 'Wooden houses'],
                            ['name' => 'Other (Wood)'],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Other',
                'children' => [
                    ['name' => 'Creative industries'],
                    ['name' => 'Energy technology'],
                    ['name' => 'Environment'],
                ]
            ],
            [
                'name' => 'Service',
                'children' => [
                    ['name' => 'Business services'],
                    ['name' => 'Engineering'],
                    [
                        'name' => 'Information Technology and Telecommunications',
                        'children' => [
                            ['name' => 'Data processing, Web portals, E-marketing'],
                            ['name' => 'Programming, Consultancy'],
                            ['name' => 'Software, Hardware'],
                            ['name' => 'Telecommunications'],
                        ]
                    ],
                    ['name' => 'Tourism'],
                    ['name' => 'Translation services'],
                    [
                        'name' => 'Transport and Logistics',
                        'children' => [
                            ['name' => 'Air'],
                            ['name' => 'Rail'],
                            ['name' => 'Road'],
                            ['name' => 'Water'],
                        ]
                    ]
                ]
            ]
        ];

        foreach($sectors as $sector)
            $this->createSector($sector);

        $this->entityManager->flush();
    }

    private function createSector(array $data, Sector $parent = null)
    {
        $sector = new Sector();
        $sector->setName($data['name']);

        if($parent !== null)
            $sector->setParent($parent);

        $this->entityManager->persist($sector);

        if(isset($data['children']))
        {
            foreach($data['children'] as $child)
                $this->createSector($child, $sector);
        }
    }
}
