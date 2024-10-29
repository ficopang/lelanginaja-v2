<?php

namespace Database\Factories;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Factories\Factory;

class Ecommerce extends Base
{
    protected static $televisions = [
        'Sumsang 65 Inch Curved QLED Ultra HD',
        'Sumsang 75″ Crystal UHD 4K Smart TV',
        'LJ 65" OLED 4K UHD Smart TV',
        'LJ 65" UHD 4K Smart LED TV',
        'SONI Bravia 65” 4K UHD Led Smart TV',
        'Panasonik 65" 4K UHD HDR Led TV',
        'Tosiba Pro Theatre 4K Android Smart TV'
    ];

    protected static $mobilePhones = [
        'Apel aPhone 12 mini',
        'Sumsang Galaxy S20 FE 5G',
        'Alkatel Go Flip 3',
        'Apel aPhone 12 Pro',
        'Nokya 5.3',
        'Motoroola Moto G Power',
        'Gugel Pixel 4a',
        'WanPlus 8T',
        'Sumsang Galaxy S21',
        'Sumsang Galaxy S21 Ultra',
        'aPhone 11',
        'aPhone SE',
        'Sumsang Galaxy Fold'
    ];

    protected static $laptops = [
        'Alienwear m15 R4',
        'Apel MacBook Air',
        'Snsv ROG Zephyrus G14',
        'Doll XPS 13',
        'HF Spectre x360 14',
        'Lenova IdeaPad Flex 5 14',
        'Lenova ThinkPad X1 Carbon Gen 8',
        'Razor Book 13',
        'HF Spectre x360 15',
        'Lenova Chromebook Duet',
        'Snsv ZenBook 13',
        'HF Envy x360 13 (2020)',
        'Microsoup Surface Pro 7',
        'Acar Swift 3',
        'LJ Gram 17'
    ];

    protected static $cameras = [
        'Fujifilem X-T4',
        'Soni a7 III',
        'Fujifilem X-T30',
        'Soni a6400',
        'Kanon PowerShot G5 X Mark II',
        'Kanon PowerShot SX70 HS',
        'Olympush Tough TG-6',
        'Kanon EOS R6',
        'Kanon PowerShot G9 X Mark II',
    ];

    protected static $mensClothing = [
        "Livi's Men's 505 Regular Fit Jeans",
        "Men's Standard Hooded Fleece Sweatshirt",
        "Men's Waffle Shawl Robe",
        "Livi's Men's 550 Relaxed Fit Jeans",
        "Men's Heavyweight Hooded Puffer Coat",
        "Men's Fleece Crewneck Sweatshirt",
        "Men's Regular-fit Cotton Polo Shirt",
        "Men's Straight-Fit Woven Pajama Pant",
        "Men's Regular-Fit Long-Sleeve Flannel Shirt",
        "Men's Quick-Dry Swim Trunk",
        "Men's Jogger"
    ];

    protected static $womensClothing = [
        "Women's Lightweight Long-Sleeve Full-Zip Hooded Jacket",
        "Pinzan Terry Bathrobe 100% Cotton",
        "Women's Studio Terry Jogger Pant",
        "Women's Classic Fit Long-Sleeve V-Neck Sweater",
        "Women's Blake Long Blazer",
        "BTFBM Women Elegant Long Sleeve Casual Short Dress",
        "Core 10 Women's Spectrum Yoga Legging",
        "The Drop Women's Reversible Sherpa Jacket"
    ];

    protected static $jewelry = [
        "AGS Certified 14k White Gold Diamond Earrings",
        "Sterling Silver Earrings",
        "14k Yellow Gold-Filled Heart Locket",
        "Sterling Silver Filigree Hoop Earrings",
        "10k Diamond Pendant Necklace",
        "Sterling Silver Diamond Band Ring",
        "Platinum-Plated Sterling Zirconia Halo Ring",
        "Plated Sterling Dangle Earrings",
    ];

    protected static $watches = [
        "Breguet Double Tourbillon Rose Gold Watch",
        "Franck Muller Vanguard Watch",
        "Rolex Sky Dweller Sundust Dial 18kt Watch",
        "IWC Men's Portuguese Minute Repeater Gold Watch",
        "Rolex Day-Date 40 President Watch"
    ];

    protected static $guitars = [
        "Fender Stratocaster",
        "Gibson Les Paul",
        "PRS Custom 24",
        "Ibanez RG",
        "Taylor 814ce",
        "Martin D-28",
        "Yamaap Pacifica",
        "Epaphone Casino",
        "Gretsch Country Gentleman",
        "Suhr Standard"
    ];

    protected static $paintings = [
        "The Starry Night",
        "The Persistence of Memory",
        "The Scream",
        "The Night Watch",
        "Starry Night Over the Rhône",
        "Girl with a Pearl Earring",
        "The Great Wave off Kanagawa",
        "Whistler's Mother"
    ];

    protected static $pianos = [
        "Steinwey & Son Model D",
        "Yamaap CFX",
        "Bosendorferz Imperial",
        "Bechsteinz Model B",
        "Shigeru Kawaii SK-EX",
        "Rolland RD-2000",
        "Kawaii VPC1",
        "Nords Stage 3",
        "Kasio PX-870",
        "Rolland FP-90"
    ];

    protected static $cars = [
        "Toyoto Corolla",
        "Konda Civic",
        "Lord Mustang",
        "Sevrolet Camaro",
        "BMV 3 Series",
        "Mersedes-Benz C-Class",
        "Auda A4",
        "Volksvagen Golf",
        "Nissin Altima",
        "Hyundye Sonata"
    ];

    protected static $motorcycles = [
        "Harley-Davidsan Street Glide",
        "Yamaap YZF-R1",
        "Bucati Panigale V4",
        "Konda CBR1000RR-R Fireblade SP",
        "Suzukee GSX-R1000",
        "BMV S1000RR",
        "Triamph Speed Triple RS",
        "CTM 1290 Super Duke R",
        "Aprilio RSV4 RR",
        "NV Agusta F4 RC"
    ];

    protected static $jeans = [
        "Livi's 501",
        "Wringler 13MWZ",
        "Lea Riders",
        "Livi's 569",
        "Livi's 527",
        "True Religion Joiy",
        "Guest Skinny Jeans",
        "Calvin Clein Jeans",
        "7 For All Mankin Slimmy",
        "Ralph Laurend Straight Fit"
    ];

    protected static $shirts = [
        "Hanest Beefy-T",
        "Wildan Ultra Cotton",
        "American Apparel Fine Jersey",
        "Next Level 3600",
        "Anvile 980",
        "Bello + Canvas 3001",
        "Port & Company Core 50",
        "Jerziis NuBlend Pullover Hoodie",
        "Fruit of the Loom Valueweight",
        "Russoll Athletic Eco-Spun Fleece"
    ];

    protected static $shoes = [
        "Niki Air Max 270",
        "Adidos Ultraboost",
        "Conversed Chuck Taylor All Star",
        "Fans Old Skool",
        "New Balanze 990v5",
        "Rebook Club C 85",
        "Pumi Suede Classic",
        "Asiks Gel-Kayano 26",
        "Sauconi Jazz Original",
        "Tymberland 6-Inch Premium Boot"
    ];

    protected static $novels = [
        "Pride and Prejudice",
        "1984",
        "The Great Gatsby",
        "One Hundred Years of Solitude",
        "The Catcher in the Rye",
        "The Lord of the Rings",
        "The Hobbit",
        "The Grapes of Wrath",
        "The Little Prince",
        "And Then There Were None",
        "The Hitchhiker's Guide to the Galaxy",
        "The Name of the Rose",
        "The Da Vinci Code",
        "The Alchemist",
        "The Kite Runner",
        "The God of Small Things",
        "Life of Pi",
        "The Book Thief",
        "The Secret Garden",
        "The Handmaid's Tale",
        "The Hunger Games",
        "Gone Girl",
        "The Girl with the Dragon Tattoo",
        "The Girl on the Train",
        "The Silent Patient",
        "Where the Crawdads Sing",
        "Little Fires Everywhere",
        "The Night Circus",
    ];

    protected static $lessons = [
        "Algorithm and Programming",
        "Java for Dummies",
        "Data Structure",
        "Program Design Methods",
        "Compilation Technique",
        "Operating Systems",
    ];

    /**
     * A random Televisions.
     * @return string
     */
    public function television()
    {
        return static::randomElement(static::$televisions);
    }

    /**
     * A random Mobile Phone Name.
     * @return string
     */
    public function mobilePhone()
    {
        return static::randomElement(static::$mobilePhones);
    }

    /**
     * A random laptop Name.
     * @return string
     */
    public function laptop()
    {
        return static::randomElement(static::$laptops);
    }

    /**
     * A random camera Name.
     * @return string
     */
    public function camera()
    {
        return static::randomElement(static::$cameras);
    }

    /**
     * A random mens clothing Name.
     * @return string
     */
    public function mensClothing()
    {
        return static::randomElement(static::$mensClothing);
    }

    /**
     * A random woment's clothing Name.
     * @return string
     */
    public function womensClothing()
    {
        return static::randomElement(static::$womensClothing);
    }

    /**
     * A random watches Name.
     * @return string
     */
    public function watch()
    {
        return static::randomElement(static::$watches);
    }

    /**
     * A random jewelry Name.
     * @return string
     */
    public function jewelry()
    {
        return static::randomElement(static::$jewelry);
    }

    /**
     * A random guitars Name.
     * @return string
     */
    public function guitar()
    {
        return static::randomElement(static::$guitars);
    }

    /**
     * A random paintings Name.
     * @return string
     */
    public function painting()
    {
        return static::randomElement(static::$paintings);
    }

    /**
     * A random pianos Name.
     * @return string
     */
    public function piano()
    {
        return static::randomElement(static::$pianos);
    }

    /**
     * A random cars Name.
     * @return string
     */
    public function car()
    {
        return static::randomElement(static::$cars);
    }

    /**
     * A random motorcycles Name.
     * @return string
     */
    public function motorcycle()
    {
        return static::randomElement(static::$motorcycles);
    }

    /**
     * A random jeans Name.
     * @return string
     */
    public function jean()
    {
        return static::randomElement(static::$jeans);
    }

    /**
     * A random shirts Name.
     * @return string
     */
    public function shirt()
    {
        return static::randomElement(static::$shirts);
    }

    /**
     * A random shoes Name.
     * @return string
     */
    public function shoes()
    {
        return static::randomElement(static::$shoes);
    }

    /**
     * A random novel Name.
     * @return string
     */
    public function novel()
    {
        return static::randomElement(static::$novels);
    }

    /**
     * A random lesson Name.
     * @return string
     */
    public function lesson()
    {
        return static::randomElement(static::$lessons);
    }
}
