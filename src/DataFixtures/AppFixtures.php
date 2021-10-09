<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {
    
    /**
     * Generates initialization data for regions : [region, country, presentation]
     * @return \\Generator
     */
    private static function regionDataGenerator()
    {
        yield ["Arkanis", "Secteur Arkanis", "Capitale du secteur Arkanis, colonisée vers 4 200 av. BY."];
        yield ["Tatooine", "Secteur Arkanis", "Un monde désertique. Des fossiles laissaient penser aux scientifiques que Tatooine avait été recouverte par un océan à l'instar de Kamino. "];
        yield ["Géonosis", "Secteur Arkanis", "Une planète-désert. La guerre des clones commence lorsque la République galactique envahit Géonosis aux mains de la Confédération des systèmes indépendants."];
        yield ["Javin", "Secteur Javin", "Capitale du secteur Javin."];
        yield ["Isde Naha", "Secteur Yarith", "Capitale du secteur Yarith."];
        yield ["Gerrenthum", "Secteur Anoat", "Capitale du secteur Anoath"];
        yield ["Hoth", "Secteur Anoat", "Planète glacée. Hôte de la base Echo de l'Alliance Rebelle."];
        yield ["Bespin","Secteur Anoat","Lieu de naissance du contrebandier Lando Calrissian."];
        
    }
    
    private static function ownerGenerator()
    {
        yield ["Cayjul", "Goodoatt", "Secteur Arkanis"];        
        yield ["Winseam","Cavecara","Secteur Arkanis"];
        yield ["Kylaken","Jewvint","Secteur Javin"];
        yield ["Arijimm","Mowehel","Secteur Yarith"];
        yield ["Larsau","Nichmonk","Secteur Yarith"];
        yield ["Fabifred","Waitsin","Secteur Anoat"];
        yield ["Josleo","Blakholi","Secteur Anoat"];
        yield ["Winseam","Cavecara","Secteur Arkanis"];
    }
    
    /**
     * Generates initialization data for region rooms:
     *  [region_name, region_country, room_summary, room_description, room_capacity, room_superficy, room_price, room_address]
     * @return \\Generator
     */
    private static function roomGenerator()
    {
       yield ["Tatooine",
            "Secteur Arkanis",
            "Joli duplex en plein centre de Mos Eisley",
           "Absolument incroyable",
            "2","50","200","52 rue du Commerce Transplanétaire",
            "Goodoatt"
        ];
       yield ["Tatooine",
           "Secteur Arkanis",
           "Grand appartement avec rooftop",
           "Foufou",
           "4","120","500","23 avenue de la République Galactique",
           "Cavecara"
       ];
    }

    public function load(ObjectManager $manager)
    {
        
        $regionRepo = $manager->getRepository(Region::class);
        $ownerRepo = $manager->getRepository(Owner::class);
        
        foreach(self::regionDataGenerator() as [$name, $country, $presentation]){
            
            $region = new Region();
            $region->setName($name);
            $region->setCountry($country);
            $region->setPresentation($presentation);
            $manager->persist($region);
        }        

        $manager->flush();
                
        foreach (self::ownerGenerator() as [$firstname, $familyName, $country]){
            $owner = new Owner();
            $owner->setFamilyName($familyName);
            $owner->setFirstname($firstname);
            $owner->setCountry($country);
            $manager->persist($owner);
        }
        $manager->flush();
        
        foreach (self::roomGenerator() as [$region, $country, $summary, $description, $capacity, $superficy, $price, $address, $familyName])
        {
            $region = $regionRepo->findOneBy(['name' => $region, 'country' => $country]);
            $owner = $ownerRepo->findOneBy(['familyName' => $familyName, 'country' => $country]);
           
            $room = new Room();
            $room->setSummary($summary);
            $room->setDescription($description);
            $room->setPrice($price);
            $room->setSuperficy($superficy);
            $room->setCapacity($capacity);
            $room->setAddress($address);
            $room->setOwner($owner);
            $room->setRegion($region);
              
            $manager->persist($room);
        }
        $manager->flush();
    }
}
