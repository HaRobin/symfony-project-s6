<?php

namespace App\DataFixtures;

use App\Entity\Enum\Languages;
use App\Entity\Product;
use App\Entity\Enum\ProductStatus;
use App\Entity\TextContent;
use App\Entity\Translations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_REFERENCE = 'product';

    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Pulsar X2-H Noir',
                'price' => 109.90,
                'description' => 'Souris Gaming sans-fil ultra-légère - Noir - Forme symétrique - Capteur Pixart 3395 - 26000 DPI - Switchs optiques',
            ],
            [
                'name' => 'WLMouse BEAST X 8K Wireless Noir',
                'price' => 139.9,
                'description' => 'Souris Gaming sans-fil ultra-légère - Noire - Forme symétrique - Capteur PAW 3395 - 26000 DPI - Switchs optiques - Coque alvéolée - Compatible 8k Hz',
            ],
            [
                'name' => 'Razer BlackShark V2 X Noir',
                'price' => 49.9,
                'description' => 'Casque Gaming - Surround 7.1 - Néodyme de 50 mm - Fréquence 12 Hz ~ 28 000 Hz - Coussinets à mémoire de forme',
            ],
            [
                'name' => 'Glorious GMMK Pro Prebuilt 75% Blanc',
                'price' => 199.9,
                'description' => 'Clavier Gaming mécanique Blanc - RGB - Switches personnalisables - Format compact 75% - Câble USB tressé',



            ],
            [
                'name' => 'Glorious Model O Noir Mat',
                'price' => 44.9,
                'description' => 'Souris Gaming ultra légère RGB - Forme symétrique - Capteur PixArt PMW 3360 - 12 000 DPI - Câble Ascended Cord - Coque alvéolée',



            ],
            [
                'name' => 'Superglide Version 2 Patins en Verre 6 mm / 9 mm Dot Skates Blanc',
                'price' => 29.9,
                'description' => 'Patins de Souris Gaming en verre universels - Épaisseur 0,6 mm - Diamètre 6 mm / 8 mm',



            ],
            [
                'name' => 'Glorious Model O Wireless Blanc Mat',
                'price' => 69.9,
                'description' => 'Souris Gaming sans-fil ultra légère RGB - Blanche - Forme symétrique - Capteur Glorious BAMF - 19 000 DPI - Câble Ascended Cord - Coque alvéolée',



            ],
            [
                'name' => 'GLSSWRKS Hana',
                'price' => 159.9,
                'description' => 'Tapis de Souris en Verre - Structure rigide - 490 x 420 mm - Épaisseur 3 mm - Coins arrondis - Type hybride/control',



            ],
            [
                'name' => 'Superglide V2 Tapis de Souris en Verre XL Rouge',
                'price' => 114.9,
                'description' => 'Tapis de Souris en Verre XL - Structure rigide - Rouge - Dimensions : 490 x 420 mm - Épaisseur 1.5 mm - Base anti-dérapante',



            ],
            [
                'name' => 'ATK RS7 Pro Magnetic Blanc',
                'price' => 169.9,
                'description' => 'Clavier Gaming magnétique blanc - Format compact - Switchs Jiadalong Purple - Rétroéclairage RGB - Keycaps PBT - Câble détachable',



            ],
            [
                'name' => 'FGG MAD68 R Noir Rouge',
                'price' => 89.9,
                'description' => 'Clavier Gaming magnétique - Format compact - Switchs Kunlun - Rétroéclairage RGB',



            ],
            [
                'name' => 'Higround BLACKICE Base 65',
                'price' => 79.9,
                'description' => 'Clavier Gaming mécanique Noir - Format compact - Switchs White Flame - Rétroéclairage RGB - Keycaps PBT - Touches macro - Câble détachable',



            ],
            [
                'name' => 'Wraith Bidirectional Coiled Cable Noir',
                'price' => 24.9,
                'description' => 'Câble Noir pour Clavier Gaming - Connecteur USB-A vers Connecteur USB-C - 150 cm - Coiled',



            ],
            [
                'name' => 'Endgame Gear Pack de Switchs TTC Dustproof Gold 80m 55-65gf',
                'price' => 8.9,
                'description' => 'Switchs de souris gaming - Endgame Gear OP1 - TTC Dustproof Gold - Pack de 2 - Force d\'actionnement 55/65 g',



            ],
            [
                'name' => 'Keychron Set de Keycaps PBT Double Shot Blanc, Gris, Vert',
                'price' => 49.9,
                'description' => 'Keycaps PBT Double Shot pour Clavier Gaming - Blanc / Vert - Pack de 219 touches - Compatible switchs mécaniques MX',



            ],
            [
                'name' => 'Pulsar Xlite V3 eS Wireless Noir',
                'price' => 139.9,
                'description' => 'Souris Gaming sans-fil ultra-légère Noire - Forme ergonomique- Capteur Pixart PAW 3395 - 26000 DPI - Switchs optiques - 4000/8000 Hz',



            ],
            [
                'name' => 'WLMouse Sword X 8K Wireless Ruby',
                'price' => 189.9,
                'description' => 'Souris Gaming sans-fil ultra-légère - Ruby - Forme ergonomique - Capteur PAW 3950HS - 26000 DPI - Switchs Omron Optiques  - Coque alvéolée - Compatible 8k Hz',



            ],
            [
                'name' => 'NRV Cleaning Kit',
                'price' => 14.9,
                'description' => 'Kit de nettoyage - Clavier / Souris / Manettes / Ecouteur',



            ],
            [
                'name' => 'Pulsar Dongle 8K Hz',
                'price' => 21.9,
                'description' => 'Receveur/Dongle pour Souris Gaming Pulsar - Connecteur USB-C - Noir',



            ],
            [
                'name' => 'Corepad Patins Teflon PRO Zaopin Z2 4K Wireless',
                'price' => 9.4,
                'description' => 'Patins de Souris Gaming PTFE pour Zaopin Z2 4K Wireless - Épaisseur 0,75 mm - Vendus par paire',



            ],
            [
                'name' => 'Steelseries Arctis Nova 5 Blanc',
                'price' => 139.9,
                'description' => 'Casque Gaming sans-fil - Surround 7.1 Microsoft Spatial Sound et Tempest 3D Audio - 38 heures d\'autonomie - Néodyme de 40 mm - Fréquence 20 Hz ~ 22 000 Hz - Micro à réduction de bruit - Double connectivité - Recharge rapide',



            ],
            [
                'name' => 'Keychron Gateron Double-Rail Magnetic Switch Nebula',
                'price' => 29.9,
                'description' => 'Switchs magnétiques pour Clavier Gaming - Pack de 110 - Linéaire - Force d\'actionnement 40-60 g - Distance d\'activation 0.1-4mm - Course totale 4 mm - 100 millions de clics',



            ],
            [
                'name' => 'Wraith Grip Tape Universel V2 Violet',
                'price' => 8.9,
                'description' => 'Grip de souris & clavier - Compatible avec toutes marques et tous modèles',



            ],
            [
                'name' => 'FGG MAD68 HE Flagship Noir',
                'price' => 74.9,
                'description' => 'Clavier Gaming magnétique - Format compact - Switchs Amber Pro - Rétroéclairage RGB',



            ],
            [
                'name' => 'Corepad Patins Teflon PRO Logitech G Pro Wireless',
                'price' => 9.4,
                'description' => 'Patins de Souris Gaming PTFE pour Logitech G Pro Wireless - Épaisseur 0,8 mm - Vendus par paire',



            ],
            [
                'name' => 'Xbox Casque Sans-Fil Edition 2024',
                'price' => 109.9,
                'description' => 'Casque Gaming sans-fil noir - Son Stéréo - Néodyme de 40 mm - Fréquence 5 Hz ~ 20 000 Hz - Coussinets en mousse/cuir - Micro rabattable',



            ],
            [
                'name' => 'Razer Blackshark V2 Pro 2023 Noir',
                'price' => 229.9,
                'description' => 'Casque Gaming sans-fil - THX Spatial Audio - 70h d\'autonomie - Néodyme de 50 mm - Fréquence 12 Hz ~ 28 000 Hz',



            ],
            [
                'name' => 'Tenta-X The Last Stand XL',
                'price' => 59.9,
                'description' => 'Tapis de Souris en tissu - Structure souple - 490 x 420 - Épaisseur 3,5 mm - Bords cousus',



            ],
            [
                'name' => 'X-Raypad Heavy Bee XL Square Soft Rouge',
                'price' => 54.9,
                'description' => 'Tapis de Souris en tissu XL - Structure souple - 500x500 - Épaisseur 4 mm - Bords cousus',



            ],
            [
                'name' => 'VGN Dragonfly 4K USB Dongle',
                'price' => 17.9,
                'description' => 'Receveur/Dongle 4K pour Souris Gaming VGN / VXE - Connecteur USB-C - Noir',



            ],
            [
                'name' => 'Akko MonsGeek MG75S HE Shine Through',
                'price' => 148.9,
                'description' => 'Clavier Gaming magnétique - Format Compact 60% - Switchs Kailh Sakura Pink Magnetic - Rétroéclairage RGB - Keycaps PBT - Câble détachable',



            ],
            [
                'name' => 'Cooler Master CH331',
                'price' => 39.9,
                'description' => 'Casque Gaming RGB - Surround 7.1 - Néodyme de 50 mm - Fréquence 20 Hz ~ 20 000 Hz',



            ],
            [
                'name' => 'Wraith Spirit of Aim PRO Speed Noir',
                'price' => 49.9,
                'description' => 'Tapis de Souris en tissu XL - Structure souple - 500 x 500 mm - Épaisseur 3 mm - Bords cousus - Livré à plat',



            ],
            [
                'name' => 'X-Raypad Keycaps Cerberus',
                'price' => 49.9,
                'description' => 'Keycaps PBT/PC pour Clavier Gaming - Rouge - Pack de 110 touches - Compatible switchs mécaniques MX - Profil Cherry',



            ],
            [
                'name' => 'Fnatic REACT',
                'price' => 64.9,
                'description' => 'Casque Gaming - Stéréo - Néodyme de 53 mm - Fréquence 20 Hz ~ 40 000 Hz - Coussinets à mémoire de forme - Micro détachable',



            ],
            [
                'name' => 'Tenta-X Octo-Grip XL Square Violet',
                'price' => 54.9,
                'description' => 'Tapis de Souris en tissu - Structure souple - 500 x 500 - Épaisseur 3,5 mm - Bords cousus',



            ],
        ];

        foreach ($products as $key => $productData) {
            $product = new Product();

            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);

            $manager->persist($product);
            $this->addReference($this::PRODUCT_REFERENCE . '_' . $key + 1, $product);
        }

        $manager->flush();
    }
}
