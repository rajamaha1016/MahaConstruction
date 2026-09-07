<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\PackageDetail;
use App\Models\Project;
use App\Models\Testimonial;

class InteriorContentSeeder extends Seeder
{
    /**
     * Seed only business_type = 'interior' content without touching Construction data.
     */
    public function run(): void
    {
        // 1. Interior Services
        $interiorServices = [
            [
                'name'          => 'Interior Design & Planning',
                'slug'          => 'interior-design-planning',
                'overview'      => 'Comprehensive 2D & 3D space planning, conceptual moodboards, ergonomic spatial flows, and material curation tailored to your lifestyle.',
                'benefits'      => ['Photorealistic 3D renders', 'Vastu-compliant layouts', 'Custom material moodboards', 'Detailed joinery blueprints'],
                'process'       => [
                    ['step' => '1', 'title' => 'Lifestyle Discovery', 'description' => 'Understanding your family habits, aesthetic desires, and functional goals.'],
                    ['step' => '2', 'title' => '2D Space Optimization', 'description' => 'Drafting floor layouts, walking clearances, and ergonomics.'],
                    ['step' => '3', 'title' => '3D Photorealistic Views', 'description' => 'Virtual walkthroughs with accurate lighting and textures.'],
                    ['step' => '4', 'title' => 'BOQ & Specifications', 'description' => 'Detailed material schedule with zero hidden surprises.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Design & Planning',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Turnkey Interior Execution',
                'slug'          => 'turnkey-interior-execution',
                'overview'      => 'End-to-end design, factory fabrication, on-site installation, and white-glove handover managed by experienced site engineers.',
                'benefits'      => ['Single point of accountability', 'Factory machine-pressed finish', 'Strict milestone schedules', '10-Year hardware warranty'],
                'process'       => [
                    ['step' => '1', 'title' => 'Site Verification', 'description' => 'Laser-accurate site measurements and plumb-line checks.'],
                    ['step' => '2', 'title' => 'Off-Site Precision Fabrication', 'description' => 'Machine edge-banding and precision CNC joinery.'],
                    ['step' => '3', 'title' => 'On-Site Clean Assembly', 'description' => 'Dust-free assembly supervised by senior engineers.'],
                    ['step' => '4', 'title' => 'Deep Clean & Handover', 'description' => 'Pristine handover with warranty certificates.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Execution',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Modular Kitchen',
                'slug'          => 'modular-kitchen',
                'overview'      => 'Ergonomic, moisture-proof modular kitchens built with marine-grade ply, premium acrylic/laminate finishes, and German soft-close fittings.',
                'benefits'      => ['BWP marine-grade plywood', 'Hafele / Blum soft-close fittings', 'Quartz / Granite heatproof counters', 'Seamless corner carousel units'],
                'process'       => [
                    ['step' => '1', 'title' => 'Work Triangle Analysis', 'description' => 'Optimizing sink, stove, and refrigerator distance for chef-like efficiency.'],
                    ['step' => '2', 'title' => 'Hardware Selection', 'description' => 'Choosing Blum/Hafele tandem boxes, lift-ups, and pull-outs.'],
                    ['step' => '3', 'title' => 'Factory Calibration', 'description' => 'Waterproof PU/acrylic lamination under heavy hydraulic pressure.'],
                    ['step' => '4', 'title' => 'Appliance Fitment', 'description' => 'Integrated chimneys, hobs, ovens, and LED profile illumination.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Kitchen',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Wardrobe Design',
                'slug'          => 'wardrobe-design',
                'overview'      => 'Floor-to-ceiling wardrobes, walk-in closets, and sliding storage systems tailored with integrated LED profile lighting and velvet organizer drawers.',
                'benefits'      => ['Floor-to-ceiling max storage', 'Soft-close sliding / swing doors', 'Built-in sensor profile lights', 'Bespoke vanity & mirror integration'],
                'process'       => [
                    ['step' => '1', 'title' => 'Wardrobe Audit', 'description' => 'Measuring hanging space, shelving, drawers, and locker provisions.'],
                    ['step' => '2', 'title' => 'Door System Design', 'description' => 'Fluted glass, tinted mirrors, or sleek matte laminate finishes.'],
                    ['step' => '3', 'title' => 'Internal Partitioning', 'description' => 'Jewellery trays, tie racks, and pull-down hanging rods.'],
                    ['step' => '4', 'title' => 'Smooth Installation', 'description' => 'Zero-noise German sliding track alignment and testing.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Storage',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Living Room Interiors',
                'slug'          => 'living-room-interiors',
                'overview'      => 'Sophisticated TV consoles, acoustic fluted wall panelling, Italian marble wall accents, and warm concealed illumination for memorable hosting.',
                'benefits'      => ['Concealed cable management', 'Fluted wood & marble wall accents', 'Floating TV entertainment credenzas', 'Warm accent cove lighting'],
                'process'       => [
                    ['step' => '1', 'title' => 'Focal Wall Framing', 'description' => 'Designing the primary acoustic entertainment backdrop.'],
                    ['step' => '2', 'title' => 'MEP & Cable Concealment', 'description' => 'Concealing HDMI, optical audio, and power conduits inside walls.'],
                    ['step' => '3', 'title' => 'Wall Panelling Fitment', 'description' => 'Applying charcoal fluted louvers, veneer, or stone veneers.'],
                    ['step' => '4', 'title' => 'Lighting Integration', 'description' => 'CRI 90+ warm architectural spotlights and cove glows.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Living',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Bedroom Interiors',
                'slug'          => 'bedroom-interiors',
                'overview'      => 'Tranquil master suites and guest bedrooms featuring upholstered headboards, bedside floating pedestals, study desks, and serene soothing color palettes.',
                'benefits'      => ['Acoustically insulated headboard walls', 'Bedside 2-way master switch controls', 'Integrated work-from-home study desk', 'Soft atmospheric ambient glow'],
                'process'       => [
                    ['step' => '1', 'title' => 'Bed Placement & Flow', 'description' => 'Positioning king/queen master beds according to natural ventilation.'],
                    ['step' => '2', 'title' => 'Headboard Crafting', 'description' => 'Custom leatherette, velvet, or fluted timber backdrops.'],
                    ['step' => '3', 'title' => 'Bedside Amenities', 'description' => 'Concealed wireless phone chargers and soft reading spotlights.'],
                    ['step' => '4', 'title' => 'Dressing Area Setup', 'description' => 'Full-length mirror backlit with warm neutral LEDs.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1540518614846-7ede433c4ef0?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Bedroom',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'False Ceiling',
                'slug'          => 'false-ceiling',
                'overview'      => 'Architectural Saint-Gobain gypsum false ceilings with seamless edge cove lights, magnetic track light channels, and minimal recessed lighting.',
                'benefits'      => ['Saint-Gobain certified gypsum boards', 'Anti-crack GI metal framing', 'Magnetic track channel integration', 'Thermal and sound insulation'],
                'process'       => [
                    ['step' => '1', 'title' => 'Laser Level Marking', 'description' => 'Setting ceiling drop levels to preserve maximum headroom.'],
                    ['step' => '2', 'title' => 'GI Perimeter Framing', 'description' => 'Heavy-gauge galvanized steel channel framing.'],
                    ['step' => '3', 'title' => 'Board Screwing & Jointing', 'description' => 'Joint compound, fiber tape, and seamless sanding.'],
                    ['step' => '4', 'title' => 'Lighting Cutouts', 'description' => 'Laser cutouts for magnetic tracks, COB spotlights, and strip LED.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Ceiling',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Lighting Design',
                'slug'          => 'lighting-design',
                'overview'      => 'Layered architectural illumination balancing task, accent, and ambient light with high color-rendering index (CRI 90+) LED strips and magnetic track fixtures.',
                'benefits'      => ['3-Layer architectural lighting', 'CRI 90+ true-color LEDs', 'Dimmable mood presets', 'Magnetic tool-free track adjustments'],
                'process'       => [
                    ['step' => '1', 'title' => 'Lighting Lux Calculations', 'description' => 'Calculating required lumens for cooking, reading, and entertaining.'],
                    ['step' => '2', 'title' => 'Fixture Curation', 'description' => 'Selecting anti-glare deep recessed spotlights and track spotlights.'],
                    ['step' => '3', 'title' => 'Driver & Power Load Balancing', 'description' => 'Concealed constant-voltage drivers for flicker-free longevity.'],
                    ['step' => '4', 'title' => 'Scene Commissioning', 'description' => 'Balancing warm 3000K mood lighting and 4000K task lighting.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Lighting',
                'business_type' => 'interior',
            ],
            [
                'name'          => 'Renovation & Remodeling',
                'slug'          => 'interior-renovation-remodeling',
                'overview'      => 'Transforming outdated residential spaces into modern architectural masterpieces through structural wall removal, new flooring, and turnkey updates.',
                'benefits'      => ['Structural engineer supervision', 'Dust protection & debris disposal', 'Tile-on-tile or fresh screed flooring', 'Modernized MEP conduits'],
                'process'       => [
                    ['step' => '1', 'title' => 'Structural Feasibility', 'description' => 'Checking load-bearing columns before planning open-space conversions.'],
                    ['step' => '2', 'title' => 'Controlled Demolition', 'description' => 'Systematic removal of obsolete partitions and old tiles.'],
                    ['step' => '3', 'title' => 'MEP Upgradation', 'description' => 'Replacing old wiring and plumbing with certified materials.'],
                    ['step' => '4', 'title' => 'Architectural Modernization', 'description' => 'Fresh surfaces, contemporary ceilings, and luxury fittings.'],
                ],
                'image_url'     => 'https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?auto=format&fit=crop&w=1200&q=80',
                'category'      => 'Remodeling',
                'business_type' => 'interior',
            ],
        ];

        foreach ($interiorServices as $srv) {
            Service::updateOrCreate(
                ['slug' => $srv['slug']],
                $srv
            );
        }

        // 2. Interior Packages
        $interiorPackages = [
            [
                'division'        => 'interior',
                'tier'            => 'essential',
                'title'           => 'Essential Interior',
                'subtitle'        => 'Elegant & Smart Turnkey Solution',
                'price_per_sqft'  => 1250,
                'is_highlighted'  => false,
                'warranty_years'  => 5,
                'delivery_months' => 2,
                'description'     => 'Ideal for 2BHK and 3BHK homeowners seeking dependable quality, high-pressure laminate finishes, and modular functionality at transparent pricing.',
                'features'        => [
                    'ISI-grade BWR Marine Plywood (IS:303)',
                    '0.8mm High-Pressure Matte Laminates (Century / Greenlam)',
                    'Hettich / Ebco Soft-Close Hinges & Drawer Runners',
                    'Modular L-Shape / Straight Kitchen with SS 304 Baskets',
                    '2 Full-Height Swing Wardrobes with internal drawers',
                    'Floating TV Unit with concealed cable routing',
                    'Saint-Gobain Gypsum False Ceiling with LED Cob cutouts',
                    'Asian Paints Royale Luxury Interior Emulsion'
                ],
                'inclusions'      => [
                    'Modular Kitchen cabinets & loft cupboards',
                    'Master & Guest bedroom wardrobes (Swing Door)',
                    'Living room floating TV entertainment backdrop',
                    'Gypsum false ceiling in Living & Dining',
                    'Concealed electrical wiring for LED cove & spots',
                    '5 Years comprehensive warranty on hardware'
                ],
                'exclusions'      => [
                    'Kitchen chimney & built-in appliances',
                    'Loose movable furniture (sofa, dining chairs)',
                    'Curtains & soft furnishings',
                    'Smart home home automation switches'
                ],
                'business_type'   => 'interior',
            ],
            [
                'division'        => 'interior',
                'tier'            => 'premium',
                'title'           => 'Premium Interior',
                'subtitle'        => 'Elevated Aesthetics & Soft-Close Luxury',
                'price_per_sqft'  => 1750,
                'is_highlighted'  => true,
                'warranty_years'  => 10,
                'delivery_months' => 3,
                'description'     => 'Our most popular comprehensive interior solution featuring 1.0mm anti-fingerprint acrylic/PU finishes, German Hafele hardware, quartz counter, and ambient lighting.',
                'features'        => [
                    '100% Boiling Water Proof (BWP 710) Calibrated Ply',
                    '1.0mm Anti-Fingerprint Acrylic / Ultra-Matte Finish',
                    'Hafele / Blum Soft-Close Tandem Boxes & Lift-Ups',
                    'Parallel / Island Modular Kitchen with Quartz Counter',
                    'Floor-to-Ceiling Sliding Wardrobes with tinted glass accent',
                    'Living Room Fluted Louver Panel + Marble Sheet Backdrop',
                    'False Ceiling in all rooms with magnetic track lighting',
                    'Profile LED lighting in wardrobes and kitchen base'
                ],
                'inclusions'      => [
                    'Full Kitchen with tall pantry unit & tandem organizers',
                    'Master bedroom walk-in / sliding wardrobe with sensor LED',
                    'Kids & Guest room wardrobes with study tables',
                    'Designer TV wall with charcoal fluted louvers & storage',
                    'Foyer shoe rack with cushioned seating niche',
                    'Complete false ceiling across entire home with LED channels',
                    '10 Years hardware warranty with engineer supervision'
                ],
                'exclusions'      => [
                    'Movable living room sofa and mattress sets',
                    'Heavy kitchen appliances (refrigerator, microwave)',
                    'Balcony planter setups'
                ],
                'business_type'   => 'interior',
            ],
            [
                'division'        => 'interior',
                'tier'            => 'luxury',
                'title'           => 'Luxury Interior',
                'subtitle'        => 'Bespoke Architectural Grandeur',
                'price_per_sqft'  => 2450,
                'is_highlighted'  => false,
                'warranty_years'  => 15,
                'delivery_months' => 4,
                'description'     => 'Uncompromising elite craftsmanship using imported natural veneers, Italian PU lacquered surfaces, motorized Blum Aventos, and integrated smart scenes.',
                'features'        => [
                    'Birla / Century Club Prime 710 Gold BWP Plywood',
                    'Natural Smoked Oak / Teak Veneer with PU Polish & Italian Gloss',
                    'Blum Servo-Drive Motorized Opening System',
                    'Bespoke Island Kitchen with Kalinga Stone / Italian Marble',
                    'Walk-In Wardrobes with sensor illumination & velvet jewelry trays',
                    'Acoustic Fabric & Brass Inlay Panelling in Master Suite',
                    'Full Smart Architectural Lighting with automated dimming',
                    'Italian Travertine cladding on entrance and TV console'
                ],
                'inclusions'      => [
                    'Complete bespoke interior fitment from entrance to terrace',
                    'Island kitchen with motorized drawers & corner le-mans',
                    'Full walk-in dressing suite with glass aluminum profile shutters',
                    'Acoustic ceiling and home theatre wall treatments',
                    'Designer vanity counters in all bathrooms with mirrors',
                    'Smart ambient scene lighting throughout home',
                    '15 Years warranty with bi-annual maintenance checkup'
                ],
                'exclusions'      => [
                    'Art collection and specialized antique purchases',
                    'Smart TV / Soundbar electronics'
                ],
                'business_type'   => 'interior',
            ],
        ];

        foreach ($interiorPackages as $pkg) {
            PackageDetail::updateOrCreate(
                ['division' => 'interior', 'tier' => $pkg['tier']],
                $pkg
            );
        }

        // 3. Interior Projects
        $interiorProjects = [
            [
                'name'               => 'Contemporary Penthouse Living Room',
                'client'             => 'Er. Karthik & Family',
                'location'           => 'Nagercoil, Tamil Nadu',
                'budget'             => '₹14 Lakhs',
                'completion_date'    => '2026-06',
                'duration'           => '600 sq.ft',
                'architecture_style' => 'Modern Minimalist',
                'description'        => 'A tranquil living space anchored by a fluted charcoal accent wall, floating TV credenza with concealed wiring, and 3000K warm magnetic track lighting.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'timeline'           => [
                    ['phase' => '3D Render & Planning', 'duration' => '10 Days', 'description' => 'Space visualization and fluted panelling mockups.'],
                    ['phase' => 'Factory Joinery', 'duration' => '18 Days', 'description' => 'Precision cutting of matte laminate and veneer panels.'],
                    ['phase' => 'Lighting & Assembly', 'duration' => '12 Days', 'description' => 'Magnetic track placement and deep clean handover.']
                ],
                'category'           => 'living-room',
                'is_featured'        => true,
                'business_type'      => 'interior',
            ],
            [
                'name'               => 'German-Finish Island Modular Kitchen',
                'client'             => 'Dr. Sundar Rajan',
                'location'           => 'Tirunelveli, Tamil Nadu',
                'budget'             => '₹9.5 Lakhs',
                'completion_date'    => '2026-07',
                'duration'           => '280 sq.ft',
                'architecture_style' => 'Modern European',
                'description'        => 'Handleless acrylic island kitchen crafted with BWP 710 marine ply, quartz countertop, Blum soft-close tandem boxes, and integrated appliance towers.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'timeline'           => [
                    ['phase' => 'Appliance Planning', 'duration' => '7 Days', 'description' => 'Aligning hob, chimney, and built-in microwave zones.'],
                    ['phase' => 'Hydraulic Fabrication', 'duration' => '15 Days', 'description' => 'Anti-bubble acrylic sheet pressing.'],
                    ['phase' => 'Counter Installation', 'duration' => '8 Days', 'description' => 'Seamless miter-joint quartz installation.']
                ],
                'category'           => 'modular-kitchen',
                'is_featured'        => true,
                'business_type'      => 'interior',
            ],
            [
                'name'               => 'Master Suite & Walk-In Wardrobes',
                'client'             => 'Mr. & Mrs. Arun Prakash',
                'location'           => 'Chennai, Tamil Nadu',
                'budget'             => '₹12 Lakhs',
                'completion_date'    => '2026-05',
                'duration'           => '450 sq.ft',
                'architecture_style' => 'Warm Contemporary',
                'description'        => 'A calming master retreat featuring tinted glass sliding wardrobes, velvet interior organizers, an upholstered headboard, and bedside reading pendants.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1540518614846-7ede433c4ef0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => '',
                'timeline'           => [
                    ['phase' => 'Wardrobe Audit', 'duration' => '5 Days', 'description' => 'Custom drawer sizing and lighting schematics.'],
                    ['phase' => 'Assembly', 'duration' => '14 Days', 'description' => 'Dust-free modular assembly with soft-closing dampeners.']
                ],
                'category'           => 'bedroom',
                'is_featured'        => false,
                'business_type'      => 'interior',
            ],
            [
                'name'               => 'Corporate Executive Office Interior',
                'client'             => 'Apex Logistics HQ',
                'location'           => 'Nagercoil, Tamil Nadu',
                'budget'             => '₹18 Lakhs',
                'completion_date'    => '2026-04',
                'duration'           => '1,800 sq.ft',
                'architecture_style' => 'Corporate Minimalist',
                'description'        => 'Executive conference rooms and director cabins with acoustic wood slatted walls, frameless glass partitions, and linear architectural drop lights.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => '',
                'timeline'           => [
                    ['phase' => 'Layout & Acoustic Study', 'duration' => '12 Days', 'description' => 'Optimizing conference privacy and air flow.'],
                    ['phase' => 'Execution', 'duration' => '30 Days', 'description' => 'Turnkey fitout with zero business downtime.']
                ],
                'category'           => 'office-interior',
                'is_featured'        => false,
                'business_type'      => 'interior',
            ],
            [
                'name'               => '3,400 sq.ft Complete Turnkey Villa Interior',
                'client'             => 'Mr. Saravanan (NRI, Singapore)',
                'location'           => 'Madurai, Tamil Nadu',
                'budget'             => '₹28 Lakhs',
                'completion_date'    => '2026-08',
                'duration'           => '3,400 sq.ft',
                'architecture_style' => 'Bespoke Luxury',
                'description'        => 'Complete villa interior designed and executed remotely for an NRI homeowner — from foyer to home theatre with weekly video progress reports.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'timeline'           => [
                    ['phase' => 'Remote Design Alignment', 'duration' => '15 Days', 'description' => 'Virtual reality walkthroughs and approvals.'],
                    ['phase' => 'Turnkey Execution', 'duration' => '60 Days', 'description' => 'Complete woodwork, false ceiling, and lighting.']
                ],
                'category'           => 'full-home-interior',
                'is_featured'        => true,
                'business_type'      => 'interior',
            ],
            [
                'name'               => 'Luxury Boutique Showroom Interior',
                'client'             => 'Silks & Jewels Studio',
                'location'           => 'Kanyakumari, Tamil Nadu',
                'budget'             => '₹15 Lakhs',
                'completion_date'    => '2026-03',
                'duration'           => '1,100 sq.ft',
                'architecture_style' => 'Retail Luxury',
                'description'        => 'High-end retail studio with curved arched display niches, brushed brass trims, and warm accent lighting accentuating premium merchandise.',
                'image_urls'         => [
                    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1200&q=80'
                ],
                'video_url'          => '',
                'timeline'           => [
                    ['phase' => 'Concept & Branding', 'duration' => '8 Days', 'description' => 'Color palette and brass metal integration.'],
                    ['phase' => 'Fast-Track Fitout', 'duration' => '24 Days', 'description' => 'Delivered ahead of inauguration date.']
                ],
                'category'           => 'commercial-interior',
                'is_featured'        => false,
                'business_type'      => 'interior',
            ],
        ];

        foreach ($interiorProjects as $prj) {
            Project::updateOrCreate(
                ['name' => $prj['name'], 'business_type' => 'interior'],
                $prj
            );
        }

        // 4. Interior Testimonials
        $interiorTestimonials = [
            [
                'client_name'   => 'Dr. Vignesh & Dr. Ananya',
                'client_role'   => 'Villa Owners, Nagercoil',
                'rating'        => 5,
                'feedback'      => 'Maha Interior designed and executed our dream home interiors while we were working busy hospital shifts. The German soft-close kitchen and living room fluted panelling exceeded our highest expectations. Delivered 100% on time with complete cost transparency!',
                'image_url'     => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'video_url'     => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'project_name'  => 'Luxury Villa Interior (3,200 sq.ft)',
                'duration'      => '2:40',
                'business_type' => 'interior',
            ],
            [
                'client_name'   => 'Mr. Rajesh Kumar',
                'client_role'   => 'Homeowner, Tirunelveli',
                'rating'        => 5,
                'feedback'      => 'Our modular kitchen and master bedroom wardrobes are immaculate. Er. Maha Rajan personally checked the alignment of every cabinet and track. The factory-finish quality is vastly superior to on-site carpentry work.',
                'image_url'     => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'video_url'     => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'project_name'  => 'Modular Kitchen & Storage Suite',
                'duration'      => '2:15',
                'business_type' => 'interior',
            ],
            [
                'client_name'   => 'Mrs. Meenakshi Sundaram',
                'client_role'   => 'Architectural Homeowner, Chennai',
                'rating'        => 5,
                'feedback'      => 'The lighting design and false ceiling transformed our living room into a 5-star hotel ambiance. Their attention to detail on concealed wiring and material quality gives us complete peace of mind.',
                'image_url'     => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80',
                'video_url'     => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                'project_name'  => 'Full Home Turnkey Interior',
                'duration'      => '3:05',
                'business_type' => 'interior',
            ],
        ];

        foreach ($interiorTestimonials as $tst) {
            Testimonial::updateOrCreate(
                ['client_name' => $tst['client_name'], 'business_type' => 'interior'],
                $tst
            );
        }

        echo "Seeded: Interior Services, Packages, Projects, and Testimonials successfully.\n";
    }
}
