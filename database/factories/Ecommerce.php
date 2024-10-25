<?php

namespace Database\Factories;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Factories\Factory;

class Ecommerce extends Base
{
    protected static $televisions = [
        'Samsung 65 Inch Curved QLED Ultra HD', 'Samsung 75″ Crystal UHD 4K Smart TV', 'LG 65" OLED 4K UHD Smart TV', 'LG 65" UHD 4K Smart LED TV', 'SONY Bravia 65” 4K UHD Led Smart TV', 'Panasonic 65" 4K UHD HDR Led TV', 'Toshiba Pro Theatre 4K Android Smart TV'
    ];

    protected static $mobilePhones = [
        'Apple iPhone 12 mini', 'Samsung Galaxy S20 FE 5G', 'Alcatel Go Flip 3', 'Apple iPhone 12 Pro', 'Nokia 5.3', 'Motorola Moto G Power', 'Google Pixel 4a', 'OnePlus 8T', 'Samsung Galaxy S21', 'Samsung Galaxy S21 Ultra', 'iPhone 11', 'iPhone SE', 'Samsung Galaxy Fold'
    ];

    protected static $laptops = [
        'Alienware m15 R4', 'Apple MacBook Air', 'Asus ROG Zephyrus G14', 'Dell XPS 13', 'HP Spectre x360 14', 'Lenovo IdeaPad Flex 5 14', 'Lenovo ThinkPad X1 Carbon Gen 8', 'Razer Book 13', 'HP Spectre x360 15', 'Lenovo Chromebook Duet', 'Asus ZenBook 13', 'HP Envy x360 13 (2020)', 'Microsoft Surface Pro 7', 'Acer Swift 3', 'LG Gram 17'
    ];

    protected static $cameras = [
        'Fujifilm X-T4', 'Sony a7 III', 'Fujifilm X-T30', 'Sony a6400', 'Canon PowerShot G5 X Mark II', 'Canon PowerShot SX70 HS', 'Olympus Tough TG-6', 'Canon EOS R6', 'Canon PowerShot G9 X Mark II',
    ];

    protected static $mensClothing = [
        "Levi's Men's 505 Regular Fit Jeans", "Men's Standard Hooded Fleece Sweatshirt", "Men's Waffle Shawl Robe", "Levi's Men's 550 Relaxed Fit Jeans", "Men's Heavyweight Hooded Puffer Coat", "Men's Fleece Crewneck Sweatshirt", "Men's Regular-fit Cotton Polo Shirt", "Men's Straight-Fit Woven Pajama Pant", "Men's Regular-Fit Long-Sleeve Flannel Shirt", "Men's Quick-Dry Swim Trunk", "Men's Jogger"
    ];

    protected static $womensClothing = [
        "Women's Lightweight Long-Sleeve Full-Zip Hooded Jacket", "Pinzon Terry Bathrobe 100% Cotton", "Women's Studio Terry Jogger Pant", "Women's Classic Fit Long-Sleeve V-Neck Sweater", "Women's Blake Long Blazer", "BTFBM Women Elegant Long Sleeve Casual Short Dress", "Core 10 Women's Spectrum Yoga Legging", "The Drop Women's Reversible Sherpa Jacket"
    ];

    protected static $jewelry = [
        "AGS Certified 14k White Gold Diamond Earrings", "Sterling Silver Earrings", "14k Yellow Gold-Filled Heart Locket", "Sterling Silver Filigree Hoop Earrings", "10k Diamond Pendant Necklace", "Sterling Silver Diamond Band Ring", "Platinum-Plated Sterling Zirconia Halo Ring", "Plated Sterling Dangle Earrings",
    ];

    protected static $watches = [
        "Breguet Double Tourbillon Rose Gold Watch", "Franck Muller Vanguard Watch", "Rolex Sky Dweller Sundust Dial 18kt Watch", "IWC Men's Portuguese Minute Repeater Gold Watch", "Rolex Day-Date 40 President Watch"
    ];

    protected static $guitars = [
        "Fender Stratocaster",
        "Gibson Les Paul",
        "PRS Custom 24",
        "Ibanez RG",
        "Taylor 814ce",
        "Martin D-28",
        "Yamaha Pacifica",
        "Epiphone Casino",
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
        "Steinway & Sons Model D",
        "Yamaha CFX",
        "Bosendorfer Imperial",
        "Bechstein Model B",
        "Shigeru Kawai SK-EX",
        "Roland RD-2000",
        "Kawai VPC1",
        "Nord Stage 3",
        "Casio PX-870",
        "Roland FP-90"
    ];

    protected static $cars = [
        "Toyota Corolla",
        "Honda Civic",
        "Ford Mustang",
        "Chevrolet Camaro",
        "BMW 3 Series",
        "Mercedes-Benz C-Class",
        "Audi A4",
        "Volkswagen Golf",
        "Nissan Altima",
        "Hyundai Sonata"
    ];

    protected static $motorcycles = [
        "Harley-Davidson Street Glide",
        "Yamaha YZF-R1",
        "Ducati Panigale V4",
        "Honda CBR1000RR-R Fireblade SP",
        "Suzuki GSX-R1000",
        "BMW S1000RR",
        "Triumph Speed Triple RS",
        "KTM 1290 Super Duke R",
        "Aprilia RSV4 RR",
        "MV Agusta F4 RC"
    ];

    protected static $jeans = [
        "Levi's 501",
        "Wrangler 13MWZ",
        "Lee Riders",
        "Levi's 569",
        "Levi's 527",
        "True Religion Joey",
        "Guess Skinny Jeans",
        "Calvin Klein Jeans",
        "7 For All Mankind Slimmy",
        "Ralph Lauren Straight Fit"
    ];

    protected static $shirts = [
        "Hanes Beefy-T",
        "Gildan Ultra Cotton",
        "American Apparel Fine Jersey",
        "Next Level 3600",
        "Anvil 980",
        "Bella + Canvas 3001",
        "Port & Company Core 50",
        "Jerzees NuBlend Pullover Hoodie",
        "Fruit of the Loom Valueweight",
        "Russell Athletic Eco-Spun Fleece"
    ];

    protected static $shoes = [
        "Nike Air Max 270",
        "Adidas Ultraboost",
        "Converse Chuck Taylor All Star",
        "Vans Old Skool",
        "New Balance 990v5",
        "Reebok Club C 85",
        "Puma Suede Classic",
        "Asics Gel-Kayano 26",
        "Saucony Jazz Original",
        "Timberland 6-Inch Premium Boot"
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
    public function televisions()
    {
        return static::randomElement(static::$televisions);
    }

    /**
     * A random Mobile Phone Name.
     * @return string
     */
    public function mobilePhones()
    {
        return static::randomElement(static::$mobilePhones);
    }

    /**
     * A random laptop Name.
     * @return string
     */
    public function laptops()
    {
        return static::randomElement(static::$laptops);
    }

    /**
     * A random camera Name.
     * @return string
     */
    public function cameras()
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
    public function watches()
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
    public function guitars()
    {
        return static::randomElement(static::$guitars);
    }

    /**
     * A random paintings Name.
     * @return string
     */
    public function paintings()
    {
        return static::randomElement(static::$paintings);
    }

    /**
     * A random pianos Name.
     * @return string
     */
    public function pianos()
    {
        return static::randomElement(static::$pianos);
    }

    /**
     * A random cars Name.
     * @return string
     */
    public function cars()
    {
        return static::randomElement(static::$cars);
    }

    /**
     * A random motorcycles Name.
     * @return string
     */
    public function motorcycles()
    {
        return static::randomElement(static::$motorcycles);
    }

    /**
     * A random jeans Name.
     * @return string
     */
    public function jeans()
    {
        return static::randomElement(static::$jeans);
    }

    /**
     * A random shirts Name.
     * @return string
     */
    public function shirts()
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
