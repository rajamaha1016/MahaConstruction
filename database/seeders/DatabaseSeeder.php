<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Service;
use App\Models\Project;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Models\FAQItem;
use App\Models\PackageDetail;
use App\Models\Partner;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $adminEmail = env('ADMIN_EMAIL', 'Mahaconstructions2013@gmail.com');

        if (! User::where('email', $adminEmail)->exists()) {
            $adminPassword = env('ADMIN_PASSWORD');

            if (! $adminPassword) {
                throw new \RuntimeException('ADMIN_PASSWORD must be set before the first production database seed.');
            }

            User::create([
                'email'     => $adminEmail,
                'password'  => Hash::make($adminPassword),
                'full_name' => 'Maha Admin',
                'role'      => 'admin',
                'is_active' => true,
            ]);
        }
        echo "Seeded: Admin User\n";

        // 2. Services
        if (Service::count() === 0) {
            Service::insert([
                [
                    'name'      => 'Residential Construction',
                    'slug'      => 'residential-construction',
                    'overview'  => 'Crafting bespoke luxury estates designed for multi-generational comfort. Every residence is built as a work of art, merging architectural elegance with sustainable materials.',
                    'benefits'  => json_encode(['Custom tailormade design', 'Eco-friendly structural framing', 'Smart home systems integration', 'Premium Italian marble and custom joinery']),
                    'process'   => json_encode([
                        ['step' => '1', 'title' => 'Concept Design', 'description' => 'Collaborative sketching and layout refinement with our principal architects.'],
                        ['step' => '2', 'title' => 'Engineering & Approvals', 'description' => 'Rigorous structural engineering assessments and municipal permitting.'],
                        ['step' => '3', 'title' => 'Construction Phase', 'description' => 'Precision construction executed by our certified craftsmen.'],
                        ['step' => '4', 'title' => 'Handover & Warranty', 'description' => 'White-glove walkthrough and custom manuals delivery.'],
                    ]),
                    'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                    'category'  => 'Residential',
                    'created_at'=> now(), 'updated_at' => now(),
                ],
                [
                    'name'      => 'Commercial Construction',
                    'slug'      => 'commercial-construction',
                    'overview'  => 'Developing iconic corporate headquarters, high-end retail structures, and premium office facilities that inspire progress and optimize functional workflow.',
                    'benefits'  => json_encode(['LEED-certified standard builds', 'Optimized open-plan floorplates', 'Advanced seismic load designs', 'Fast-track scheduling control']),
                    'process'   => json_encode([
                        ['step' => '1', 'title' => 'Strategic Planning', 'description' => 'Aligning space design with commercial operational flow and branding.'],
                        ['step' => '2', 'title' => 'Rapid Prefabrication', 'description' => 'Leveraging modular off-site assembly for minimal on-site timeline.'],
                        ['step' => '3', 'title' => 'Core & Shell Assembly', 'description' => 'High-strength concrete and custom curtain-wall execution.'],
                        ['step' => '4', 'title' => 'Tenant Fit-Out', 'description' => 'Custom high-end interior finishes tailored for occupancy.'],
                    ]),
                    'image_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
                    'category'  => 'Commercial',
                    'created_at'=> now(), 'updated_at' => now(),
                ],
                [
                    'name'      => 'Architecture',
                    'slug'      => 'architecture',
                    'overview'  => 'Pioneering minimalist and sculptural building structures. We design with light, shadow, raw concrete, steel, and timber to form emotional connections with space.',
                    'benefits'  => json_encode(['Award-winning design philosophy', 'Passive heating & cooling design', 'BIM 3D modeling standard', 'Custom structural engineering integration']),
                    'process'   => json_encode([
                        ['step' => '1', 'title' => 'Site & Flow Analysis', 'description' => 'Analyzing sun pathways, elevations, and views to optimize site layout.'],
                        ['step' => '2', 'title' => 'Schematic Projections', 'description' => 'Initial hand-sketches and basic form-finding studies.'],
                        ['step' => '3', 'title' => 'Detailed Spatial Layouts', 'description' => 'Perfecting proportions and defining primary material selections.'],
                        ['step' => '4', 'title' => 'BIM Integration', 'description' => 'Creating full digital twins of the construction blueprint.'],
                    ]),
                    'image_url' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                    'category'  => 'Design',
                    'created_at'=> now(), 'updated_at' => now(),
                ],
                [
                    'name'      => 'Interior Design',
                    'slug'      => 'interior-design',
                    'overview'  => 'Curating minimalist interiors that embody tactile warmth. We combine bespoke furniture, textured plaster, and subtle indirect lighting for a serene setting.',
                    'benefits'  => json_encode(['Custom furniture curation', 'Natural material palettes', 'Ergonomic lighting schemes', 'Acoustic spatial engineering']),
                    'process'   => json_encode([
                        ['step' => '1', 'title' => 'Moodboards & Textures', 'description' => 'Defining the sensory palette: wood, stone, and plaster selection.'],
                        ['step' => '2', 'title' => 'Bespoke Joinery Drafts', 'description' => 'Designing custom closets, kitchens, and architectural screens.'],
                        ['step' => '3', 'title' => 'Furniture Procurement', 'description' => 'Sourcing rare fabrics and designer pieces globally.'],
                        ['step' => '4', 'title' => 'Styling & Setup', 'description' => 'Art curation, precise lighting adjustment, and hand-over.'],
                    ]),
                    'image_url' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80',
                    'category'  => 'Design',
                    'created_at'=> now(), 'updated_at' => now(),
                ],
            ]);
            echo "Seeded: Services\n";
        }

        // 3. Projects
        if (Project::count() === 0) {
            Project::insert([
                [
                    'name'               => 'The Glass Pavilion',
                    'client'             => 'Alexander Vance',
                    'location'           => 'Alibaug, Maharashtra',
                    'budget'             => '₹12.4 Crore',
                    'completion_date'    => 'October 2025',
                    'duration'           => '18 Months',
                    'architecture_style' => 'Modernist Minimalism',
                    'description'        => 'Perched on a coastal cliff, this residential masterpiece features floor-to-ceiling structural glass, raw board-formed concrete, and a cantilevered infinity pool that merges seamlessly with the Arabian Sea horizon.',
                    'image_urls'         => json_encode(['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80','https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80','https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80']),
                    'video_url'          => 'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4',
                    'timeline'           => json_encode([['phase'=>'Foundation','duration'=>'3 Months','description'=>'Deep-pile anchoring into coastal rock.'],['phase'=>'Steel Framing','duration'=>'4 Months','description'=>'Super-slim structural steel layout.'],['phase'=>'Glass Installation','duration'=>'3 Months','description'=>'Double-laminated structural glass fitment.'],['phase'=>'Finishes & Handover','duration'=>'8 Months','description'=>'Travertine tiling and smart-home programming.']]),
                    'category'           => 'residential',
                    'is_featured'        => 1,
                    'created_at'         => now(), 'updated_at' => now(),
                ],
                [
                    'name'               => 'Aura Commercial Center',
                    'client'             => 'Aura Group Holdings',
                    'location'           => 'Worli, Mumbai',
                    'budget'             => '₹48.5 Crore',
                    'completion_date'    => 'March 2026',
                    'duration'           => '24 Months',
                    'architecture_style' => 'Parametric High-Tech',
                    'description'        => 'An architectural statement featuring a twisted dynamic steel structure, double-skin self-ventilating facade, and multi-level sky gardens serving as communal workspace hubs in Mumbai.',
                    'image_urls'         => json_encode(['https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80','https://images.unsplash.com/photo-1449034446853-66c86144b0ad?auto=format&fit=crop&w=1200&q=80']),
                    'video_url'          => 'https://assets.mixkit.co/videos/preview/mixkit-modern-city-skyscrapers-business-district-41920-large.mp4',
                    'timeline'           => json_encode([['phase'=>'Excavation','duration'=>'5 Months','description'=>'Three-level underground parking excavation.'],['phase'=>'Concrete Core','duration'=>'7 Months','description'=>'Slipformed central elevator structural concrete core.'],['phase'=>'Steel Facade','duration'=>'6 Months','description'=>'Curtain-wall shell and structural steel assembly.'],['phase'=>'Interior Systems','duration'=>'6 Months','description'=>'HVAC and mechanical networks.']]),
                    'category'           => 'commercial',
                    'is_featured'        => 1,
                    'created_at'         => now(), 'updated_at' => now(),
                ],
                [
                    'name'               => 'Zen Horizon Villa',
                    'client'             => 'Dr. Liam Thorne',
                    'location'           => 'Udaipur, Rajasthan',
                    'budget'             => '₹6.8 Crore',
                    'completion_date'    => 'December 2024',
                    'duration'           => '14 Months',
                    'architecture_style' => 'Japanese Organic Modernism',
                    'description'        => 'Blending traditional courtyard architecture with modern structural concrete. Features custom cedar wood screens, tatami lounge integration, and a central rock garden with trickling spring water in Udaipur.',
                    'image_urls'         => json_encode(['https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80','https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=1200&q=80']),
                    'video_url'          => '',
                    'timeline'           => json_encode([['phase'=>'Grading','duration'=>'2 Months','description'=>'Terraced hillside grading and retaining walls.'],['phase'=>'Wood Joinery','duration'=>'5 Months','description'=>'Traditional mortarless joinery assembly.'],['phase'=>'Interior Trim','duration'=>'4 Months','description'=>'Shoji screens and custom tatami mats placement.'],['phase'=>'Landscaping','duration'=>'3 Months','description'=>'Authentic Zen stone garden arrangement.']]),
                    'category'           => 'villa',
                    'is_featured'        => 1,
                    'created_at'         => now(), 'updated_at' => now(),
                ],
            ]);
            echo "Seeded: Projects\n";
        }

        // 4. Gallery
        if (GalleryItem::count() === 0) {
            GalleryItem::insert([
                ['title'=>'Living Room Minimalist Plaster','category'=>'interior','image_url'=>'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80','is_video'=>0,'video_url'=>null,'three_sixty_url'=>null,'created_at'=>now(),'updated_at'=>now()],
                ['title'=>'Board Formed Concrete Facade','category'=>'residential','image_url'=>'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80','is_video'=>0,'video_url'=>null,'three_sixty_url'=>null,'created_at'=>now(),'updated_at'=>now()],
                ['title'=>'Skyscraper Steel Framing','category'=>'commercial','image_url'=>'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80','is_video'=>0,'video_url'=>null,'three_sixty_url'=>null,'created_at'=>now(),'updated_at'=>now()],
                ['title'=>'Travertine Floating Stairs','category'=>'interior','image_url'=>'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80','is_video'=>0,'video_url'=>null,'three_sixty_url'=>null,'created_at'=>now(),'updated_at'=>now()],
                ['title'=>'Oceanfront Pool Overhang','category'=>'residential','image_url'=>'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80','is_video'=>0,'video_url'=>null,'three_sixty_url'=>null,'created_at'=>now(),'updated_at'=>now()],
            ]);
            echo "Seeded: Gallery\n";
        }

        // 5. Testimonials
        if (Testimonial::count() === 0) {
            Testimonial::insert([
                ['client_name'=>'Alexander Vance','client_role'=>'Owner, Glass Pavilion','rating'=>5,'feedback'=>'Video Review: Complete architectural milestone achieved with Maha Construction.','image_url'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80','video_url'=>'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4','project_name'=>'The Glass Pavilion (Alibaug)','duration'=>'2:45','created_at'=>now(),'updated_at'=>now()],
                ['client_name'=>'Sarah Jenkins & Family','client_role'=>'VP Operations, Aura Group','rating'=>5,'feedback'=>'Video Review: Complex parametric high-rise delivered ahead of schedule.','image_url'=>'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80','video_url'=>'https://assets.mixkit.co/videos/preview/mixkit-modern-city-skyscrapers-business-district-41920-large.mp4','project_name'=>'Aura Commercial Center (Mumbai)','duration'=>'3:10','created_at'=>now(),'updated_at'=>now()],
                ['client_name'=>'Mr. Suresh Kumar','client_role'=>'Homeowner, Nagercoil','rating'=>5,'feedback'=>'Video Review: Maha Construction delivered our dream home beyond expectations.','image_url'=>'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80','video_url'=>'https://assets.mixkit.co/videos/preview/mixkit-modern-apartment-with-swimming-pool-42352-large.mp4','project_name'=>'3,200 sq.ft Luxury Villa','duration'=>'2:30','created_at'=>now(),'updated_at'=>now()],
            ]);
            echo "Seeded: Testimonials\n";
        }

        // 6. FAQs
        if (FAQItem::count() === 0) {
            FAQItem::insert([
                ['question'=>"What is Maha Construction's design-build philosophy?",'answer'=>"We believe in 'honest materialism'—letting raw board-formed concrete, structural steel, natural stone, and cedar timber speak for themselves. We operate a fully integrated architectural and engineering service to minimize site revisions.",'category'=>'Process','created_at'=>now(),'updated_at'=>now()],
                ['question'=>'Do you build in international jurisdictions?','answer'=>'Yes, we construct high-end residential and commercial landmarks globally, utilizing regional craft masters while maintaining strict oversight through our central engineering and project management office.','category'=>'Operations','created_at'=>now(),'updated_at'=>now()],
                ['question'=>'How is sustainability incorporated?','answer'=>'We construct carbon-neutral systems. By implementing thick geothermal slabs, high-performance insulated glazing, and solar photovoltaic pergolas, our buildings routinely achieve top green building standard ratings.','category'=>'Sustainability','created_at'=>now(),'updated_at'=>now()],
            ]);
            echo "Seeded: FAQs\n";
        }

        // 7. Packages
        if (PackageDetail::count() === 0) {
            PackageDetail::insert([
                ['division'=>'residential','tier'=>'basic','title'=>'Basic Plan','subtitle'=>'Solid & Affordable','price_per_sqft'=>1999,'is_highlighted'=>0,'warranty_years'=>10,'delivery_months'=>12,'description'=>'A solid, cost-effective residential build using quality materials, standard-grade finishes, and proven structural systems — ideal for budget-conscious homeowners.','features'=>json_encode(['Fe-500 TMT steel','Coromandel / ACC cement','M-Sand blockwork','Vitrified floor tiles (2\'×2\')','Parryware CP fittings','Kundan / Anchor concealed wiring','Flush door entry system','Asian Paints Emulsion finish']),'inclusions'=>json_encode(['Site supervision','Civil structural work','Plastering & waterproofing','Electrical wiring (concealed)','Plumbing works','Toilet sanitary fixtures','Main door with frame']),'exclusions'=>json_encode(['Interior design','Modular kitchen','Landscaping','Smart home systems']),'created_at'=>now(),'updated_at'=>now()],
                ['division'=>'residential','tier'=>'premium','title'=>'Premium Plan','subtitle'=>'Quality & Elegance','price_per_sqft'=>2399,'is_highlighted'=>1,'warranty_years'=>15,'delivery_months'=>14,'description'=>'A premium residential construction package with superior materials, polished finishes, and enhanced structural systems — built for growing families seeking elevated quality.','features'=>json_encode(['Fe-550 TMT (JSW / Vizag Steel)','Ultratech Premium / Dalmia cement','Double-washed M-Sand','Kajaria double charged tiles (4\'×2\')','Jaquar sanitary & CP sets','Polycab wires & Roma switches','Teak wood entry door','Asian Paints Apex Ultima']),'inclusions'=>json_encode(['All Basic inclusions','Modular kitchen carcass','Premium tile work','CCTV provision','Power backup provision','Gypsum ceiling in living areas']),'exclusions'=>json_encode(['Interior furniture','Landscaping','Smart automation']),'created_at'=>now(),'updated_at'=>now()],
                ['division'=>'residential','tier'=>'luxury','title'=>'Luxury Plan','subtitle'=>'Elite Craftsmanship','price_per_sqft'=>2999,'is_highlighted'=>0,'warranty_years'=>20,'delivery_months'=>18,'description'=>'A fully bespoke luxury residential build using world-class materials, custom architectural details, and premium brand fixtures — crafted for discerning homeowners.','features'=>json_encode(['Fe-550 TMT (Tata Tiscon / JSPL)','Birla Super / ACC Gold cement','River sand / premium concrete sand','Italian Travertine / marble slabs','Kohler / Grohe collection','Finolex cables & Legrand switches','First-grade carved teak doors','Royale textured / custom panel finish']),'inclusions'=>json_encode(['All Premium inclusions','Full modular kitchen','Smart home pre-wiring','Home theatre provision','Landscape design (basic)','Custom ceiling designs','Premium bathroom accessories']),'exclusions'=>json_encode(['Smart home devices','Furniture & furnishings']),'created_at'=>now(),'updated_at'=>now()],
                ['division'=>'commercial','tier'=>'basic','title'=>'Standard Shell','subtitle'=>'Functional & Efficient','price_per_sqft'=>2199,'is_highlighted'=>0,'warranty_years'=>10,'delivery_months'=>14,'description'=>'A functional, code-compliant commercial shell ideal for office spaces, retail outlets, and light commercial use — efficient and cost-effective at scale.','features'=>json_encode(['Fe-500 TMT structural steel','OPC 53 grade cement','RCC framed structure','Vitrified floor tiles','Standard plumbing systems','Industrial-grade electrical wiring','Aluminium doors & windows','Exterior cement texture paint']),'inclusions'=>json_encode(['Core structural work','Basic MEP (electrical & plumbing)','Slab & column concrete','External plastering','Staircase with MS railing','Commercial-grade flooring','Waterproofing of terrace']),'exclusions'=>json_encode(['Interior partitions','HVAC systems','False ceiling','Fire safety systems']),'created_at'=>now(),'updated_at'=>now()],
                ['division'=>'commercial','tier'=>'premium','title'=>'Premium Corporate','subtitle'=>'Professional & Polished','price_per_sqft'=>2799,'is_highlighted'=>1,'warranty_years'=>15,'delivery_months'=>18,'description'=>'A professional-grade commercial building with premium structural detailing, enhanced MEP systems, and modern facade finishes — suited for corporate offices and retail centers.','features'=>json_encode(['Fe-550 TMT (JSW Steel)','Ultratech / Ambuja cement','RCC frame + shear walls','Granite / double charged vitrified','Jaquar / Hindware fixtures','Polycab wires + RCCB MCB panel','Anodized aluminium UPVC systems','Texture + reflective glass curtain']),'inclusions'=>json_encode(['All Shell inclusions','False ceiling provision','Lift pit & motor room','HVAC duct provision','Fire hydrant system','CCTV & access control provision','DG set provision']),'exclusions'=>json_encode(['Fit-out interiors','IT infrastructure','Furniture']),'created_at'=>now(),'updated_at'=>now()],
                ['division'=>'commercial','tier'=>'luxury','title'=>'Elite Commercial','subtitle'=>'Iconic Architecture','price_per_sqft'=>3499,'is_highlighted'=>0,'warranty_years'=>20,'delivery_months'=>24,'description'=>'An iconic high-end commercial tower built to global standards — with curtain wall facades, high-capacity MEP systems, and architectural features that define city skylines.','features'=>json_encode(['Fe-550D TMT (SAIL / JSPL)','Birla Aditya / ACC Gold cement','Post-tensioned slabs','Stone cladding / premium marble','Geberit / TOTO commercial fixtures','Legrand Mosaic / Schneider systems','Structural glazing curtain wall','EIFS / metal composite facade']),'inclusions'=>json_encode(['All Premium inclusions','Intelligent BMS system','Full fire suppression system','VRF HVAC system','High-speed elevator system','Basement parking structure','Green building LEED compliance','Architectural lighting design']),'exclusions'=>json_encode(['Tenant fit-out works','IT & AV systems']),'created_at'=>now(),'updated_at'=>now()],
            ]);
            echo "Seeded: Packages\n";
        }

        // 8. Partners
        if (Partner::count() === 0) {
            Partner::insert([
                ['name'=>'HDFC BANK','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1541354329998-f4d9a9f9297f?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.hdfcbank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'STATE BANK OF INDIA','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1501167786227-4cba60f6d58f?auto=format&fit=crop&w=150&q=80','website_url'=>'https://sbi.co.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'ICICI BANK','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.icicibank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'AXIS BANK','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.axisbank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'KOTAK MAHINDRA','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.kotak.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'YES BANK','division'=>'banking','logo_url'=>'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.yesbank.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'IDFC FIRST BANK','division'=>'banking','logo_url'=>null,'website_url'=>'https://www.idfcfirstbank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'INDIAN BANK','division'=>'banking','logo_url'=>null,'website_url'=>'https://www.indianbank.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'UCO BANK','division'=>'banking','logo_url'=>null,'website_url'=>'https://www.ucobank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'BANK OF INDIA','division'=>'banking','logo_url'=>null,'website_url'=>'https://bankofindia.co.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'CANARA BANK','division'=>'banking','logo_url'=>null,'website_url'=>'https://canarabank.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'JSW STEEL','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.jsw.in/steel','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'ASIAN PAINTS','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.asianpaints.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'KAJARIA TILES','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.kajariaceramics.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'RAMCO SUPERGRADE','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.ramco.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'PARRYWARE','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.parryware.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'NIPPON PAINT','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.nipponpaint.co.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'JAQUAR','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.jaquar.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'TATA TISCON','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.tatatiscon.co.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'ULTRATECH CEMENT','division'=>'vendor','logo_url'=>null,'website_url'=>'https://www.ultratechcement.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'TATA PROJECTS','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1541888946425-d0fbb186a5b3?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.tataprojects.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'LARSEN & TOUBRO','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.larsentoubro.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'RELIANCE INFRA','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.rinfra.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'GODREJ PROPERTIES','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.godrejproperties.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'SHAPOORJI PALLONJI','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.shapoorjipallonji.com','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
                ['name'=>'DLF LIMITED','division'=>'joint_venture','logo_url'=>'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=150&q=80','website_url'=>'https://www.dlf.in','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
            ]);
            echo "Seeded: Partners\n";
        }

        // 9. Settings
        Setting::firstOrCreate(['key' => 'youtube_channel_url'], ['value' => 'https://www.youtube.com/@mahaconstructions2013']);
        Setting::firstOrCreate(['key' => 'company_phone'], ['value' => '+91 94430 08095']);
        Setting::firstOrCreate(['key' => 'company_email'], ['value' => 'Mahaconstructions2013@gmail.com']);
        // 10. Guidebook Leads
        if (\App\Models\GuidebookLead::count() === 0) {
            \App\Models\GuidebookLead::insert([
                ['name' => 'Vichu', 'phone' => '6374049606', 'email' => 'rajanmaha554@gmail.com', 'created_at' => now()->subHours(2), 'updated_at' => now()->subHours(2)],
                ['name' => 'Thenkarai', 'phone' => '6374049606', 'email' => 'rajanmaha554@gmail.com', 'created_at' => now()->subHours(4), 'updated_at' => now()->subHours(4)],
            ]);
            echo "Seeded: Guidebook Leads\n";
        }
    }
}
