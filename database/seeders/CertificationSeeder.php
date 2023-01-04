<?php

namespace Database\Seeders;

use App\Models\Certification;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $certifications = [
            [
                "name"             => "Advanced Adventurer",
                "code"             => "AA",
                'cost'             => 43.80,
                "price"            => 250.00,
                "discounted_price" => 210.00
            ],
            [
                "name"             => "Wreck Diving",
                "code"             => "WD",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Basic Diver",
                "code"             => "BD",
                'cost'             => 5.49,
                "price"            => 200.00,
                "discounted_price" => 150.00
            ],
            [
                "name"             => "Scuba Diver",
                "code"             => "SD",
                'cost'             => 32.82,
                "price"            => 270.00,
                "discounted_price" => 200.00
            ],
            [
                "name"             => "Open Water Diver",
                "code"             => "OWD",
                'cost'             => 57.22,
                "price"            => 370.00,
                "discounted_price" => 330.00,
                "activities" => [
                    [
                        'label' => 'CW',
                        'order' => 1,
                        'values' => [
                            [
                                'order' => 1,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione - Snorkeling",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Assemblaggio e regolazione del Sistema Totale per snorkeling"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua - Snorkeling",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Valutazione dell'acquaticità"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Entrata con passo del gigante | Snorkeling",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Regolazione dell'assetto e della zavorra",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Controllo dell'assetto | Sistema Totale per Snorkeling",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Svuotamento dello snorkel e della maschera",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Pinneggiata alternata a pinne estese | In superficie",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Assetto positivo in superficie",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Tecniche di compensazione",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Capovolta a testa in giù",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Tecniche di pinneggiamento con lo snorkel | In immersione",
                                            ],
                                            [
                                                "order" => 11,
                                                "label" =>
                                                "Ritorno in superficie",
                                            ],
                                            [
                                                "order" => 12,
                                                "label" =>
                                                "Uscita dall'acqua alta",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione - Snorkeling",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Cura dell'attrezzatura | Snorkeling"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione - Snorkeling",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 2,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Assemblaggio dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Vestizione dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Check pre-immersione",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Entrata controllata da seduti",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Controllo dell'assetto | Sistema Totale d'Immersione",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Respirazione dall'erogatore",
                                            ],
                                            [
                                                "order" => 4,
                                                "label"
                                                => "Svuotamento dell'erogatore - Metodo dell'espirazione forzata",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Svuotamento dell'erogatore - Metodo del bottone di spurgo",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Recupero dell'erogatore - Circonduzione del braccio",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Recupero dell'erogatore - Metodo della fonte d'aria alternativa",
                                            ],

                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Svuotamento della maschera - Allagamento parziale",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Svuotamento della maschera - Allagamento totale",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                            ],
                                            [
                                                "order" => 11,
                                                "label" =>
                                                "Uscita",
                                            ],


                                        ]

                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Cura dell'attrezzatura"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 3,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Assemblaggio dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Vestizione dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Check pre-immersione",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Entrata con passo del gigante | Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Discesa controllata",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Rimozione e Riposizionamento della Maschera",
                                            ],
                                            [
                                                "order" => 4,
                                                "label"
                                                => "Condivisione dell'aria sul posto - Passando l’erogatore primario",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Condivisione dell'aria sul posto - Uso della fonte d'aria alternativa",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Assetto Neutro | Posizione d'immersione - Gonfiaggio con VIS",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Assetto Neutro | Posizione d'immersione - Gonfiaggio a bocca",
                                            ],

                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Tecniche di pinneggiamento | Scuba",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Risalita controllata",
                                            ],
                                            [
                                                "order" => 11,
                                                "label" =>
                                                "Uscita in acqua alta",
                                            ],
                                        ]

                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Cura dell'attrezzatura | Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 4,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Assemblaggio dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Vestizione dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Check pre-immersione",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Entrata con passo del gigante | Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Rimozione e riposizionamento della zavorra | In superficie",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Discesa controllata",
                                            ],
                                            [
                                                "order" => 4,
                                                "label"
                                                => "Rimozione e riposizionamento della zavorra | In immersione",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Rimozione e Riposizionamento della Maschera",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Assetto Neutro | Posizione d'immersione",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Condivisione dell'aria in risalita",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Risalita controllata",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]

                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Cura dell'attrezzatura | Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 5,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Assemblaggio dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Vestizione dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Check pre-immersione",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Entrata per rovesciamento all’indietro",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Discesa controllata",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Rimozione e riposizionamento dell'unità Scuba | In immersione",
                                            ],
                                            [
                                                "order" => 4,
                                                "label"
                                                => "Assetto Neutro | Assetto neutro, in orizzontale",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Nuoto senza maschera",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Risalita di emergenza nuotando",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Rimozione e riposizionamento dell'unità Scuba | In superficie",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]

                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Cura dell'attrezzatura | Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 6,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Assemblaggio dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Vestizione dell'unità Scuba",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Check pre-immersione",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>
                                                "Entrata",
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Disconnessione/riconnessione della frusta del VIS",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>
                                                "Respirazione da un erogatore in erogazione continua",
                                            ],
                                            [
                                                "order" => 4,
                                                "label"
                                                => "Sosta di sicurezza",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Risalita di emergenza in assetto (REA)",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Lancio in immersione di un segnalatore di superficie | In superficie",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Esercizi di soccorso - Avvicinamento",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Esercizi di soccorso - Rimozione di un crampo",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Esercizi di soccorso - Traino dalla rubinetteria",
                                            ],
                                            [
                                                "order" => 11,
                                                "label" =>
                                                "Esercizi di soccorso - Traino dal fianco",
                                            ],
                                            [
                                                "order" => 12,
                                                "label" =>
                                                "Esercizi di soccorso - Spinta dalle pinne",
                                            ],
                                            [
                                                "order" => 13,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]

                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Cura dell'attrezzatura | Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => 'OW',
                        'order' => 2,
                        'values' => [
                            [
                                'order' => 1,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Briefing e ripasso dei segnali manuali"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" => "Assemblaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 3,
                                                "label" => "Vestizione dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Check pre-immersione"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua libera",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Entrata controllata da seduti"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Controllo dell'assetto | Sistema Totale d'Immersione",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Discesa controllata",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Assetto Neutro | Posizione d'immersione",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Recupero dell'erogtore - Circonduzione del braccio",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Recupero dell'erogtore - Metodo della fonte d'aria alternativa",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Svuotamento della maschera - Allagamento parziale",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Svuotamento della maschera - Allagamento totale",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Risalita controllata",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Sosta di sicurezza",
                                            ],
                                            [
                                                "order" => 11,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Debriefing",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 2,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Briefing e ripasso dei segnali manuali"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" => "Assemblaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 3,
                                                "label" => "Vestizione dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Check pre-immersione"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua libera",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Entrata per rovesciamento"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Discesa controllata",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Assetto Neutro | Posizione d'immersione",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Rimozione e Riposizionamento della Maschera",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Condivisione dell'aria sul posto",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Risalita controllata",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Sosta di sicurezza",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Passaggio da snorkel a erogatore e viceversa",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Nuoto in superficie",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Debriefing",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 3,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Briefing e ripasso dei segnali manuali"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" => "Assemblaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 3,
                                                "label" => "Vestizione dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Check pre-immersione"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua libera",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Entrata con passo del gigante | Scuba"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Discesa controllata",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Assetto Neutro | Posizione d'immersione",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Rimozione e Riposizionamento della Maschera",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Condivisione dell'aria in risalita",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Rimozione e riposizionamento della zavorra | In superficie",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi facoltativi in acqua libera",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Nuoto senza maschera"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Debriefing",
                                        "order" => 5,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 4,
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Briefing e ripasso dei segnali manuali"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" => "Assemblaggio dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 3,
                                                "label" => "Vestizione dell'unità Scuba"
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Check pre-immersione"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua libera",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Entrata"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Discesa in libera",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Assetto Neutro | Posizione d'immersione",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" => "Rotta reciproca con la bussola",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Risalita controllata",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Sosta di sicurezza",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Rimozione e riposizionamento dell'unità Scuba | In superficie",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Lancio in immersione di un segnalatore di superficie | In superficie",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Uscita",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi facoltativi in acqua libera",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Controllo del consumo di gas"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Risalita di emergenza nuotando"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Debriefing",
                                        "order" => 5,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'order' => 5,
                                'label' => "Esercizi Snorkeling | Esercizi Scuba di soccorso",
                                'values' => [
                                    [
                                        "label" => "Esercizi prima dell'immersione",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" => "Vestizione del Sistema Totale d’Immersione"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" => "Regolazione dell'assetto e della zavorra"
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi in acqua libera",
                                        "order" => 2,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Svuotamento dello snorkel e della maschera"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>  "Ritrovamento e sgancio della zavorra",
                                            ],
                                            [
                                                "order" => 3,
                                                "label" =>   "Assetto positivo in superficie",
                                            ],
                                            [
                                                "order" => 4,
                                                "label" =>
                                                "Esercizi di soccorso - Avvicinamento",
                                            ],
                                            [
                                                "order" => 5,
                                                "label" =>
                                                "Esercizi di soccorso - Rimozione di un crampo",
                                            ],
                                            [
                                                "order" => 6,
                                                "label" =>
                                                "Esercizi di soccorso - Traino dalla rubinetteria",
                                            ],
                                            [
                                                "order" => 7,
                                                "label" =>
                                                "Esercizi di soccorso - Traino dal fianco",
                                            ],
                                            [
                                                "order" => 8,
                                                "label" =>
                                                "Esercizi di soccorso - Spinta dalle pinne",
                                            ],
                                            [
                                                "order" => 9,
                                                "label" =>
                                                "Ritorno in superficie",
                                            ],
                                            [
                                                "order" => 10,
                                                "label" =>
                                                "Uscita dall'acqua alta",
                                            ],
                                        ]
                                    ],
                                    [
                                        "label" => "Esercizi dopo l'immersione",
                                        "order" => 3,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Smontaggio dell'unità Scuba"
                                            ]
                                        ]
                                    ],
                                    [
                                        "label" => "Debriefing",
                                        "order" => 4,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                "label" =>  "Debriefing"
                                            ],
                                            [
                                                "order" => 2,
                                                "label" =>
                                                "Registrare e convalidare immersione su Logbook App SSI",
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => 'THEORY',
                        'order' => 3,
                        'values' => [
                            [
                                'label' => 'Ripassi delle conoscenze',
                                'order' => 1,
                                'values' => [
                                    [
                                        "label" => "",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                'label' => 'Ripassi delle conoscenze',
                                            ]

                                        ]
                                    ]
                                ],
                            ],
                            [
                                'label' => 'Esame',
                                'order' => 1,
                                'values' => [
                                    [
                                        "label" => "",
                                        "order" => 1,
                                        "values" => [
                                            [
                                                "order" => 1,
                                                'label' => 'Esame',
                                            ]

                                        ]
                                    ]
                                ],
                            ],
                        ]
                    ]
                ],

                "activities_old" => [
                    "CW" => [

                        2 => [
                            "Esercizi prima dell'immersione" => [
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata controllata da seduti",
                                "Controllo dell'assetto | Sistema Totale d'Immersione",
                                "Respirazione dall'erogatore",
                                "Svuotamento dell'erogatore - Metodo dell'espirazione forzata",
                                "Svuotamento dell'erogatore - Metodo del bottone di spurgo",
                                "Recupero dell'erogatore - Circonduzione del braccio",
                                "Recupero dell'erogatore - Metodo della fonte d'aria alternativa",
                                "Svuotamento della maschera - Allagamento parziale",
                                "Svuotamento della maschera - Allagamento totale",
                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                                "Cura dell'attrezzatura Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        3 => [
                            "Esercizi prima dell'immersione" => [
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata con passo del gigante Scuba",
                                "Discesa controllata",
                                "Rimozione e Riposizionamento della Maschera",
                                "Condivisione dell'aria sul posto - Passando l’erogatore primario",
                                "Condivisione dell'aria sul posto - Uso della fonte d'aria alternativa",
                                "Assetto Neutro in Posizione d'immersione - Gonfiaggio con VIS",
                                "Assetto Neutro in Posizione d'immersione - Gonfiaggio a bocca",
                                "Tecniche di pinneggiamento Scuba",
                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                "Risalita controllata",
                                "Uscita in acqua alta",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                                "Cura dell'attrezzatura Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        4 => [
                            "Esercizi prima dell'immersione" => [
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata con passo del gigante Scuba",
                                "Rimozione e riposizionamento della zavorra In superficie",
                                "Discesa controllata",
                                "Rimozione e riposizionamento della zavorra In immersione",
                                "Rimozione e Riposizionamento della Maschera",
                                "Assetto Neutro in Posizione d'immersione",
                                "Condivisione dell'aria in risalita",
                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                "Risalita controllata",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                                "Cura dell'attrezzatura Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        5 => [
                            "Esercizi prima dell'immersione" => [
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata per rovesciamento all’indietro",
                                "Discesa controllata",
                                "Rimozione e riposizionamento dell'unità Scuba In immersione",
                                "Assetto Neutro | Assetto neutro, in orizzontale",
                                "Nuoto senza maschera",
                                "Risalita di emergenza nuotando",
                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                "Rimozione e riposizionamento dell'unità Scuba In superficie",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                                "Cura dell'attrezzatura Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        6 => [
                            "Esercizi prima dell'immersione" => [
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata",
                                "Disconnessione - riconnessione della frusta del VIS",
                                "Respirazione da un erogatore in erogazione continua",
                                "Sosta di sicurezza",
                                "Risalita di emergenza in assetto (REA)",
                                "Ripasso degli esercizi e tempo di pratica con supervisione",
                                "Lancio in immersione di un segnalatore di superficie | In superficie",
                                "Esercizi di soccorso – Avvicinamento",
                                "Esercizi di soccorso – Rimozione di un crampo",
                                "Esercizi di soccorso – Traino dalla rubinetteria",
                                "Esercizi di soccorso – Traino dal fianco",
                                "Esercizi di soccorso – Spinta dalle pinne",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                                "Cura dell'attrezzatura Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],

                    ],
                    "OW" => [
                        1 => [
                            "Esercizi Snorkeling/Scuba di soccorso prima dell'immersione" => [
                                "Vestizione del Sistema Totale d’Immersione",
                                "Regolazione dell'assetto e della zavorra"
                            ],
                            "Esercizi Snorkeling/Scuba di soccorso in acqua" => [
                                "Svuotamento dello snorkel e della maschera",
                                "Ritrovamento e sgancio della zavorra",
                                "Assetto positivo in superficie",
                                "Esercizi di soccorso – Avvicinamento",
                                "Esercizi di soccorso – Rimozione di un crampo",
                                "Esercizi di soccorso – Traino dalla rubinetteria",
                                "Esercizi di soccorso – Traino dal fianco",
                                "Esercizi di soccorso – Spinta dalle pinne",
                                "Ritorno in superficie",
                                "Uscita dall'acqua alta",
                            ],
                            "Esercizi Snorkeling/Scuba di soccorso dopo l'immersione" => [
                                "Cura dell'attrezzatura Snorkeling - Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],

                        2 => [
                            "Esercizi prima dell'immersione" => [
                                "Briefing e ripasso dei segnali manuali",
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata controllata da seduti",
                                "Controllo dell'assetto Sistema Totale d'Immersione",
                                "Discesa controllata",
                                "Assetto Neutro Posizione d'immersione",
                                "Recupero dell'erogatore - Circonduzione del braccio",
                                "Recupero dell'erogatore - Metodo della fonte d'aria alternativa",
                                "Svuotamento della maschera - Allagamento parziale",
                                "Svuotamento della maschera - Allagamento totale",
                                "Risalita controllata",
                                "Sosta di sicurezza",
                                "Uscita"
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell’unità scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        3 => [
                            "Esercizi prima dell'immersione" => [
                                "Briefing e ripasso dei segnali manuali",
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata per rovesciamento",
                                "Discesa controllata",
                                "Assetto Neutro Posizione d'immersione",
                                "Rimozione e Riposizionamento della Maschera",
                                "Condivisione dell'aria sul posto",
                                "Risalita controllata",
                                "Sosta di sicurezza",
                                "Passaggio da snorkel a erogatore e viceversa",
                                "Nuoto in superficie",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        4 => [
                            "Esercizi prima dell'immersione" => [
                                "Briefing e ripasso dei segnali manuali",
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata con passo del gigante Scuba",
                                "Discesa controllata",
                                "Assetto Neutro Posizione d'immersione",
                                "Rimozione e riposizionamento della maschera",
                                "Condivisione dell'aria in risalita",
                                "Rimozione e riposizionamento della zavorra In superficie",
                                "Uscita",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                        5 => [
                            "Esercizi prima dell'immersione" => [
                                "Briefing e ripasso dei segnali manuali",
                                "Assemblaggio dell'unità Scuba",
                                "Vestizione dell'unità Scuba",
                                "Check pre-immersione",
                            ],
                            "Esercizi in acqua" => [
                                "Entrata",
                                "Discesa in libera",
                                "Assetto Neutro Posizione d'immersione",
                                "Rotta reciproca con la bussola",
                                "Risalita controllata",
                                "Sosta di sicurezza",
                                "Rimozione e riposizionamento dell'unità Scuba In superficie",
                                "Lancio in immersione di un segnalatore di superficie In superficie",
                                "Uscita",
                            ],
                            "Esercizi facoltativi in acqua" => [
                                "Controllo del consumo di gas",
                                "Risalita di emergenza nuotando",
                            ],
                            "Esercizi dopo l'immersione" => [
                                "Smontaggio dell'unità Scuba",
                            ],
                            "Debriefing e registrazioni" => [
                                "Debriefing",
                                "Registrare e convalidare immersione su Logbook App SSI",
                            ]
                        ],
                    ],
                    "THEORY" => [
                        1 => [
                            "RC_1",
                        ],
                        2 => [
                            "EXAM",
                        ]
                    ]
                ]
            ],
            [
                "name"             => "Coral Identification",
                "code"             => "CI",
                'cost'             => 43.8,
                "price"            => 175.00,
                "discounted_price" => 100.00
            ],
            [
                "name"             => "Decompression Diving",
                "code"             => "DD",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Deep Diving",
                "code"             => "DDS",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Dry Suit Diving",
                "code"             => "DSD",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Enriched Air Nitrox",
                "code"             => "EAN",
                'cost'             => 43.80,
                "price"            => 175.00,
                "discounted_price" => 130.00
            ],
            [
                "name"             => "Equipment Techniques",
                "code"             => "ET",
                'cost'             => 43.80,
                "price"            => 135.00,
                "discounted_price" => 100.00
            ],
            [
                "name"             => "Fish Identification",
                "code"             => "FI",
                'cost'             => 36.48,
                "price"            => 135.00,
                "discounted_price" => 100.00
            ],
            [
                "name"             => "Marine Ecology",
                "code"             => "ME",
                'cost'             => 36.48,
                "price"            => 135.00,
                "discounted_price" => 100.00
            ],
            [
                "name"             => "Navigation",
                "code"             => "NAV",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Night Diving and Limited Visibility",
                "code"             => "NLV",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Science Of Diving",
                "code"             => "SOD",
                'cost'             => 36.48,
                "price"            => 135.00,
                "discounted_price" => 135.00
            ],
            [
                "name"             => "Scooter / DPV",
                "code"             => "DPV",
                'cost'             => 20.62,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Scuba Skills Update",
                "code"             => "SSU",
                'cost'             => 12.08,
                "price"            => 80.00,
                "discounted_price" => 60.00
            ],
            [
                "name"             => "Search & Recovery",
                "code"             => "SR",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Stress & Rescue",
                "code"             => "DSR",
                'cost'             => 43.80,
                "price"            => 420.00,
                "discounted_price" => 350.00
            ],
            [
                "name"             => "Try Scuba",
                "code"             => "TS",
                'cost'             => 0.00,
                "price"            => 50.00,
                "discounted_price" => 0.00
            ],
            [
                "name"             => "Waves, Tides & Currents",
                "code"             => "WTC",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Wreck Diving",
                "code"             => "WD",
                'cost'             => 43.80,
                "price"            => 215.00,
                "discounted_price" => 160.00
            ],
            [
                "name"             => "Gas Blender Nitrox/Trimix",
                "code"             => "GB",
                'cost'             => 43.80,
                "price"            => 175.00,
                "discounted_price" => 130.00
            ],
            [
                "name"             => "Indipendent Diving",
                "code"             => "ID",
                'cost'             => 43.80,
                "price"            => 175.00,
                "discounted_price" => 130.00
            ],
            [
                "name"             => "Dive Guide ",
                "code"             => "DG",
                'cost'             => 110.90,
                "price"            => 500.00,
                "discounted_price" => 400.00
            ],
            [
                "name"             => "Extended Range Foundations",
                "code"             => "ERF",
                'cost'             => 20.62,
                "price"            => 300.00,
                "discounted_price" => 250.00
            ],
            [
                "name"             => "Extended Range Nitrox Diving",
                "code"             => "ERN",
                'cost'             => 43.80,
                "price"            => 470.00,
                "discounted_price" => 3560.00
            ],
            [
                "name"             => "Extended Range",
                "code"             => "ER",
                'cost'             => 57.22,
                "price"            => 500.00,
                "discounted_price" => 380.00
            ],
            [
                "name"             => "Technical Extended Range",
                "code"             => "TER",
                'cost'             => 57.22,
                "price"            => 500.00,
                "discounted_price" => 380.00
            ],
            [
                "name"             => "Hypoxic Trimix (100m)",
                "code"             => "HER",
                'cost'             => 57.22,
                "price"            => 550.00,
                "discounted_price" => 400.00
            ],
            [
                "name"             => "Extended Range Wreck Diving",
                "code"             => "HER",
                'cost'             => 57.22,
                "price"            => 470.00,
                "discounted_price" => 350.00
            ],
            [
                "name"             => "Technical Wreck Diving",
                "code"             => "TWD",
                'cost'             => 57.22,
                "price"            => 470.00,
                "discounted_price" => 350.00
            ],
            [
                "name"             => "Snorkel Diver",
                "code"             => "SND",
                'cost'             => 0.00,
                "price"            => 50.00,
                "discounted_price" => 40.00
            ],
            [
                "name"             => "Try Freediving",
                "code"             => "TF",
                'cost'             => 0.00,
                "price"            => 50.00,
                "discounted_price" => 0.00
            ],
            [
                "name"             => "Basic Freediving",
                "code"             => "BF",
                'cost'             => 23.06,
                "price"            => 150.00,
                "discounted_price" => 120.00
            ],
            [
                "name"             => "Try Mermaid",
                "code"             => "TM",
                'cost'             => 0.00,
                "price"            => 50.00,
                "discounted_price" => 0.00
            ],
            [
                "name"             => "Mermaid",
                "code"             => "MR",
                'cost'             => 35.26,
                "price"            => 180.00,
                "discounted_price" => 150.00
            ],
            [
                "name"             => "React Right – FA + CPR",
                "code"             => "RR1",
                'cost'             => 42.70,
                "price"            => 200.00,
                "discounted_price" => 150.00
            ],
            [
                "name"             => "React Right – FA+CPR+AED",
                "code"             => "RR2",
                'cost'             => 42.700,
                "price"            => 280.00,
                "discounted_price" => 210.00
            ],
            [
                "name"             => "React Right – FA+CPR+AED+O2",
                "code"             => "RR3",
                'cost'             => 42.700,
                "price"            => 330.00,
                "discounted_price" => 250.00
            ],

        ];

        foreach ($certifications as $certification) {
            if (isset($certification['activities_old'])) unset($certification['activities_old']);
            Certification::create($certification);
        }
    }
}
