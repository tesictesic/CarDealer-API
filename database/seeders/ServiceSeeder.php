<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            "service_packet_id"=>1,
            "name"=>"Diagnostic",
            "description"=>"Diagnostic procedures involve the use of specialized tools and equipment to assess the performance and health of various vehicle systems",
            "icon"=>"assets/images/ikonice/diagnostika.png",
            "price"=>50.00
        ]);
        Service::create([
            "service_packet_id"=>2,
            "name"=>"Filters",
            "description"=>"Filters play a crucial role in maintaining the cleanliness of fluids and air circulating within the vehicle.",
            "icon"=>"assets/images/ikonice/filteri.png",
            "price"=>100.00
        ]);
        Service::create([
            "service_packet_id"=>1,
            "name"=>"Exhaust gas inspection/emission testing",
            "description"=>"Exhaust gas inspection, also known as emission testing, assesses the pollutants released by a vehicle's exhaust system",
            "icon"=>"assets/images/ikonice/kontrola_izduvnih_gasova.png",
            "price"=>45.00
        ]);
        Service::create([
            "service_packet_id"=>2,
            "name"=>"Front/Rear brake pads",
            "description"=>"Front/Rear brake pads are vital components of a vehicle's braking system, providing the necessary friction to slow down or stop the vehicle.",
            "icon"=>"assets/images/ikonice/prednje_zadnje_kocione_plocice.png",
            "price"=>85.00
        ]);
        Service::create([
            "service_packet_id"=>2,
            "name"=>"Vehicle inspection",
            "description"=>"Vehicle inspection involves a comprehensive assessment of a vehicle's overall condition, including its safety, performance, and compliance with regulatory standards",
            "icon"=>"assets/images/ikonice/pregled_vozila.png",
            "price"=>100.00
        ]);
        Service::create([
            "service_packet_id"=>1,
            "name"=>"Pre-warranty expiration check",
            "description"=>"Pre-warranty expiration Qchecks involve a thorough examination of a vehicle's components and systems before the warranty period concludes",
            "icon"=>"assets/images/ikonice/provera_pred_istek_generacije.png",
            "price"=>15.00
        ]);
        Service::create([
            "service_packet_id"=>1,
            "name"=>"Wheels",
            "description"=>"Wheels are the circular components that support the vehicle and are connected to the axles.",
            "icon"=>"assets/images/ikonice/tockovi.png",
            "price"=>100.00
        ]);
        Service::create([
            "service_packet_id"=>2,
            "name"=>"Spark plugs",
            "description"=>" Spark plugs are integral to the ignition system, generating the spark needed to ignite the air-fuel mixture in the engine cylinders",
            "icon"=>"assets/images/ikonice/svecice.png",
            "price"=>15.00
        ]);
        Service::create([
            "service_packet_id"=>1,
            "name"=>"Transmission fluid",
            "description"=>"Diagnostic procedures involve the use of specialized tools and equipment to assess the performance and health of various vehicle systems",
            "icon"=>"assets/images/ikonice/ulje_u_menjacu.png",
            "price"=>145.00
        ]);
        Service::create([
            "service_packet_id"=>2,
            "name"=>"Oil service",
            "description"=>"Transmission fluid, often referred to as gearbox oil, is a lubricant that facilitates smooth operation and cooling of the vehicle's transmission.",
            "icon"=>"assets/images/ikonice/uljni_servis.png",
            "price"=>45.00
        ]);
    }
}
