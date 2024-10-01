<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            "label" => 'Avant 35 TFSI',
            'horsepower' => 150,
            'seats' => 5,
            'description' => 'The Audi A4 Avant 35 TFSI is a stylish and versatile luxury estate car. With a powerful 35 TFSI engine, it delivers a blend of performance, comfort, and advanced technology, making it an ideal choice for those seeking a premium driving experience with ample cargo space.',
            'year' => 2022,
            'image' => 'audi_a4_avant_karavan.png',
            'brand_id' => 3,
            'car_body_id' => 2,
            'fuel_id' => 2,
            'color_id' => 1,
        ]);

        Vehicle::create([
            'label' => '2.0 TDI',
            'horsepower' => 170,
            'seats' => 5,
            'description' => 'The Audi A4 2.0 TDI combines elegant design, sophistication, and powerful performance. Equipped with a robust 2.0-liter diesel engine, this car delivers driving efficiency alongside impressive dynamics.',
            'year' => 2021,
            'image' => 'audi_a4-beli.png',
            'brand_id' => 3,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 5,
        ]);
        Vehicle::create([
            'label' => '50TDI',
            'horsepower' => 247,
            'seats' => 3,
            'description' => 'The Audi A5 Coupe is a sporty car that combines sophistication and dynamic design with outstanding performance. This luxury coupe features an elegant silhouette, distinctive lines, and an attractive overall design.',
            'year' => 2023,
            'image' => 'audi_a5_sedan.png',
            'brand_id' => 4,
            'car_body_id' => 4,
            'fuel_id' => 1,
            'color_id' => 8,
        ]);

        Vehicle::create([
            'label' => 'Sportback S-line',
            'horsepower' => 231,
            'seats' => 5,
            'description' => 'The Audi A5 Sportback S line combines the elegance of the A5 Sportback with sporty and dynamic enhancements from the S line package. It typically includes distinctive exterior design elements, such as a more aggressive front bumper, S line badging, side skirts, and a rear diffuser.',
            'year' => 2023,
            'image' => 'audi_a5_sportback_s_line.png',
            'brand_id' => 4,
            'car_body_id' => 4,
            'fuel_id' => 2,
            'color_id' => 5,
        ]);
        Vehicle::create([
            'label' => 'Avant e-tron',
            'horsepower' => 250,
            'seats' => 5,
            'description' => 'Audi A6 Avant e-tron, including specifications, features, and availability, I recommend checking Audis official website or contacting an authorized Audi dealership. They will have the latest details on the vehicle and its electric capabilities',
            'year' => 2023,
            'image' => 'audi_a6_avant_e_tron.png',
            'brand_id' => 5,
            'car_body_id' => 2,
            'fuel_id' => 3,
            'color_id' => 1,
        ]);

        Vehicle::create([
            'label' => '1.9TDI',
            'horsepower' => 140,
            'seats' => 5,
            'description' => 'The Audi A6 Estate combines the elegance and performance of the A6 sedan with the practicality and versatility of a wagon.It typically features a spacious and well-designed interior with advanced technology and high-quality materials.',
            'year' => 2020,
            'image' => 'audi_a6_karavan.png',
            'brand_id' => 5,
            'car_body_id' => 2,
            'fuel_id' => 1,
            'color_id' => 1,
        ]);
        Vehicle::create([
            'label' => 'R-line',
            'horsepower' => 310,
            'seats' => 5,
            'description' => 'If Audi has introduced an A7 R line Sedan since then, it would likely be a variant of the Audi A7 model featuring sportier design elements, both exterior and interior.',
            'year' => 2023,
            'image' => 'audi_a7_r_line2.png',
            'brand_id' => 6,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 4,
        ]);

        Vehicle::create([
            'label' => 'R-line LED',
            'horsepower' => 350,
            'seats' => 5,
            'description' => 'If Audi has introduced an A7 R line Sedan since then, it would likely be a variant of the Audi A7 model featuring sportier design elements, both exterior and interior. With LED',
            'year' => 2022,
            'image' => 'audi_a7_r_line3.png',
            'brand_id' => 6,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 3,
        ]);
        Vehicle::create([
            'label' => 'CSL',
            'horsepower' => 550,
            'seats' => 5,
            'description' => 'The BMW M3 CSL (Coupe Sport Leichtbau) is a high-performance variant of the BMW M3, known for its lightweight construction and enhanced driving dynamics.',
            'year' => 2024,
            'image' => 'bmw_m3_2024.png',
            'brand_id' => 8,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 6,
        ]);

        Vehicle::create([
            'label' => 'F80',
            'horsepower' => 450,
            'seats' => 5,
            'description' => 'he BMW M3 F80 refers to the fifth generation of the BMW M3, which was produced from 2014 to 2020. Here are some key features and characteristics of the BMW M3 F80',
            'year' => 2020,
            'image' => 'bmw_m3_f80.png',
            'brand_id' => 8,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 7,
        ]);
        Vehicle::create([
            'horsepower' => 320,
            'seats' => 5,
            'description' => 'The BMW 7 Series is a flagship luxury sedan that represents the pinnacle of BMWs automotive offerings. The 7 Series is known for its opulent features, advanced technology, and high-performance capabilities.',
            'year' => 2024,
            'image' => 'bmw_series_7_2024.png',
            'brand_id' => 10,
            'car_body_id' => 1,
            'fuel_id' => 3,
            'color_id' => 3,
        ]);

        Vehicle::create([
            'label' => '320d',
            'horsepower' => 170,
            'seats' => 5,
            'description' => 'The BMW 320d Series 3 stands as a beacon of refined driving, seamlessly combining performance and efficiency in a sleek and dynamic package. As part of the prestigious 3 Series lineup, this vehicle exemplifies the brands commitment to precision engineering and driver-centric design.',
            'year' => 2023,
            'image' => 'bmw_series3_320d_2023.png',
            'brand_id' => 7,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 3,
        ]);
        Vehicle::create([
            'horsepower' => 170,
            'seats' => 5,
            'description' => 'The BMW 3 Series is a popular luxury compact car produced by the German automaker BMW.BMW 3 Series was available in various configurations, including sedan, wagon, and Gran Turismo (GT). Here are some key features',
            'year' => 2022,
            'image' => 'bmw_serija_3.png',
            'brand_id' => 7,
            'car_body_id' => 1,
            'fuel_id' => 1,
            'color_id' => 3,
        ]);

        Vehicle::create([
            'horsepower' => 200,
            'seats' => 5,
            'description' => 'Introducing the BMW 7 Series, where luxury meets cutting-edge technology to redefine the driving experience. This flagship sedan combines timeless elegance with state-of-the-art innovations, setting a new standard for prestige and performance.',
            'year' => 2023,
            'image' => 'bmw-7-series.png',
            'brand_id' => 10,
            'car_body_id' => 1,
            'fuel_id' => 2,
            'color_id' => 8,
        ]);

        Vehicle::create([
            'label' => 'Perfomance body kit',
            'horsepower' => 480,
            'seats' => 5,
            'description' => 'The BMW X6 Performance is more than an SUV; its a symphony of power, precision, and luxury. Elevate your driving experience to new heights with a vehicle that seamlessly blends performance and sophistication.',
            'year' => 2023,
            'image' => 'BMW-X6-G06-in-Performance-body-kit.png',
            'brand_id' => 13,
            'car_body_id' => 3,
            'fuel_id' => 3,
            'color_id' => 1,
        ]);

        Vehicle::create([
            'horsepower' => 600,
            'seats' => 5,
            'description' => 'BMW iX, a visionary electric Sports Activity Vehicle (SAV) that redefines the concept of sustainable luxury. As BMWs flagship electric model, the iX combines groundbreaking technology, forward-thinking design, and an eco-conscious ethos to deliver an unparalleled driving experience.',
            'year' => 2024,
            'image' => 'iX.png',
            'brand_id' => 14,
            'car_body_id' => 3,
            'fuel_id' => 3,
            'color_id' => 3,
        ]);

        Vehicle::create([
            'horsepower' => 170,
            'seats' => 5,
            'description' => 'The BMW X1 stands out as a versatile and dynamic Sports Activity Vehicle (SAV), combining the agility of a compact car with the commanding presence of an SUV. With a focus on precision engineering, modern design, and innovative features, the X1 is designed to deliver a spirited driving experience and practical functionality.',
            'year' => 2022,
            'image' => 'X1.png',
            'brand_id' => 11,
            'car_body_id' => 3,
            'fuel_id' => 2,
            'color_id' => 3,
        ]);

        Vehicle::create([
            'horsepower' => 167,
            'seats' => 5,
            'description' => 'The BMW X2 represents a fusion of athleticism, style, and versatility in the form of a compact Sports Activity Coupe (SAC). Combining the agility of a coupe with the robustness of an SUV, the X2 caters to those who seek a dynamic driving experience without compromising on practicality.',
            'year' => 2022,
            'image' => 'x2.png',
            'brand_id' => 12,
            'car_body_id' => 3,
            'fuel_id' => 2,
            'color_id' => 8,
        ]);



    }
}
