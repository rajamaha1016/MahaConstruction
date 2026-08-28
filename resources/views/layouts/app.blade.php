<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Maha Construction | Premium Luxury Architectural Masterpieces')</title>
    <meta name="description" content="@yield('description', 'Maha Construction is Tamil Nadu\'s premier government-registered engineering firm delivering custom luxury villas, residential residences, and architectural homes.')"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>
<body class="dark-theme">
    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="custom-cursor-dot" id="cursor-dot"></div>

    <!-- Top Announcement Header Bar -->
    <div class="top-announcement-bar">
        <div class="container top-bar-content">
            <div class="top-bar-left">
                <span class="pulse-dot"></span>
                <span>FREE SITE VISIT INCLUDED</span>
            </div>
            <div class="top-bar-right">
                <span>DIRECT CALL: <a href="tel:+919488888758" class="phone-link">+91 94888 88758</a></span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <!-- EXCLUSIVE ATTRACTIVE LOGO -->
            <a href="{{ route('home') }}" class="nav-logo" style="display:inline-flex;align-items:center;gap:14px;text-decoration:none;">
                <div style="background:#FFFFFF;padding:5px 12px;border-radius:12px;border:1.5px solid #D4AF37;box-shadow:0 4px 18px rgba(0,0,0,0.4),0 0 15px rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 22px rgba(212,175,55,0.5),0 0 20px rgba(212,175,55,0.4)';this.style.transform='scale(1.02)';" onmouseout="this.style.boxShadow='0 4px 18px rgba(0,0,0,0.4),0 0 15px rgba(212,175,55,0.3)';this.style.transform='scale(1)';">
                    <img src="{{ asset('logo.jpg') }}"
                         alt="Maha Constructions Logo"
                         style="height:48px;width:auto;object-fit:contain;display:block;">
                </div>
                <div style="display:flex;flex-direction:column;justify-content:center;">
                    <span style="font-size:1.1rem;font-weight:900;letter-spacing:0.06em;color:#FFFFFF;line-height:1.2;font-family:'Outfit',sans-serif;text-shadow:0 2px 10px rgba(0,0,0,0.5);">MAHA CONSTRUCTIONS</span>
                    <span style="font-size:0.62rem;font-weight:700;letter-spacing:0.2em;color:#D4AF37;text-transform:uppercase;margin-top:3px;font-family:'Outfit',sans-serif;">WE BUILD YOUR DREAM HOME</span>
                </div>
            </a>

            <div class="nav-menu" id="navMenu">
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">HOME</a>
                <a href="{{ route('pricing') }}" class="nav-item {{ request()->routeIs('pricing') ? 'active' : '' }}">PACKAGES</a>
                <a href="{{ route('projects') }}" class="nav-item {{ request()->routeIs('projects') ? 'active' : '' }}">PROJECTS</a>
            </div>

            <div class="nav-actions">
                <button class="nav-search-btn" id="searchToggleBtn" title="Search">
                    <i class="fas fa-search" style="font-size:16px;"></i>
                </button>
                <button class="btn-gold-pill" data-open-quote>
                    <i class="fas fa-calendar-check" style="margin-right:6px;"></i>
                    BOOK FREE CONSULTATION
                </button>
                <button class="nav-mobile-toggle" id="navMobileToggle" aria-label="Toggle Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box-container">
            <input type="text" placeholder="Search projects, packages, services..." id="searchInput">
            <button class="search-close-btn" id="searchCloseBtn">✕</button>
        </div>
    </div>

    <!-- Fixed Floating Right Action Bar -->
    <div class="floating-actions-bar">
        <button class="float-btn chat-btn" data-open-quote title="Chat with Us">
            <i class="fas fa-comments" style="font-size:18px;"></i>
        </button>
        <a href="https://wa.me/919488888758?text=Hello%20Er.%20Maha%20Rajan%2C%20I%20want%20to%20consult%20for%20my%20luxury%20home." target="_blank" class="float-btn whatsapp-btn" title="WhatsApp Direct">
            <i class="fab fa-whatsapp" style="font-size:22px;"></i>
        </a>
        <a href="tel:+919488888758" class="float-btn phone-btn" title="Call Us">
            <i class="fas fa-phone" style="font-size:18px;"></i>
        </a>
        <button class="float-btn quote-btn" data-open-quote title="Get Free Estimate">
            <i class="fas fa-file-invoice" style="font-size:18px;"></i>
        </button>
        <button class="float-btn back-top-btn" id="backToTopBtn" title="Back to Top">
            <i class="fas fa-chevron-up" style="font-size:16px;"></i>
        </button>
    </div>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-top-grid">
                <div class="footer-brand-col">
                    <div class="footer-logo">
                        <div class="logo-badge" style="background:#FFFFFF;padding:4px 10px;border-radius:10px;border:1.5px solid #D4AF37;box-shadow:0 4px 14px rgba(0,0,0,0.4),0 0 12px rgba(212,175,55,0.25);">
                            <img src="{{ asset('logo.jpg') }}" alt="Maha Constructions Logo" style="height:36px;width:auto;object-fit:contain;display:block;">
                        </div>
                        <div class="logo-text-group">
                            <span class="logo-brand">MAHA CONSTRUCTIONS</span>
                            <span class="logo-tagline">WE BUILD YOUR DREAM HOME</span>
                        </div>
                    </div>
                    <p class="footer-desc">
                        Building luxury homes with quality, itemized transparency, and structural trust. Er. Maha Rajan (Government Registered Engineer) leading 10+ years of structural engineering excellence across Tamil Nadu.
                    </p>
                    <div class="footer-social-row">
                        <a href="https://www.instagram.com/mahaconstructions_2013" target="_blank" class="social-icon-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/mahaconstructions" target="_blank" class="social-icon-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $yt_channel_url }}" target="_blank" class="social-icon-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-heading">QUICK LINKS</h4>
                    <ul class="footer-nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('pricing') }}">Packages</a></li>
                        <li><a href="{{ route('projects') }}">Projects</a></li>
                        <li><a href="{{ route('testimonials') }}">Client Testimonials</a></li>
                    </ul>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-heading">OUR SERVICES</h4>
                    <ul class="footer-nav">
                        <li><a href="{{ route('services') }}">Luxury Residential Construction</a></li>
                        <li><a href="{{ route('services') }}">Villa & Bungalow Construction</a></li>
                        <li><a href="{{ route('services') }}">Premium Interior Fitouts</a></li>
                        <li><a href="{{ route('services') }}">Structural Engineering Audits</a></li>
                        <li><a href="{{ route('services') }}">3D Architectural Elevation & Vastu</a></li>
                        <li><a href="{{ route('services') }}">Government Approval Processing</a></li>
                    </ul>
                </div>

                <div class="footer-contact-col">
                    <h4 class="footer-heading">CONTACT US</h4>
                    <div class="footer-contact-item">
                        <span class="contact-label">Office:</span>
                        <span>+91 94888 88758 / Engr: +91 90959 29543</span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="contact-label">Email:</span>
                        <span>Mahaconstructions2013@gmail.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="contact-label">Web:</span>
                        <span>www.mahaconstructions.in</span>
                    </div>
                    <div class="footer-contact-item">
                        <span class="contact-label">Address:</span>
                        <span>Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil</span>
                    </div>
                </div>
            </div>

            <div class="footer-location-strip">
                <span><i class="fas fa-map-marker-alt" style="margin-right:6px;color:var(--gold);"></i> <strong>Office Location:</strong> Nagercoil, Kanyakumari, Tamil Nadu</span>
                <a href="https://maps.google.com" target="_blank" class="map-link">VIEW ON GOOGLE MAPS <i class="fas fa-arrow-right" style="margin-left:6px;"></i></a>
            </div>

            <div class="footer-bottom-bar">
                <p>© {{ date('Y') }} MAHA CONSTRUCTIONS. Er. Maha Rajan (Government Registered Engineer). All rights reserved.</p>
                <div class="footer-legal-links">
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <span class="sep">•</span>
                    <a href="{{ route('terms') }}">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Video Popup Modal Player (HireAndBuild Interactive Story Model) -->
    <div class="modal-backdrop" id="videoModal">
        <div class="video-modal-content" style="max-width:880px;background:#050B14;border:1.5px solid #D4AF37;border-radius:24px;padding:24px;box-shadow:0 20px 60px rgba(0,0,0,0.8),0 0 30px rgba(212,175,55,0.2);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid rgba(212,175,55,0.25);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="width:8px;height:8px;background:#25D366;border-radius:50%;display:inline-block;box-shadow:0 0 8px #25D366;"></span>
                    <span id="modalVideoTitle" style="font-size:0.95rem;font-weight:800;color:#FFFFFF;letter-spacing:0.04em;">MAHA CONSTRUCTIONS STORY</span>
                </div>
                <button class="modal-close-icon" id="closeVideoModal" style="position:static;font-size:1.1rem;color:#D4AF37;background:rgba(212,175,55,0.1);width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,0.3);"><i class="fas fa-xmark"></i></button>
            </div>

            <div class="video-container" style="background:#000;border-radius:14px;overflow:hidden;">
                <video id="modalVideoPlayer" controls autoplay playsinline style="width:100%;max-height:68vh;border-radius:14px;display:block;"></video>
                <iframe id="modalYoutubePlayer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;height:68vh;border-radius:14px;display:none;"></iframe>
            </div>

            <!-- In-Modal Story Switcher Controls -->
            <div id="modalStorySwitcher" style="display:none;justify-content:space-between;align-items:center;margin-top:16px;padding-top:14px;border-top:1px solid rgba(212,175,55,0.2);">
                <button id="modalPrevStoryBtn" style="display:inline-flex;align-items:center;gap:6px;background:rgba(212,175,55,0.12);color:#D4AF37;border:1px solid rgba(212,175,55,0.35);padding:8px 16px;border-radius:20px;font-size:0.78rem;font-weight:800;letter-spacing:0.04em;cursor:pointer;">
                    <i class="fas fa-arrow-left"></i> PREV STORY
                </button>
                <span id="modalStoryCounter" style="font-size:0.75rem;color:#94A3B8;font-weight:700;letter-spacing:0.1em;">STORY 1 / 2</span>
                <button id="modalNextStoryBtn" style="display:inline-flex;align-items:center;gap:6px;background:rgba(212,175,55,0.12);color:#D4AF37;border:1px solid rgba(212,175,55,0.35);padding:8px 16px;border-radius:20px;font-size:0.78rem;font-weight:800;letter-spacing:0.04em;cursor:pointer;">
                    NEXT STORY <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Request Free Estimate / Consultation Modal -->
    <div class="modal-backdrop" id="quoteModal">
        <div class="quote-modal-content">
            <button class="modal-close-icon" id="closeQuoteModal"><i class="fas fa-xmark"></i></button>
            <div class="modal-header-tag">FREE SITE CONSULTATION & ESTIMATE</div>
            <h2 class="modal-title-text">REQUEST FREE ESTIMATE</h2>
            <form id="quoteModalForm" class="quote-form-grid">
                <div class="form-field full-width">
                    <label>FULL NAME *</label>
                    <input type="text" name="name" required placeholder="Enter your full name">
                </div>
                <div class="form-field">
                    <label>EMAIL ADDRESS *</label>
                    <input type="email" name="email" required placeholder="name@gmail.com">
                </div>
                <div class="form-field">
                    <label>TELEPHONE *</label>
                    <input type="tel" name="phone" required placeholder="+91 94888 88758">
                </div>
                <div class="form-field">
                    <label>PROJECT TYPE</label>
                    <select name="project_type">
                        <option>Residential Villa</option>
                        <option>Commercial Building</option>
                        <option>Interior Design</option>
                        <option>Structural Engineering</option>
                    </select>
                </div>
                <div class="form-field">
                    <label>BUDGET RANGE</label>
                    <select name="budget_range">
                        <option>₹30 Lakhs - ₹50 Lakhs</option>
                        <option>₹50 Lakhs - ₹1 Crore</option>
                        <option>₹1 Crore - ₹3 Crore</option>
                        <option>₹3 Crore+</option>
                    </select>
                </div>
                <div class="form-field full-width">
                    <label>SITE NOTES & VISIONS</label>
                    <textarea name="message" rows="3" placeholder="Tell us about your plot size, location, or requirements..."></textarea>
                </div>
                <div class="form-field full-width">
                    <button type="submit" class="btn-gold-submit" id="quoteSubmitBtn">
                        <i class="fas fa-paper-plane" style="margin-right:6px;"></i> SUBMIT PROPOSAL REQUEST
                    </button>
                </div>
                <div id="quoteSuccessMessage" class="form-success-box" style="display:none;">
                    <i class="fas fa-circle-check" style="margin-right:6px;color:#25D366;"></i> Proposal Request Logged! Er. Maha Rajan will contact you directly within 24 hours.
                </div>
            </form>
        </div>
    </div>

    <!-- Construction Packages Comparison Matrix Modal -->
    <div class="modal-backdrop" id="packageMatrixModal">
        <div class="matrix-modal-content">
            <button class="modal-close-icon" id="closeMatrixModal"><i class="fas fa-xmark"></i></button>
            <div class="matrix-modal-header">
                <h3>CONSTRUCTION PACKAGES COMPARISON MATRIX</h3>
            </div>
            <div class="table-responsive">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>FEATURE</th>
                            <th>BASIC (₹1,999)</th>
                            <th>STANDARD (₹2,100)</th>
                            <th>PREMIUM (₹2,799)</th>
                            <th>LUXURY (₹3,499)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="feature-title">Steel Grade</td>
                            <td>Fe-500 TMT</td>
                            <td>Fe-550 JSW/Tata</td>
                            <td>Tata Tiscon</td>
                            <td>Tata Tiscon Super</td>
                        </tr>
                        <tr>
                            <td class="feature-title">Flooring</td>
                            <td>Vitrified Tiles (₹55/sqft)</td>
                            <td>Kajaria Tiles (₹75/sqft)</td>
                            <td>Granite / Vitrified (₹130/sqft)</td>
                            <td>Italian Marble (₹250+/sqft)</td>
                        </tr>
                        <tr>
                            <td class="feature-title">Sanitary Fittings</td>
                            <td>Parryware / Cera</td>
                            <td>Jaquar Collection</td>
                            <td>Kohler Collection</td>
                            <td>Grohe / Kohler Imported</td>
                        </tr>
                        <tr>
                            <td class="feature-title">Main Door</td>
                            <td>Flush Door</td>
                            <td>Teak Wood Frame</td>
                            <td>Solid Teak Wood</td>
                            <td>Custom Carved Luxury Teak</td>
                        </tr>
                        <tr>
                            <td class="feature-title">Warranty</td>
                            <td>10 Years</td>
                            <td>10 Years</td>
                            <td>15 Years</td>
                            <td>20 Years Registered</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="matrix-modal-footer">
                <button class="btn-close-matrix" id="btnCloseMatrix">CLOSE COMPARISON</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
