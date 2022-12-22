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
                "name"=>"Open Water Diver",
                "code"=>"OWD",
                'cost'=>50.50,
                "price"=>350

            ],
            [
                "name"=>"Advanced Open Water Diver",
                "code"=>"AOWD",
                'cost'=>50.50,
                "price"=>200
            ]
        ];
        $certifications = [
            [
                "name"=>"Advanced Adventurer",
                "code"=>"AA",
                'cost'=>43.80,
                "price"=>250.00
            ],
            [
                "name"=>"Wreck Diving",
                "code"=>"WD",
                'cost'=>43.80,
                "price"=>215.00
            ],
            [
                "name"=>"Basic Diver",
                "code"=>"BD",
                'cost'=>5.49,
                "price"=>200.00
            ],
            [
                "name"=>"Scuba Diver",
                "code"=>"SD",
                'cost'=>32.82,
                "price"=>270.00
            ],
            [
                "name"=>"Open Water Diver",
                "code"=>"OWD",
                'cost'=>57.22,
                "price"=>370.00
            ],
            [
                "name"=>"Coral Identification",
                "code"=>"CI",
                'cost'=>43.8,
                "price"=>175.00
            ],
            [
                "name"=>"Decompression Diving",
                "code"=>"DD",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Deep Diving",
                "code"=>"DDS",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Dry Suit Diving",
                "code"=>"DSD",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Enriched Air Nitrox",
                "code"=>"EAN",
                'cost'=>43.80,
                "price"=>175.00
            ],
[
                "name"=>"Equipment Techniques",
                "code"=>"EAN",
                'cost'=>43.80,
                "price"=>135.00
            ],
[
                "name"=>"Fish Identification",
                "code"=>"FI",
                'cost'=>36.48,
                "price"=>135.00
            ],
[
                "name"=>"Marine Ecology",
                "code"=>"ME",
                'cost'=>36.48,
                "price"=>135.00
            ],
[
                "name"=>"Navigation",
                "code"=>"NAV",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Night Diving and Limited Visibility",
                "code"=>"NLV",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Science Of Diving",
                "code"=>"SOD",
                'cost'=>36.48,
                "price"=>135.00
            ],
[
                "name"=>"Scooter / DPV",
                "code"=>"DPV",
                'cost'=>20.62,
                "price"=>215.00
            ],
[
                "name"=>"Scuba Skills Update",
                "code"=>"SSU",
                'cost'=>12.08,
                "price"=>80.00
            ],
[
                "name"=>"Search & Recovery",
                "code"=>"SR",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Stress & Rescue",
                "code"=>"DSR",
                'cost'=>43.80,
                "price"=>420.00
            ],
[
                "name"=>"Try Scuba",
                "code"=>"TS",
                'cost'=>0.00,
                "price"=>50.00
            ],
[
                "name"=>"Waves, Tides & Currents",
                "code"=>"WTC",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Wreck Diving",
                "code"=>"WD",
                'cost'=>43.80,
                "price"=>215.00
            ],
[
                "name"=>"Gas Blender Nitrox/Trimix",
                "code"=>"GB",
                'cost'=>43.80,
                "price"=>175.00
            ],
[
                "name"=>"Indipendent Diving",
                "code"=>"ID",
                'cost'=>43.80,
                "price"=>175.00
            ],
[
                "name"=>"Dive Guide ",
                "code"=>"DG",
                'cost'=>110.90,
                "price"=>500.00
            ],
[
                "name"=>"Extended Range Foundations",
                "code"=>"ERF",
                'cost'=>20.62,
                "price"=>300.00
            ],
[
                "name"=>"Extended Range Nitrox Diving",
                "code"=>"ERN",
                'cost'=>43.80,
                "price"=>470.00
            ],
[
                "name"=>"Extended Range",
                "code"=>"ER",
                'cost'=>57.22,
                "price"=>500.00
            ],
[
                "name"=>"Technical Extended Range",
                "code"=>"TER",
                'cost'=>57.22,
                "price"=>500.00
            ],
[
                "name"=>"Hypoxic Trimix (100m)",
                "code"=>"HER",
                'cost'=>57.22,
                "price"=>550.00
            ],
[
                "name"=>"Extended Range Wreck Diving",
                "code"=>"HER",
                'cost'=>57.22,
                "price"=>470.00
            ],
[
                "name"=>"Technical Wreck Diving",
                "code"=>"TWD",
                'cost'=>57.22,
                "price"=>470.00
            ],
[
                "name"=>"Snorkel Diver",
                "code"=>"SND",
                'cost'=>0.00,
                "price"=>40.00
            ],
[
                "name"=>"Try Freediving",
                "code"=>"TF",
                'cost'=>0.00,
                "price"=>0.00
            ],
[
                "name"=>"Basic Freediving",
                "code"=>"BF",
                'cost'=>23.06,
                "price"=>150.00
            ],
[
                "name"=>"Try Mermaid",
                "code"=>"TM",
                'cost'=>0.00,
                "price"=>0.00
            ],
[
                "name"=>"Mermaid",
                "code"=>"MR",
                'cost'=>35.26,
                "price"=>180.00
            ],
[
                "name"=>"React Right - Course Combination (FA, CPR, AED, O2)",
                "code"=>"BLS",
                'cost'=>35.00,
                "price"=>200.00
            ],
        ];

        foreach($certifications as $certification) {
            Certification::create($certification);
        }
    }
}
