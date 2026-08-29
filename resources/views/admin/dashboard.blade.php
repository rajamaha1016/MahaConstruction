<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maha Constructions Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { background: #050B14; color: #F0EBE0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 320px; flex-shrink: 0; background: #0B132B;
            border-right: 1px solid rgba(212, 175, 55, 0.25); padding: 24px 0;
            position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100;
        }
        .admin-sidebar-logo { padding: 0 24px 20px; border-bottom: 1px solid rgba(212, 175, 55, 0.2); margin-bottom: 20px; }
        .admin-title-badge { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: 0.05em; }
        .admin-sub-badge { font-family: 'Montserrat', sans-serif; font-size: 0.65rem; color: #D4AF37; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px; }
        
        .sidebar-nav-list { list-style: none; display: flex; flex-direction: column; gap: 8px; padding: 0 16px; }
        .sidebar-nav-link {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 18px; border-radius: 12px; font-size: 0.85rem; font-weight: 600;
            color: #94A3B8; transition: all 0.2s; border: 1px solid transparent; text-transform: uppercase;
            font-family: 'Montserrat', sans-serif; letter-spacing: 0.04em;
        }
        .sidebar-nav-link:hover, .sidebar-nav-link.active {
            background: rgba(212, 175, 55, 0.12); color: #D4AF37; border-color: rgba(212, 175, 55, 0.3);
        }
        .badge-count {
            background: rgba(212, 175, 55, 0.2); color: #D4AF37;
            padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }

        .admin-main-view { margin-left: 320px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .admin-header-bar {
            background: #0B132B; border-bottom: 1px solid rgba(212, 175, 55, 0.25);
            padding: 18px 36px; display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 90;
        }
        .admin-panel-title { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: 0.05em; }
        .admin-panel-sub { font-family: 'Montserrat', sans-serif; font-size: 0.7rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; }

        .admin-body-content { padding: 36px; flex: 1; }
        .admin-tab-pane { display: none; }
        .admin-tab-pane.active { display: block; }

        .card-dark-panel {
            background: #0B132B; border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 20px; padding: 28px; margin-bottom: 28px;
        }
        .panel-header-title { font-family: 'Montserrat', sans-serif; font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 6px; text-transform: uppercase; }
        .panel-header-sub { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #94A3B8; margin-bottom: 24px; }

        .table-custom-dark { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table-custom-dark th { font-family: 'Montserrat', sans-serif; background: #050B14; color: #D4AF37; padding: 14px 18px; font-size: 0.8rem; font-weight: 700; text-align: left; border: 1px solid rgba(212, 175, 55, 0.2); }
        .table-custom-dark td { font-family: 'Inter', sans-serif; padding: 14px 18px; border: 1px solid rgba(212, 175, 55, 0.15); color: #F0EBE0; font-size: 0.88rem; }

        .action-del-btn {
            background: rgba(255, 59, 48, 0.15); color: #FF3B30; border: 1px solid rgba(255, 59, 48, 0.3);
            width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;
        }
        .action-del-btn:hover { background: rgba(255, 59, 48, 0.3); transform: scale(1.05); }

        .action-edit-btn {
            background: rgba(212, 175, 55, 0.15); color: #D4AF37; border: 1px solid rgba(212, 175, 55, 0.4);
            width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;
        }
        .action-edit-btn:hover { background: #D4AF37; color: #050B14; transform: scale(1.05); }

        /* ─── Compact & Attractive Card & Grid Styling ─── */
        .projects-grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
            gap: 18px !important;
            margin-top: 20px !important;
        }
        .project-video-card {
            background: #050B14;
            border: 1px solid rgba(212, 175, 55, 0.22);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }
        .project-video-card:hover {
            border-color: #D4AF37;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.15);
        }
        .project-video-card .video-thumb-frame {
            height: 160px !important;
            position: relative;
            background: #000;
            overflow: hidden;
        }
        .project-video-card .video-thumb-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .project-video-card:hover .video-thumb-frame img {
            transform: scale(1.04);
        }
        .project-card-info {
            padding: 12px 14px !important;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .project-card-info h4 {
            font-size: 0.92rem !important;
            font-weight: 700;
            line-height: 1.35;
            margin: 0 0 4px 0;
            color: #fff;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .play-btn-circle {
            width: 44px !important;
            height: 44px !important;
            font-size: 0.95rem !important;
            background: #D4AF37 !important;
            color: #050B14 !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.5) !important;
        }

        @media (max-width: 992px) {
            .admin-layout { flex-direction: column; }
            .admin-sidebar {
                position: static;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid rgba(212, 175, 55, 0.25);
                padding: 16px;
            }
            .admin-main-view { margin-left: 0; }
            .admin-header-bar { padding: 14px 18px; flex-wrap: wrap; gap: 10px; }
            .admin-body-content { padding: 18px 12px; }
            .card-dark-panel { padding: 18px 12px; border-radius: 14px; }
            .sidebar-nav-list { display: flex; flex-wrap: wrap; gap: 6px; }
            .sidebar-nav-link { padding: 8px 12px; font-size: 0.74rem; }
            .admin-sidebar-logo { margin-bottom: 12px; padding-bottom: 10px; }
        }
        /* Custom Animated Delete Confirmation Modal */
        .delete-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(3, 7, 18, 0.82);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 18px;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .delete-modal-backdrop.show {
            opacity: 1;
        }

        .delete-modal-card {
            background: radial-gradient(130% 120% at 50% 0%, #172133 0%, #0A111E 65%, #050B14 100%);
            border: 1.5px solid rgba(239, 68, 68, 0.5);
            box-shadow: 0 0 50px rgba(239, 68, 68, 0.22), 0 25px 60px -12px rgba(0, 0, 0, 0.9);
            border-radius: 24px;
            padding: 34px 28px 26px;
            width: 100%;
            max-width: 440px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: scale(0.8) translateY(24px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .delete-modal-backdrop.show .delete-modal-card {
            transform: scale(1) translateY(0);
        }

        .delete-icon-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-icon-glow {
            position: absolute;
            inset: -6px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.55) 0%, rgba(239, 68, 68, 0) 70%);
            border-radius: 50%;
            animation: pulseRedGlow 2.2s infinite ease-in-out;
        }

        .delete-icon-circle {
            position: relative;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(145deg, rgba(239, 68, 68, 0.22), rgba(153, 27, 27, 0.45));
            border: 2px solid rgba(239, 68, 68, 0.65);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 16px rgba(239, 68, 68, 0.35);
            animation: bounceTrashIcon 2.6s infinite ease-in-out;
        }

        .delete-icon-symbol {
            font-size: 2rem;
            color: #EF4444;
            filter: drop-shadow(0 2px 8px rgba(239, 68, 68, 0.6));
        }

        @keyframes pulseRedGlow {
            0%, 100% { transform: scale(0.95); opacity: 0.5; }
            50% { transform: scale(1.18); opacity: 0.95; }
        }

        @keyframes bounceTrashIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .delete-modal-title {
            font-family: 'Cinzel', serif, Georgia;
            color: #FFFFFF;
            font-size: 1.22rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .delete-modal-description {
            color: #94A3B8;
            font-size: 0.88rem;
            line-height: 1.55;
            margin-bottom: 24px;
            padding: 0 6px;
        }

        .delete-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-delete-cancel {
            flex: 1;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #E2E8F0;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 12px 18px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-delete-cancel:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            color: #FFFFFF;
            transform: translateY(-1px);
        }

        .btn-delete-confirm {
            flex: 1.2;
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            border: 1px solid #EF4444;
            box-shadow: 0 4px 18px rgba(220, 38, 38, 0.4);
            color: #FFFFFF;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            padding: 12px 18px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-delete-confirm:hover {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            box-shadow: 0 6px 24px rgba(239, 68, 68, 0.65);
            transform: translateY(-2px) scale(1.02);
        }

        .btn-delete-confirm:active {
            transform: translateY(0) scale(0.98);
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <div class="admin-title-badge">MAHA CONSTRUCTIONS</div>
            <div class="admin-sub-badge">ADMIN PANEL</div>
        </div>
        <ul class="sidebar-nav-list">
            <li>
                <a href="#" class="sidebar-nav-link active" onclick="switchAdminTab('reviews', this)">
                    <span>CLIENT VIDEO REVIEWS</span>
                    <span class="badge-count">{{ \App\Models\Testimonial::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('projects', this)">
                    <span>COMPLETED PROJECTS</span>
                    <span class="badge-count">{{ \App\Models\Project::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('packages', this)">
                    <span>CONSTRUCTION PACKAGES</span>
                    <span class="badge-count">{{ \App\Models\PackageDetail::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('partners', this)">
                    <span>BANKING & VENDORS</span>
                    <span class="badge-count">{{ \App\Models\Partner::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('youtube', this)">
                    <span>YOUTUBE VIDEOS</span>
                    <span class="badge-count" id="sidebarYtCount">{{ ($settings['youtube_video_count'] ?? null)?->value ?? '0' }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('contact', this)">
                    <span>CONTACT DETAILS & ADDRESS</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('guidebook', this)">
                    <span>GUIDEBOOK PDF</span>
                    <span class="badge-count">{{ \App\Models\GuidebookLead::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('intro', this)">
                    <span>INTRO VIDEO</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('security', this)">
                    <span>ADMIN ACCOUNT & SECURITY</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main View -->
    <main class="admin-main-view">
        <!-- Top Bar -->
        <header class="admin-header-bar">
            <div>
                <div class="admin-panel-title">MAHA CONSTRUCTIONS ADMIN PANEL</div>
                <div class="admin-panel-sub">LOCAL FILE UPLOADS & LIVE CONTENT MANAGEMENT</div>
            </div>
            <div style="display:flex;gap:12px;">
                <a href="{{ route('home') }}" target="_blank" class="btn-whatsapp-outline" style="border-color:#D4AF37;color:#D4AF37;padding:8px 18px;font-size:0.8rem;">
                    <i class="fas fa-globe" style="margin-right:6px;"></i> LIVE WEBSITE
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-gold-pill" style="background:rgba(255,59,48,0.2);color:#FF3B30;box-shadow:none;padding:8px 18px;font-size:0.8rem;">
                        <i class="fas fa-arrow-right-from-bracket" style="margin-right:6px;"></i> LOGOUT
                    </button>
                </form>
            </div>
        </header>

        <!-- Body Content -->
        <div class="admin-body-content">

            <!-- 1. CLIENT VIDEO REVIEWS TAB -->
            <div class="admin-tab-pane active" id="tab-reviews">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h2 class="panel-header-title">CLIENT VIDEO TESTIMONIALS</h2>
                            <p class="panel-header-sub">Upload video files or video links from happy homeowners.</p>
                        </div>
                        <button class="btn-gold-pill" onclick="openUploadModal('testimonial')"><i class="fas fa-plus" style="margin-right:6px;"></i> UPLOAD NEW VIDEO REVIEW</button>
                    </div>

                    <div class="projects-grid-2">
                        @foreach(\App\Models\Testimonial::all() as $item)
                        <div class="project-video-card">
                            <div class="video-thumb-frame" style="height:220px;">
                                <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}" style="width:100%;height:100%;object-fit:cover;" alt="Review">
                                <div class="video-play-overlay" onclick="window.playVideoModal('{{ $item->video_url }}')">
                                    <div class="play-btn-circle" style="width:48px;height:48px;font-size:1rem;"><i class="fas fa-play" style="margin-left:2px;"></i></div>
                                </div>
                            </div>
                            <div class="project-card-info" style="display:flex;justify-content:space-between;align-items:center;">
                                <div>
                                    <h4 style="color:#fff;font-size:1.05rem;">{{ $item->client_name }}</h4>
                                    <span style="font-size:0.8rem;color:#D4AF37;">{{ $item->project_name ?? 'Maha Construction' }}</span>
                                </div>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="action-edit-btn" onclick='openEditModal("testimonial", @json($item))' title="Edit Review"><i class="fas fa-pen-to-square"></i></button>
                                    <button type="button" class="action-del-btn" onclick="deleteItem(event, 'testimonials', {{ $item->id }}, this)" title="Delete Review"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 2. COMPLETED PROJECTS TAB -->
            <div class="admin-tab-pane" id="tab-projects">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h2 class="panel-header-title">COMPLETED PROJECTS (VIDEO & PHOTO WALKTHROUGHS)</h2>
                            <p class="panel-header-sub">Upload project walkthroughs (MP4), photo renders & site specs.</p>
                        </div>
                        <button class="btn-gold-pill" onclick="openUploadModal('project')"><i class="fas fa-plus" style="margin-right:6px;"></i> UPLOAD PROJECT VIDEO / PHOTO</button>
                    </div>

                    <div class="projects-grid-2">
                        @foreach(\App\Models\Project::all() as $project)
                        <div class="project-video-card">
                            <div class="video-thumb-frame" style="height:220px;">
                                <img src="{{ ($project->image_urls && count($project->image_urls)>0) ? $project->image_urls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}" style="width:100%;height:100%;object-fit:cover;" alt="Project">
                                @if($project->video_url)
                                <div class="video-play-overlay" onclick="window.playVideoModal('{{ $project->video_url }}')">
                                    <div class="play-btn-circle" style="width:48px;height:48px;font-size:1rem;"><i class="fas fa-play" style="margin-left:2px;"></i></div>
                                </div>
                                @endif
                            </div>
                            <div class="project-card-info" style="display:flex;justify-content:space-between;align-items:center;">
                                <div>
                                    <h4 style="color:#fff;font-size:1.05rem;">{{ $project->name }}</h4>
                                    <span style="font-size:0.8rem;color:#D4AF37;"><i class="fas fa-map-marker-alt" style="margin-right:4px;"></i> {{ $project->location ?? 'Nagercoil' }}</span>
                                </div>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="action-edit-btn" onclick='openEditModal("project", @json($project))' title="Edit Project"><i class="fas fa-pen-to-square"></i></button>
                                    <button type="button" class="action-del-btn" onclick="deleteItem(event, 'projects', {{ $project->id }}, this)" title="Delete Project"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 3. CONSTRUCTION PACKAGES TAB -->
            <div class="admin-tab-pane" id="tab-packages">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h2 class="panel-header-title">CONSTRUCTION PACKAGES</h2>
                            <p class="panel-header-sub">Manage per sq.ft pricing & specs features for Residential & Commercial builds.</p>
                        </div>
                        <button class="btn-gold-pill" onclick="openUploadModal('package')"><i class="fas fa-plus" style="margin-right:6px;"></i> ADD NEW PACKAGE</button>
                    </div>

                    <div class="pricing-grid-3">
                        @foreach(\App\Models\PackageDetail::all() as $package)
                        <div class="package-card" style="padding:20px;">
                            <span class="plan-tier-label">{{ strtoupper($package->division) }} • {{ strtoupper($package->tier) }}</span>
                            <h3 class="plan-title" style="font-size:1.2rem;">{{ $package->title }}</h3>
                            <div class="plan-price" style="font-size:1.5rem;margin:8px 0;">₹{{ number_format($package->price_per_sqft) }} <span>/ sq.ft</span></div>
                            <div style="display:flex;gap:8px;margin-top:12px;">
                                <button type="button" class="action-edit-btn" style="width:auto;padding:6px 14px;gap:6px;" onclick='openEditModal("package", @json($package))' title="Edit Package"><i class="fas fa-pen-to-square"></i> EDIT</button>
                                <button type="button" class="action-del-btn" onclick="deleteItem(event, 'packages', {{ $package->id }}, this)" title="Delete Package"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 4. BANKING & VENDORS TAB -->
            <div class="admin-tab-pane" id="tab-partners">
                @php
                    $allBanking = \App\Models\Partner::where('division', 'banking')->get();
                    $allVendors = \App\Models\Partner::where('division', 'vendor')->get();
                    $allJVs     = \App\Models\Partner::where('division', 'joint_venture')->get();
                @endphp

                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title">BANKING & VENDOR PARTNERS MANAGEMENT</h2>
                            <p class="panel-header-sub">Manually edit, add or upload bank logos for Finance & Loans and vendor material brands.</p>
                        </div>
                        <button class="btn-gold-pill" onclick="openUploadModal('partner')">
                            <i class="fas fa-plus" style="margin-right:6px;"></i> ADD NEW PARTNER / VENDOR
                        </button>
                    </div>

                    <!-- Section A: Banking Partners -->
                    <div style="margin-top:24px;border-top:1px solid rgba(212,175,55,0.2);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <span style="font-size:1.2rem;">🏦</span>
                            <h3 style="font-size:1.05rem;font-weight:800;color:#D4AF37;text-transform:uppercase;margin:0;">
                                BANKING PARTNERS (FINANCE & LOANS) ({{ $allBanking->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @forelse($allBanking as $item)
                            <div class="project-video-card" style="padding:14px;background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;">
                                <div style="background:#FFFFFF;border-radius:10px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,0.3);margin-bottom:10px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:#FFF;font-size:0.92rem;margin:0 0 4px 0;font-weight:800;">{{ $item->name }}</h4>
                                        <span style="font-size:0.7rem;color:#25D366;font-weight:700;"><i class="fas fa-check-circle"></i> Home Loan Partner</span>
                                        @if(!empty($item->website_url))
                                        <div style="margin-top:2px;">
                                            <a href="{{ $item->website_url }}" target="_blank" style="font-size:0.68rem;color:#94A3B8;text-decoration:none;">
                                                <i class="fas fa-link" style="color:#D4AF37;"></i> {{ $item->website_url }}
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit Bank"><i class="fas fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Bank"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:30px;color:#94A3B8;">No banking partners added yet. Click "ADD NEW PARTNER / VENDOR" to add one.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section B: Material Vendors -->
                    <div style="margin-top:36px;border-top:1px solid rgba(212,175,55,0.2);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <span style="font-size:1.2rem;">🏗️</span>
                            <h3 style="font-size:1.05rem;font-weight:800;color:#D4AF37;text-transform:uppercase;margin:0;">
                                TRUSTED MATERIAL VENDORS & BRANDS ({{ $allVendors->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @forelse($allVendors as $item)
                            <div class="project-video-card" style="padding:14px;background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;">
                                <div style="background:#FFFFFF;border-radius:10px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,0.3);margin-bottom:10px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:#FFF;font-size:0.92rem;margin:0 0 4px 0;font-weight:800;">{{ $item->name }}</h4>
                                        <span style="font-size:0.7rem;color:#D4AF37;font-weight:700;"><i class="fas fa-shield-alt"></i> Certified Material Brand</span>
                                        @if(!empty($item->website_url))
                                        <div style="margin-top:2px;">
                                            <a href="{{ $item->website_url }}" target="_blank" style="font-size:0.68rem;color:#94A3B8;text-decoration:none;">
                                                <i class="fas fa-link" style="color:#D4AF37;"></i> {{ $item->website_url }}
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit Vendor"><i class="fas fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Vendor"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:30px;color:#94A3B8;">No material vendors added yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section C: Joint Venture Partners -->
                    @if($allJVs->count() > 0)
                    <div style="margin-top:36px;border-top:1px solid rgba(212,175,55,0.2);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <span style="font-size:1.2rem;">🤝</span>
                            <h3 style="font-size:1.05rem;font-weight:800;color:#D4AF37;text-transform:uppercase;margin:0;">
                                JOINT VENTURE PARTNERS ({{ $allJVs->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @foreach($allJVs as $item)
                            <div class="project-video-card" style="padding:14px;background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;">
                                <div style="background:#FFFFFF;border-radius:10px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,0.3);margin-bottom:10px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:#FFF;font-size:0.92rem;margin:0 0 4px 0;font-weight:800;">{{ $item->name }}</h4>
                                        <span style="font-size:0.7rem;color:#38bdf8;font-weight:700;"><i class="fas fa-handshake"></i> JV Partner</span>
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit JV Partner"><i class="fas fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Partner"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 5. YOUTUBE VIDEOS TAB -->
            <div class="admin-tab-pane" id="tab-youtube">
                @php
                    $ytChannelUrl = ($settings['youtube_channel_url'] ?? null)?->value ?? 'https://www.youtube.com/@mahaconstructions2013';
                    $ytApiKey     = ($settings['youtube_api_key'] ?? null)?->value ?? '';
                    $ytSyncedRaw  = ($settings['youtube_synced_videos'] ?? null)?->value ?? '[]';
                    $ytVideosList = json_decode($ytSyncedRaw, true) ?: [];
                    $ytLastSync   = ($settings['youtube_last_synced_at'] ?? null)?->value ?? null;
                    $ytCount      = ($settings['youtube_video_count'] ?? null)?->value ?? count($ytVideosList);
                    $ytChannelName= ($settings['youtube_channel_name'] ?? null)?->value ?? 'Maha Constructions';
                @endphp

                <!-- Live Channel Controls Card -->
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,0,0,0.12);border:1px solid rgba(255,0,0,0.4);border-radius:20px;padding:4px 14px;margin-bottom:8px;">
                                <i class="fab fa-youtube" style="color:#FF0000;font-size:0.85rem;"></i>
                                <span style="font-size:0.7rem;font-weight:800;letter-spacing:0.1em;color:#FF5555;text-transform:uppercase;">LIVE YOUTUBE REAL-TIME SYNC</span>
                            </div>
                            <h2 class="panel-header-title" style="margin-bottom:4px;">YOUTUBE CHANNEL AUTOMATION & SYNC</h2>
                            <p class="panel-header-sub" style="margin-bottom:0;">Any video uploaded to your channel is automatically fetched and displayed on the live website.</p>
                        </div>
                        <div style="display:flex;gap:10px;">
                            <button id="btnSyncYtLive" class="btn-gold-pill" onclick="triggerLiveYouTubeSync()" style="box-shadow:0 0 20px rgba(212,175,55,0.35);">
                                <i class="fas fa-bolt" style="margin-right:6px;"></i> SYNC LIVE VIDEOS NOW
                            </button>
                        </div>
                    </div>

                    <!-- Sync Status Info Banner -->
                    <div id="ytStatusBanner" style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:16px;padding:18px 24px;margin-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                        <div style="display:flex;align-items:center;gap:16px;">
                            <div style="width:44px;height:44px;background:rgba(255,0,0,0.15);border:1px solid rgba(255,0,0,0.35);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#FF0000;font-size:1.4rem;">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <div>
                                <div style="font-size:0.95rem;font-weight:800;color:#FFF;" id="ytChannelNameDisplay">{{ $ytChannelName }}</div>
                                <div style="font-size:0.75rem;color:#94A3B8;margin-top:2px;">
                                    Channel: <a href="{{ $ytChannelUrl }}" target="_blank" id="ytChannelLink" style="color:#D4AF37;text-decoration:none;">{{ $ytChannelUrl }}</a>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;gap:24px;align-items:center;">
                            <div style="text-align:right;">
                                <div style="font-size:0.7rem;font-weight:800;color:#94A3B8;text-transform:uppercase;">Synced Videos</div>
                                <div style="font-size:1.2rem;font-weight:900;color:#D4AF37;" id="ytVideoCountDisplay">{{ $ytCount }} Videos</div>
                            </div>
                            <div style="text-align:right;border-left:1px solid rgba(212,175,55,0.2);padding-left:24px;">
                                <div style="font-size:0.7rem;font-weight:800;color:#94A3B8;text-transform:uppercase;">Last Synced</div>
                                <div style="font-size:0.85rem;font-weight:700;color:#25D366;" id="ytLastSyncedDisplay">
                                    {{ $ytLastSync ? date('M j, Y, g:i a', strtotime($ytLastSync)) : 'Not synced yet' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Channel Configuration Settings Form -->
                    <div style="background:#050B14;border:1px solid rgba(212,175,55,0.2);border-radius:16px;padding:24px;margin-top:20px;">
                        <h4 style="color:#FFF;font-size:0.95rem;margin-bottom:14px;font-weight:800;text-transform:uppercase;letter-spacing:0.04em;">
                            <i class="fas fa-sliders" style="margin-right:6px;color:var(--gold);"></i> CHANNEL SETTINGS & API CONFIGURATION
                        </h4>
                        
                        <form id="formYouTubeSettings" onsubmit="saveYouTubeSettings(event)">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                                <div>
                                    <label style="font-size:0.75rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:6px;">YOUTUBE CHANNEL URL OR HANDLE *</label>
                                    <input id="cfg_yt_channel_url" type="text" value="{{ $ytChannelUrl }}" required placeholder="e.g. https://www.youtube.com/@mahaconstructions2013 or @mahaconstructions2013" class="input-dark" style="width:100%;box-sizing:border-box;">
                                    <span style="font-size:0.7rem;color:#94A3B8;margin-top:4px;display:block;">Supports channel handles (@name), custom URLs, or full channel IDs (UC...).</span>
                                </div>
                                <div>
                                    <label style="font-size:0.75rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:6px;">YOUTUBE DATA API V3 KEY (OPTIONAL)</label>
                                    <input id="cfg_yt_api_key" type="text" value="{{ $ytApiKey }}" placeholder="Optional: Paste Google Cloud API key for 100% quota-safe sync" class="input-dark" style="width:100%;box-sizing:border-box;">
                                    <span style="font-size:0.7rem;color:#94A3B8;margin-top:4px;display:block;">Optional: Official YouTube RSS feed works out-of-the-box with zero API key!</span>
                                </div>
                            </div>

                            <div id="ytSettingsAlert" style="display:none;margin-top:14px;padding:10px 16px;border-radius:8px;font-size:0.82rem;font-weight:600;"></div>

                            <div style="margin-top:18px;display:flex;gap:12px;">
                                <button type="submit" id="btnSaveYtSettings" class="btn-gold-submit" style="width:auto;padding:10px 24px;font-size:0.85rem;">
                                    <i class="fas fa-save" style="margin-right:6px;"></i> SAVE & SYNC CHANNEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Synced Videos Visual Grid -->
                <div class="card-dark-panel" style="margin-top:28px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <div>
                            <h2 class="panel-header-title">CURRENTLY SYNCED VIDEOS (<span id="ytGridCount">{{ count($ytVideosList) }}</span>)</h2>
                            <p class="panel-header-sub">These live videos are automatically visible to visitors in the "Learn Before You Build" section on the homepage.</p>
                        </div>
                    </div>

                    <div id="ytVideosGrid" class="projects-grid-2">
                        @forelse($ytVideosList as $vid)
                        <div class="project-video-card">
                            <div class="video-thumb-frame">
                                <img src="{{ $vid['thumbnail'] ?? 'https://img.youtube.com/vi/'.$vid['youtubeId'].'/hqdefault.jpg' }}"
                                     alt="{{ $vid['title'] }}"
                                     onerror="this.src='https://img.youtube.com/vi/{{ $vid['youtubeId'] }}/hqdefault.jpg'">
                                <div class="video-play-overlay" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                                    <div class="play-btn-circle">
                                        <i class="fas fa-play" style="margin-left:2px;"></i>
                                    </div>
                                </div>
                                <div style="position:absolute;bottom:8px;right:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#F0EBE0;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.15);">
                                    <i class="fas fa-play" style="font-size:0.55rem;margin-right:3px;color:#D4AF37;"></i>{{ $vid['duration'] ?? 'Video' }}
                                </div>
                            </div>
                            <div style="padding:12px 14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:0.68rem;color:#D4AF37;font-weight:700;margin-bottom:4px;">
                                        ID: {{ $vid['youtubeId'] }} @if(!empty($vid['views'])) • {{ $vid['views'] }} @endif
                                    </div>
                                    <h4 style="color:#FFF;font-size:0.88rem;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $vid['title'] }}">
                                        {{ $vid['title'] }}
                                    </h4>
                                </div>
                                <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(212,175,55,0.12);display:flex;justify-content:space-between;align-items:center;">
                                    <div style="display:flex;gap:6px;align-items:center;">
                                        <button type="button" class="btn-whatsapp-outline" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="padding:5px 10px;font-size:0.72rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;">
                                            <i class="fas fa-play" style="margin-right:4px;"></i> Preview
                                        </button>
                                        <button type="button" class="action-del-btn" onclick="deleteYouTubeVideoItem(event, '{{ $vid['youtubeId'] }}', this)" title="Remove Video from Website" style="padding:5px 9px;font-size:0.72rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <a href="{{ $vid['watchUrl'] ?? 'https://www.youtube.com/watch?v='.$vid['youtubeId'] }}" target="_blank" style="font-size:0.72rem;color:#FF5555;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="fab fa-youtube"></i> Watch <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;">
                            <i class="fab fa-youtube" style="font-size:2.5rem;color:#FF0000;margin-bottom:10px;display:block;"></i>
                            No videos synced yet. Click "SYNC LIVE VIDEOS NOW" to fetch your channel videos.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 5. CONTACT DETAILS & ADDRESS TAB -->
            <div class="admin-tab-pane" id="tab-contact">
                <div class="card-dark-panel">
                    <h2 class="panel-header-title">HEAD OFFICE & CONTACT INFO</h2>
                    <p class="panel-header-sub">Update phone numbers, Nagercoil office address, email & Google Maps link.</p>

                    <form id="contactDetailsForm" class="quote-form-grid" style="margin-top:20px;">
                        <div class="form-field">
                            <label>PRIMARY PHONE</label>
                            <input type="text" value="+91 94888 88758" class="input-dark">
                        </div>
                        <div class="form-field">
                            <label>SECONDARY PHONE</label>
                            <input type="text" value="+91 90959 29543" class="input-dark">
                        </div>
                        <div class="form-field">
                            <label>WHATSAPP NUMBER</label>
                            <input type="text" value="+91 94888 88758" class="input-dark">
                        </div>
                        <div class="form-field">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" value="Mahaconstructions2013@gmail.com" class="input-dark">
                        </div>
                        <div class="form-field full-width">
                            <label>OFFICE ADDRESS</label>
                            <input type="text" value="Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil" class="input-dark">
                        </div>
                        <div class="form-field full-width" style="margin-top:12px;">
                            <button type="button" class="btn-gold-submit" style="width:auto;padding:12px 28px;">SAVE CONTACT DETAILS</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 6. GUIDEBOOK PDF MANAGEMENT & READERS LOG TAB -->
            <div class="admin-tab-pane" id="tab-guidebook">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h2 class="panel-header-title">FREE GUIDEBOOK PDF MANAGEMENT</h2>
                            <p class="panel-header-sub">Upload, view, or remove the PDF document served as the free "Nam Kanavu Illam" home builder guide.</p>
                        </div>
                    </div>

                    <!-- Current PDF Status & Active Cover -->
                    <div id="currentPdfBox" style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:16px;padding:20px;margin-top:16px;display:flex;gap:24px;align-items:center;flex-wrap:wrap;">
                        <img src="/images/guidebook-cover.jpg" alt="Guidebook Cover" style="width:90px;height:120px;object-fit:cover;border-radius:8px;border:1.5px solid rgba(212,175,55,0.4);box-shadow:0 6px 16px rgba(0,0,0,0.5);">
                        <div style="flex:1;min-width:260px;">
                            <div style="font-size:0.8rem;color:#D4AF37;font-weight:700;margin-bottom:8px;"><i class="fas fa-file-pdf" style="margin-right:6px;"></i> CURRENT ACTIVE PDF DOCUMENT & COVER</div>
                            <div id="activePdfDisplay" style="font-size:0.85rem;color:#94A3B8;word-break:break-all;margin-bottom:16px;">
                                {{ $settings['guidebook_pdf_url']->value ?? '/uploads/1785792673_new book.pdf' }}
                            </div>
                            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                                <a href="{{ $settings['guidebook_pdf_url']->value ?? '/uploads/1785792673_new book.pdf' }}" target="_blank" id="btnOpenPdf" class="btn-gold-pill">
                                    <i class="fas fa-external-link-alt" style="margin-right:6px;"></i> OPEN PDF
                                </a>
                                <button type="button" class="btn-whatsapp-outline" onclick="deleteGuidebookPdf(event, this)" style="border-color:#FF3B30;color:#FF3B30;">
                                    <i class="fas fa-trash" style="margin-right:6px;"></i> DELETE PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Upload New PDF -->
                    <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:16px;padding:24px;margin-top:16px;">
                        <div style="font-size:0.8rem;color:#D4AF37;font-weight:700;margin-bottom:14px;"><i class="fas fa-upload" style="margin-right:6px;"></i> UPLOAD NEW PDF FILE</div>

                        <div id="pdfDropZone" onclick="document.getElementById('guidebookFileInput').click()"
                             style="border:2px dashed rgba(212,175,55,0.4);border-radius:14px;padding:32px;text-align:center;cursor:pointer;transition:all 0.3s;background:rgba(212,175,55,0.03);"
                             onmouseover="this.style.borderColor='#D4AF37';this.style.background='rgba(212,175,55,0.07)';"
                             onmouseout="this.style.borderColor='rgba(212,175,55,0.4)';this.style.background='rgba(212,175,55,0.03)';">
                            <i class="fas fa-file-pdf" style="font-size:2rem;color:#D4AF37;margin-bottom:10px;display:block;"></i>
                            <div style="color:#fff;font-weight:700;margin-bottom:4px;">Click to select PDF file</div>
                            <div style="color:#64748b;font-size:0.8rem;">PDF only • Max 20MB</div>
                            <input type="file" id="guidebookFileInput" accept="application/pdf,.pdf" style="display:none;" onchange="handleGuidebookUpload(event)">
                        </div>

                        <div id="pdfUploadProgress" style="display:none;margin-top:16px;">
                            <div style="background:#0a1628;border-radius:8px;height:8px;overflow:hidden;">
                                <div id="pdfProgressBar" style="height:100%;width:0%;background:linear-gradient(90deg,#D4AF37,#FFD700);transition:width 0.4s ease;border-radius:8px;"></div>
                            </div>
                            <div id="pdfUploadStatus" style="color:#D4AF37;font-size:0.85rem;margin-top:8px;text-align:center;">Uploading...</div>
                        </div>
                    </div>
                </div>

                <!-- Guidebook Downloads & Readers Table -->
                <div class="card-dark-panel">
                    <h2 class="panel-header-title"><i class="fas fa-book-open" style="margin-right:8px;color:var(--gold);"></i> GUIDEBOOK DOWNLOADS & READERS ({{ \App\Models\GuidebookLead::count() }})</h2>
                    <p class="panel-header-sub">Live record of home buyers who submitted their details on the website to access the PDF guide.</p>

                    <div class="table-responsive">
                        <table class="table-custom-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>MOBILE PHONE</th>
                                    <th>GMAIL / EMAIL</th>
                                    <th>DATE & TIME</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\GuidebookLead::orderBy('id','desc')->get() as $i => $lead)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong>{{ $lead->name }}</strong></td>
                                    <td><i class="fas fa-phone" style="margin-right:6px;color:var(--gold);"></i> {{ $lead->phone }}</td>
                                    <td><i class="fas fa-envelope" style="margin-right:6px;color:var(--gold);"></i> {{ $lead->email }}</td>
                                    <td>{{ $lead->created_at ? $lead->created_at->format('n/j/Y, g:i:s a') : 'Recently' }}</td>
                                    <td>
                                        <button type="button" class="action-del-btn" onclick="deleteGuidebookLead(event, {{ $lead->id }}, this)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 7. INTRO VIDEO TAB -->
            <div class="admin-tab-pane" id="tab-intro">
                <div class="card-dark-panel">
                    <h2 class="panel-header-title">WEBSITE INTRO VIDEO MANAGEMENT</h2>
                    <p class="panel-header-sub">Upload, paste URL, or manage the intro video that appears in the hero section or Engineer introduction section.</p>

                    <!-- Current Video Status -->
                    <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:16px;padding:20px;margin-top:16px;">
                        <div style="font-size:0.8rem;color:#D4AF37;font-weight:700;margin-bottom:8px;"><i class="fas fa-video" style="margin-right:6px;"></i> CURRENT ACTIVE INTRO VIDEO</div>
                        <div id="activeVideoDisplay" style="font-size:0.85rem;color:#94A3B8;word-break:break-all;margin-bottom:16px;">
                            {{ $settings['intro_video_url']->value ?? '/uploads/1785711422_WhatsApp Video 2026-07-30 at 10.50.53 AM.mp4' }}
                        </div>
                        <div style="display:flex;gap:12px;flex-wrap:wrap;">
                            <button type="button" class="btn-gold-pill" id="btnPreviewVideo" onclick="previewIntroVideo()">
                                <i class="fas fa-play" style="margin-right:6px;"></i> PREVIEW VIDEO
                            </button>
                            <button type="button" class="btn-whatsapp-outline" onclick="deleteIntroVideo(event, this)" style="border-color:#FF3B30;color:#FF3B30;">
                                <i class="fas fa-trash" style="margin-right:6px;"></i> REMOVE VIDEO
                            </button>
                        </div>
                    </div>

                    <!-- Upload New Video File (Up to 2GB) -->
                    <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:16px;padding:24px;margin-top:16px;">
                        <div style="font-size:0.8rem;color:#D4AF37;font-weight:700;margin-bottom:14px;"><i class="fas fa-upload" style="margin-right:6px;"></i> UPLOAD NEW VIDEO FILE (MAX 2GB)</div>

                        <div id="videoDropZone" onclick="document.getElementById('introVideoFileInput').click()"
                             style="border:2px dashed rgba(212,175,55,0.4);border-radius:14px;padding:32px;text-align:center;cursor:pointer;transition:all 0.3s;background:rgba(212,175,55,0.03);"
                             onmouseover="this.style.borderColor='#D4AF37';this.style.background='rgba(212,175,55,0.07)';"
                             onmouseout="this.style.borderColor='rgba(212,175,55,0.4)';this.style.background='rgba(212,175,55,0.03)';">
                            <i class="fas fa-video" style="font-size:2rem;color:#D4AF37;margin-bottom:10px;display:block;"></i>
                            <div style="color:#fff;font-weight:700;margin-bottom:4px;">Click to select MP4 / MOV / WebM video file</div>
                            <div style="color:#64748b;font-size:0.8rem;">MP4, MOV, WebM, MKV • Max 2.0 GB (Lossless Chunked Stream)</div>
                            <input type="file" id="introVideoFileInput" accept="video/mp4,video/quicktime,video/webm,video/x-matroska,video/avi,.mp4,.mov,.webm,.mkv,.avi" style="display:none;" onchange="handleIntroVideoUpload(event)">
                        </div>

                        <div id="videoUploadProgress" style="display:none;margin-top:16px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.78rem;color:#94A3B8;">
                                <span id="introUploadMetrics">0 MB / 0 MB • 0.0 MB/s</span>
                                <span id="introUploadPercentText" style="color:#D4AF37;font-weight:800;">0%</span>
                            </div>
                            <div style="background:#0a1628;border-radius:8px;height:8px;overflow:hidden;">
                                <div id="videoProgressBar" style="height:100%;width:0%;background:linear-gradient(90deg,#D4AF37,#FFD700);transition:width 0.25s ease;border-radius:8px;"></div>
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                                <div id="videoUploadStatus" style="color:#D4AF37;font-size:0.82rem;">Uploading...</div>
                                <button type="button" onclick="cancelCurrentUpload()" style="background:rgba(255,59,48,0.15);border:1px solid rgba(255,59,48,0.3);color:#FF3B30;padding:2px 8px;border-radius:6px;font-size:0.7rem;cursor:pointer;">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Paste Video URL (alternative) -->
                    <div style="background:#050B14;border:1px solid rgba(212,175,55,0.15);border-radius:16px;padding:24px;margin-top:16px;">
                        <div style="font-size:0.8rem;color:#D4AF37;font-weight:700;margin-bottom:12px;"><i class="fas fa-link" style="margin-right:6px;"></i> OR PASTE A VIDEO URL</div>
                        <p style="font-size:0.8rem;color:#64748b;margin-bottom:12px;">Paste a direct video link (YouTube, Google Drive direct link, or your hosted .mp4 URL).</p>
                        <div style="display:flex;gap:10px;">
                            <input type="url" id="introVideoUrlInput"
                                   value="{{ $settings['intro_video_url']->value ?? '' }}"
                                   class="input-dark" style="flex:1;"
                                   placeholder="https://... (YouTube embed or direct .mp4 URL)">
                            <button class="btn-gold-submit" onclick="saveIntroVideoUrl()" style="width:auto;padding:10px 22px;white-space:nowrap;">
                                <i class="fas fa-save" style="margin-right:6px;"></i> SAVE URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. ADMIN ACCOUNT & SECURITY TAB -->
            <div class="admin-tab-pane" id="tab-security">
                <div class="card-dark-panel">
                    <h2 class="panel-header-title">ADMIN ACCOUNT & LOGIN CREDENTIALS</h2>
                    <p class="panel-header-sub">Manage the email address and password required to access this Admin Panel.</p>

                    <form id="adminAccountForm" class="quote-form-grid" style="margin-top:20px;">
                        <div class="form-field full-width">
                            <label>ADMIN LOGIN EMAIL *</label>
                            <input type="email" value="Mahaconstructions2013@gmail.com" class="input-dark">
                        </div>
                        <div class="form-field full-width">
                            <label>ADMIN LOGIN PASSWORD *</label>
                            <input type="password" value="Maharajan@2013" class="input-dark">
                        </div>
                        <div class="form-field full-width" style="margin-top:16px;">
                            <button type="button" class="btn-gold-submit" style="width:auto;padding:12px 28px;">💾 SAVE CREDENTIALS</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- ═══════════════════ UPLOAD & EDIT MODAL ═══════════════════ -->
<div id="uploadModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(5,11,20,0.85);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:20px;overflow-y:auto;">
    <div style="background:#0B132B;border:1px solid rgba(212,175,55,0.4);border-radius:24px;padding:32px 36px;width:580px;max-width:96vw;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.8),0 0 30px rgba(212,175,55,0.15);max-height:92vh;overflow-y:auto;">
        <button onclick="closeUploadModal()" style="position:absolute;top:16px;right:16px;background:rgba(255,255,255,0.08);border:none;color:#fff;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,59,48,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">✕</button>
        <div id="modalTitle" style="font-size:1.15rem;font-weight:800;color:#D4AF37;text-transform:uppercase;margin-bottom:6px;letter-spacing:0.04em;">UPLOAD VIDEO REVIEW</div>
        <div id="modalSub" style="font-size:0.8rem;color:#94A3B8;margin-bottom:22px;">Fill in or update the details below</div>

        <!-- 1. TESTIMONIAL FORM (CREATE & EDIT) -->
        <form id="formTestimonial" style="display:none;" onsubmit="submitTestimonial(event)">
            <input type="hidden" id="t_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">CLIENT NAME *</label>
                    <input id="t_client_name" type="text" required placeholder="e.g. Dr. Suresh & Family" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT / LOCATION</label>
                        <input id="t_project_name" type="text" placeholder="e.g. Royal Palms Villa, Nagercoil" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">CLIENT ROLE / PROFESSION</label>
                        <input id="t_client_role" type="text" placeholder="e.g. Villa Homeowner" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">FEEDBACK / TESTIMONIAL TEXT</label>
                    <textarea id="t_feedback" rows="2" placeholder="Enter client's words or key quote..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">VIDEO FILE (MP4/MOV) OR VIDEO URL</label>
                    <input id="t_video_file" type="file" accept="video/mp4,video/quicktime,video/webm" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="onTestimonialVideoChosen(event)">
                    <input id="t_video_url" type="text" placeholder="Or paste video / YouTube URL here" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onTestimonialVideoUrlChanged(this.value)">
                </div>

                <!-- Cover Image & Auto Video Frame Extractor -->
                <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;padding:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;margin:0;">
                            <i class="fas fa-image" style="margin-right:4px;"></i> COVER IMAGE (POSTER / THUMBNAIL)
                        </label>
                        <button type="button" onclick="captureTestimonialFrame()" id="btnCaptureTFrame" style="display:none;background:rgba(212,175,55,0.15);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.68rem;font-weight:800;padding:3px 8px;border-radius:8px;cursor:pointer;">
                            📸 CAPTURE FROM VIDEO
                        </button>
                    </div>
                    <input id="t_image_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 't_cover_preview_img')">
                    <input id="t_image_url" type="text" placeholder="Or image URL (auto-extracted from video if left blank)" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;">

                    <!-- Live Cover Frame Preview -->
                    <div id="t_cover_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:rgba(212,175,55,0.06);padding:8px 12px;border-radius:10px;border:1px dashed rgba(212,175,55,0.3);">
                        <img id="t_cover_preview_img" src="" style="width:70px;height:50px;object-fit:cover;border-radius:6px;border:1px solid #D4AF37;" alt="Cover Preview">
                        <div style="font-size:0.72rem;color:#94A3B8;">
                            <span id="t_cover_preview_status" style="color:#25D366;font-weight:700;">✓ Active Cover Frame</span>
                            <div style="font-size:0.65rem;color:#64748b;margin-top:2px;">Will be used as video thumbnail across site</div>
                        </div>
                    </div>
                </div>

                <div id="modalError" style="color:#FF3B30;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitTestimonial" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;">💾 SAVE VIDEO REVIEW</button>
            </div>
        </form>

        <!-- 2. PROJECT FORM (CREATE & EDIT) -->
        <form id="formProject" style="display:none;" onsubmit="submitProject(event)">
            <input type="hidden" id="p_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT NAME *</label>
                    <input id="p_name" type="text" required placeholder="e.g. Royal Heritage Luxury Villa" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">CATEGORY *</label>
                        <select id="p_category" class="input-dark" style="width:100%;">
                            <option value="villa">Luxury Villa</option>
                            <option value="residential">Residential Residence</option>
                            <option value="commercial">Commercial Hub</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">LOCATION</label>
                        <input id="p_location" type="text" placeholder="e.g. Nagercoil, Tamil Nadu" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">BUILT-UP AREA / SPECS</label>
                        <input id="p_duration" type="text" placeholder="e.g. 3,600 sq.ft" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">BUDGET / COST</label>
                        <input id="p_budget" type="text" placeholder="e.g. ₹85 Lakhs" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT DESCRIPTION</label>
                    <textarea id="p_description" rows="2" placeholder="Brief details about architecture, materials, floor plan..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT WALKTHROUGH VIDEO (MP4) OR VIDEO URL</label>
                    <input id="p_video_file" type="file" accept="video/mp4,video/quicktime,video/webm" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="onProjectVideoChosen(event)">
                    <input id="p_video_url" type="text" placeholder="Or paste video / YouTube URL here" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onProjectVideoUrlChanged(this.value)">
                </div>

                <!-- Cover Image & Auto Video Frame Extractor -->
                <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;padding:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;margin:0;">
                            <i class="fas fa-image" style="margin-right:4px;"></i> COVER PHOTO (AUTO-EXTRACTED FROM VIDEO IF EMPTY)
                        </label>
                        <button type="button" onclick="captureProjectFrame()" id="btnCapturePFrame" style="display:none;background:rgba(212,175,55,0.15);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.68rem;font-weight:800;padding:3px 8px;border-radius:8px;cursor:pointer;">
                            📸 CAPTURE FROM VIDEO
                        </button>
                    </div>
                    <input id="p_image_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 'p_cover_preview_img')">
                    <input id="p_image_url" type="text" placeholder="Or cover photo URL" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;">

                    <!-- Live Cover Frame Preview -->
                    <div id="p_cover_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:rgba(212,175,55,0.06);padding:8px 12px;border-radius:10px;border:1px dashed rgba(212,175,55,0.3);">
                        <img id="p_cover_preview_img" src="" style="width:70px;height:50px;object-fit:cover;border-radius:6px;border:1px solid #D4AF37;" alt="Cover Preview">
                        <div style="font-size:0.72rem;color:#94A3B8;">
                            <span id="p_cover_preview_status" style="color:#25D366;font-weight:700;">✓ Active Cover Frame</span>
                            <div style="font-size:0.65rem;color:#64748b;margin-top:2px;">Will be used as project thumbnail across site</div>
                        </div>
                    </div>
                </div>

                <div id="projectModalError" style="color:#FF3B30;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitProject" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;">💾 SAVE PROJECT</button>
            </div>
        </form>

        <!-- 3. PACKAGE FORM (CREATE & EDIT) -->
        <form id="formPackage" style="display:none;" onsubmit="submitPackage(event)">
            <input type="hidden" id="pk_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">DIVISION *</label>
                        <select id="pk_division" class="input-dark" style="width:100%;" required>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">TIER *</label>
                        <select id="pk_tier" class="input-dark" style="width:100%;" required>
                            <option value="basic">Basic</option>
                            <option value="standard">Standard</option>
                            <option value="premium">Premium</option>
                            <option value="luxury">Luxury</option>
                            <option value="elite">Elite</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PACKAGE TITLE *</label>
                    <input id="pk_title" type="text" required placeholder="e.g. Premium Residential Package" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PRICE PER SQ.FT (₹) *</label>
                    <input id="pk_price" type="number" required placeholder="e.g. 1850" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">SUBTITLE / TAGLINE</label>
                    <input id="pk_subtitle" type="text" placeholder="e.g. Best for luxury family residences" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">DESCRIPTION / SPECS HIGHLIGHTS</label>
                    <textarea id="pk_description" rows="2" placeholder="Key materials, structural specifications, warranty..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div id="packageModalError" style="color:#FF3B30;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitPackage" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;">💾 SAVE PACKAGE</button>
            </div>
        </form>

        <!-- 4. PARTNER & VENDOR FORM (CREATE & EDIT) -->
        <form id="formPartner" style="display:none;" onsubmit="submitPartner(event)">
            <input type="hidden" id="pt_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">PARTNER / BANK / VENDOR NAME *</label>
                    <input id="pt_name" type="text" required placeholder="e.g. State Bank of India or UltraTech Cement" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">CATEGORY / DIVISION *</label>
                        <select id="pt_division" class="input-dark" style="width:100%;">
                            <option value="banking">🏦 Banking Partner (Finance & Loans)</option>
                            <option value="vendor">🏗️ Material Vendor / Brand</option>
                            <option value="joint_venture">🤝 Joint Venture Partner</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:5px;">OFFICIAL WEBSITE URL</label>
                        <input id="pt_website_url" type="url" placeholder="https://www.example.com" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>

                <!-- Logo Image Upload / URL -->
                <div style="background:#050B14;border:1px solid rgba(212,175,55,0.25);border-radius:14px;padding:14px;">
                    <label style="font-size:0.72rem;font-weight:700;color:#D4AF37;text-transform:uppercase;display:block;margin-bottom:6px;">
                        <i class="fas fa-image" style="margin-right:4px;"></i> LOGO IMAGE (UPLOAD FILE OR ENTER URL)
                    </label>
                    <input id="pt_logo_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 'pt_logo_preview_img', 'pt_logo_preview_box')">
                    <input id="pt_logo_url" type="text" placeholder="Or enter logo image URL (e.g. /images/banks/sbi.png)" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onPartnerLogoUrlChanged(this.value)">

                    <!-- Live Logo Preview -->
                    <div id="pt_logo_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:rgba(212,175,55,0.06);padding:8px 12px;border-radius:10px;border:1px dashed rgba(212,175,55,0.3);">
                        <div style="background:#fff;padding:4px 8px;border-radius:6px;border:1px solid #D4AF37;display:flex;align-items:center;justify-content:center;min-width:90px;height:48px;">
                            <img id="pt_logo_preview_img" src="" style="max-height:40px;max-width:110px;object-fit:contain;" alt="Logo Preview">
                        </div>
                        <div style="font-size:0.72rem;color:#94A3B8;">
                            <span style="color:#25D366;font-weight:700;">✓ Active Logo Preview</span>
                            <div style="font-size:0.65rem;color:#64748b;margin-top:2px;">Displayed across Banking & Vendor website sections</div>
                        </div>
                    </div>
                </div>

                <div id="partnerModalError" style="color:#FF3B30;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitPartner" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;">💾 SAVE PARTNER</button>
            </div>
        </form>

        <!-- Live Uploading Indicator with Real-Time Progress -->
        <div id="uploadingIndicator" style="display:none;padding:16px 0;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:1.4rem;animation:spin 1.5s linear infinite;display:inline-block;">⏳</span>
                    <div style="color:#D4AF37;font-weight:800;letter-spacing:0.04em;font-size:0.88rem;" id="modalUploadTitle">UPLOADING & PROCESSING...</div>
                </div>
                <span id="modalUploadPercentText" style="color:#D4AF37;font-weight:900;font-size:1rem;">0%</span>
            </div>

            <div style="background:#0a1628;border-radius:8px;height:10px;overflow:hidden;border:1px solid rgba(212,175,55,0.25);">
                <div id="modalUploadProgressBar" style="height:100%;width:0%;background:linear-gradient(90deg,#D4AF37,#FFD700);transition:width 0.25s ease;border-radius:8px;"></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-top:10px;font-size:0.76rem;color:#94A3B8;">
                <span id="modalUploadMetrics">0 MB / 0 MB • 0.0 MB/s</span>
                <span id="modalUploadEta">ETA: Calculating...</span>
                <button type="button" onclick="cancelCurrentUpload()" style="background:rgba(255,59,48,0.15);border:1px solid rgba(255,59,48,0.35);color:#FF3B30;padding:3px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Animated Delete Confirmation Modal -->
<div id="customDeleteModal" class="delete-modal-backdrop" onclick="closeDeleteModalOnBackdrop(event)">
    <div class="delete-modal-card" id="deleteModalCard">
        <!-- Glowing Floating Trash Icon -->
        <div class="delete-icon-wrapper">
            <div class="delete-icon-glow"></div>
            <div class="delete-icon-circle">
                <i class="fas fa-trash-can delete-icon-symbol"></i>
            </div>
        </div>

        <!-- Title & Description -->
        <h3 class="delete-modal-title" id="deleteModalTitle">CONFIRM PERMANENT DELETE</h3>
        <p class="delete-modal-description" id="deleteModalMessage">
            Are you sure you want to permanently delete this item? This action is permanent and will remove all associated files and data.
        </p>

        <!-- Action Buttons -->
        <div class="delete-modal-actions">
            <button type="button" class="btn-delete-cancel" onclick="closeDeleteModal(false)">
                <i class="fas fa-xmark" style="margin-right:6px;"></i> Cancel
            </button>
            <button type="button" class="btn-delete-confirm" id="btnConfirmDelete">
                <i class="fas fa-trash-arrow-up" style="margin-right:6px;"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Hidden Background Video & Canvas Elements for Auto Frame Extraction -->
<video id="hiddenVideoExtractor" crossOrigin="anonymous" muted playsinline style="display:none;"></video>
<canvas id="hiddenCanvasExtractor" style="display:none;"></canvas>

<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function switchAdminTab(tabKey, linkEl) {
    if (!linkEl) {
        linkEl = document.querySelector(`.sidebar-nav-link[onclick*="'${tabKey}'"]`) || 
                 document.querySelector(`.sidebar-nav-link[onclick*='"${tabKey}"']`);
    }
    document.querySelectorAll('.sidebar-nav-link').forEach(el => el.classList.remove('active'));
    if (linkEl) linkEl.classList.add('active');
    document.querySelectorAll('.admin-tab-pane').forEach(pane => pane.classList.remove('active'));
    const targetPane = document.getElementById('tab-' + tabKey);
    if (targetPane) targetPane.classList.add('active');

    try {
        localStorage.setItem('maha_admin_active_tab', tabKey);
        history.replaceState(null, null, '#' + tabKey);
    } catch(e) {}
}

document.addEventListener('DOMContentLoaded', function() {
    let savedTab = window.location.hash ? window.location.hash.replace('#', '') : null;
    if (!savedTab) {
        savedTab = localStorage.getItem('maha_admin_active_tab');
    }
    if (savedTab && document.getElementById('tab-' + savedTab)) {
        switchAdminTab(savedTab);
    }
});

// ── CUSTOM ANIMATED DELETE CONFIRMATION MODAL ENGINE ──────────────
let deleteModalResolve = null;

function showDeleteConfirmModal(options = {}) {
    const title = options.title || 'CONFIRM PERMANENT DELETE';
    const message = options.message || 'Are you sure you want to permanently delete this item? This action is permanent and cannot be undone.';
    const confirmText = options.confirmText || 'Yes, Delete';

    document.getElementById('deleteModalTitle').textContent = title;
    document.getElementById('deleteModalMessage').textContent = message;
    const confirmBtn = document.getElementById('btnConfirmDelete');
    confirmBtn.innerHTML = `<i class="fas fa-trash-arrow-up" style="margin-right:6px;"></i> ${confirmText}`;

    const modal = document.getElementById('customDeleteModal');
    modal.style.display = 'flex';
    // Trigger CSS scale/fade animation
    requestAnimationFrame(() => {
        modal.classList.add('show');
    });

    return new Promise((resolve) => {
        deleteModalResolve = resolve;
    });
}

function closeDeleteModal(result = false) {
    const modal = document.getElementById('customDeleteModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        if (deleteModalResolve) {
            deleteModalResolve(result);
            deleteModalResolve = null;
        }
    }, 280);
}

function closeDeleteModalOnBackdrop(e) {
    if (e.target.id === 'customDeleteModal') {
        closeDeleteModal(false);
    }
}

document.getElementById('btnConfirmDelete').addEventListener('click', function() {
    closeDeleteModal(true);
});

// ── ROBUST DELETE ITEM ENGINE ─────────────────────────────────────
async function deleteItem(event, endpoint, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }

    const entityNames = {
        'testimonials': 'Client Video Review',
        'projects': 'Completed Project',
        'packages': 'Construction Package',
        'partners': 'Banking / Vendor Partner',
        'leads': 'Lead Inquiry'
    };
    const entityName = entityNames[endpoint] || 'Item';

    const confirmed = await showDeleteConfirmModal({
        title: `DELETE ${entityName.toUpperCase()}?`,
        message: `Are you sure you want to permanently delete this ${entityName}? This action is immediate and will remove all associated files and data.`,
        confirmText: 'Yes, Delete Permanently'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/' + endpoint + '/' + id, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        // Smooth visual card removal with shrink + blur animation
        const card = btnEl ? (btnEl.closest('.project-video-card') || btnEl.closest('.package-card') || btnEl.closest('tr')) : null;
        if (card) {
            card.style.transition = 'all 0.38s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.transform = 'scale(0.85) translateY(-8px)';
            card.style.opacity = '0';
            card.style.filter = 'blur(4px)';
            setTimeout(() => {
                card.remove();
            }, 380);
        } else {
            location.reload();
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('❌ Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

async function deleteYouTubeVideoItem(event, ytId, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const confirmed = await showDeleteConfirmModal({
        title: 'REMOVE YOUTUBE VIDEO?',
        message: 'Remove this YouTube video from the website homepage video carousel? The website will update immediately.',
        confirmText: 'Yes, Remove Video'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/youtube/videos/' + ytId, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        const card = btnEl ? btnEl.closest('.project-video-card') : null;
        if (card) {
            card.style.transition = 'all 0.38s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.transform = 'scale(0.85) translateY(-8px)';
            card.style.opacity = '0';
            card.style.filter = 'blur(4px)';
            setTimeout(() => {
                card.remove();
                const grid = document.getElementById('ytVideosGrid');
                const remaining = grid ? grid.querySelectorAll('.project-video-card').length : 0;
                const gridCount = document.getElementById('ytGridCount');
                if (gridCount) gridCount.textContent = remaining;
                const sidebarCount = document.getElementById('sidebarYtCount');
                if (sidebarCount) sidebarCount.textContent = remaining;
            }, 380);
        } else {
            location.reload();
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('❌ Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

async function deleteGuidebookLead(event, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const confirmed = await showDeleteConfirmModal({
        title: 'DELETE GUIDEBOOK INQUIRY?',
        message: 'Are you sure you want to permanently delete this reader guidebook lead inquiry?',
        confirmText: 'Yes, Delete Lead'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/leads/guidebook/' + id, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        const row = btnEl ? btnEl.closest('tr') : null;
        if (row) {
            row.style.transition = 'all 0.35s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.9)';
            setTimeout(() => row.remove(), 350);
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('❌ Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

// ── MODAL MANAGEMENT (CREATE & EDIT MODES) ────────────────────────
let autoExtractedTestimonialBlob = null;
let autoExtractedProjectBlob     = null;

function resetAllForms() {
    ['formTestimonial','formProject','formPackage','formPartner'].forEach(id => {
        const f = document.getElementById(id);
        if (f) { f.style.display = 'none'; f.reset(); }
    });
    ['modalError','projectModalError','packageModalError','partnerModalError'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.style.display = 'none'; el.textContent = ''; }
    });
    document.getElementById('uploadingIndicator').style.display = 'none';
    document.getElementById('t_cover_preview_box').style.display = 'none';
    document.getElementById('p_cover_preview_box').style.display = 'none';
    document.getElementById('pt_logo_preview_box').style.display = 'none';
    document.getElementById('btnCaptureTFrame').style.display = 'none';
    document.getElementById('btnCapturePFrame').style.display = 'none';
    document.getElementById('t_editing_id').value = '';
    document.getElementById('p_editing_id').value = '';
    document.getElementById('pk_editing_id').value = '';
    document.getElementById('pt_editing_id').value = '';
    autoExtractedTestimonialBlob = null;
    autoExtractedProjectBlob     = null;
}

function openUploadModal(type) {
    resetAllForms();
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'flex';

    const titles = {
        testimonial: ['UPLOAD NEW VIDEO REVIEW', 'Add a client testimonial video & auto-captured cover image', 'formTestimonial', 'btnSubmitTestimonial', '💾 SAVE VIDEO REVIEW'],
        project:     ['UPLOAD COMPLETED PROJECT', 'Add a luxury project walkthrough video & cover image', 'formProject', 'btnSubmitProject', '💾 SAVE PROJECT'],
        package:     ['ADD NEW CONSTRUCTION PACKAGE', 'Create a per sq.ft construction package', 'formPackage', 'btnSubmitPackage', '💾 SAVE PACKAGE'],
        partner:     ['ADD NEW PARTNER / VENDOR', 'Add a banking partner for loans or a certified material vendor', 'formPartner', 'btnSubmitPartner', '💾 SAVE PARTNER'],
    };

    const cfg = titles[type];
    if (!cfg) return;
    document.getElementById('modalTitle').textContent = cfg[0];
    document.getElementById('modalSub').textContent   = cfg[1];
    document.getElementById(cfg[2]).style.display      = 'block';
    if (cfg[3] && document.getElementById(cfg[3])) {
        document.getElementById(cfg[3]).textContent = cfg[4];
    }
}

function openEditModal(type, item) {
    resetAllForms();
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'flex';

    if (type === 'testimonial') {
        document.getElementById('modalTitle').textContent = 'EDIT VIDEO REVIEW';
        document.getElementById('modalSub').textContent   = 'Update client review details, video, or cover image';
        document.getElementById('formTestimonial').style.display = 'block';
        document.getElementById('btnSubmitTestimonial').textContent = '💾 UPDATE VIDEO REVIEW';

        document.getElementById('t_editing_id').value   = item.id;
        document.getElementById('t_client_name').value  = item.client_name || '';
        document.getElementById('t_project_name').value = item.project_name || '';
        document.getElementById('t_client_role').value  = item.client_role || '';
        document.getElementById('t_feedback').value     = item.feedback || '';
        document.getElementById('t_video_url').value    = item.video_url || '';
        document.getElementById('t_image_url').value    = item.image_url || '';

        if (item.image_url) {
            document.getElementById('t_cover_preview_img').src = item.image_url;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
        }
        if (item.video_url) {
            document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
        }
    } else if (type === 'project') {
        document.getElementById('modalTitle').textContent = 'EDIT COMPLETED PROJECT';
        document.getElementById('modalSub').textContent   = 'Update project specs, video walkthrough, or cover photo';
        document.getElementById('formProject').style.display = 'block';
        document.getElementById('btnSubmitProject').textContent = '💾 UPDATE PROJECT';

        document.getElementById('p_editing_id').value    = item.id;
        document.getElementById('p_name').value          = item.name || '';
        document.getElementById('p_category').value      = item.category || 'villa';
        document.getElementById('p_location').value      = item.location || '';
        document.getElementById('p_duration').value      = item.duration || '';
        document.getElementById('p_budget').value        = item.budget || '';
        document.getElementById('p_description').value   = item.description || '';
        document.getElementById('p_video_url').value     = item.video_url || '';

        const coverImg = (item.image_urls && item.image_urls.length > 0) ? item.image_urls[0] : (item.image_url || '');
        document.getElementById('p_image_url').value     = coverImg;

        if (coverImg) {
            document.getElementById('p_cover_preview_img').src = coverImg;
            document.getElementById('p_cover_preview_box').style.display = 'flex';
        }
        if (item.video_url) {
            document.getElementById('btnCapturePFrame').style.display = 'inline-block';
        }
    } else if (type === 'package') {
        document.getElementById('modalTitle').textContent = 'EDIT CONSTRUCTION PACKAGE';
        document.getElementById('modalSub').textContent   = 'Update per sq.ft pricing, specifications & tier';
        document.getElementById('formPackage').style.display = 'block';
        document.getElementById('btnSubmitPackage').textContent = '💾 UPDATE PACKAGE';

        document.getElementById('pk_editing_id').value   = item.id;
        document.getElementById('pk_division').value     = item.division || 'residential';
        document.getElementById('pk_tier').value         = item.tier || 'standard';
        document.getElementById('pk_title').value        = item.title || '';
        document.getElementById('pk_price').value        = item.price_per_sqft || '';
        document.getElementById('pk_subtitle').value     = item.subtitle || '';
        document.getElementById('pk_description').value  = item.description || '';
    } else if (type === 'partner') {
        document.getElementById('modalTitle').textContent = 'EDIT PARTNER / VENDOR';
        document.getElementById('modalSub').textContent   = 'Update partner name, category, website URL, or logo image';
        document.getElementById('formPartner').style.display = 'block';
        document.getElementById('btnSubmitPartner').textContent = '💾 UPDATE PARTNER';

        document.getElementById('pt_editing_id').value   = item.id;
        document.getElementById('pt_name').value         = item.name || '';
        document.getElementById('pt_division').value     = item.division || 'banking';
        document.getElementById('pt_website_url').value = item.website_url || '';
        document.getElementById('pt_logo_url').value    = item.logo_url || '';

        if (item.logo_url) {
            document.getElementById('pt_logo_preview_img').src = item.logo_url;
            document.getElementById('pt_logo_preview_box').style.display = 'flex';
        }
    }
}

function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
}
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

function previewSelectedImage(e, imgId, boxId) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(evt) {
        const img = document.getElementById(imgId);
        if (img) img.src = evt.target.result;
        if (boxId) {
            const box = document.getElementById(boxId);
            if (box) box.style.display = 'flex';
        } else if (imgId === 't_cover_preview_img') {
            document.getElementById('t_cover_preview_box').style.display = 'flex';
        } else if (imgId === 'p_cover_preview_img') {
            document.getElementById('p_cover_preview_box').style.display = 'flex';
        }
    };
    reader.readAsDataURL(file);
}

// ── VIDEO FRAME COVER EXTRACTOR ──────────────────────────────────
function extractFrameFromVideoSource(source, callback) {
    const v = document.getElementById('hiddenVideoExtractor');
    let objectUrl = null;

    if (source instanceof File) {
        objectUrl = URL.createObjectURL(source);
        v.src = objectUrl;
    } else if (typeof source === 'string' && source.trim()) {
        const url = source.trim();
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let ytId = '';
            if (url.includes('watch?v=')) ytId = url.split('watch?v=')[1]?.split('&')[0];
            else if (url.includes('youtu.be/')) ytId = url.split('youtu.be/')[1]?.split('?')[0];
            else if (url.includes('/shorts/')) ytId = url.split('/shorts/')[1]?.split('?')[0];
            if (ytId) {
                const ytThumb = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
                callback(null, ytThumb);
                return;
            }
        }
        v.src = url;
    } else {
        callback(null, null);
        return;
    }

    v.onloadedmetadata = function() {
        v.currentTime = Math.min(1.0, (v.duration || 2) * 0.1);
    };

    v.onseeked = function() {
        try {
            const canvas = document.getElementById('hiddenCanvasExtractor');
            canvas.width = v.videoWidth || 640;
            canvas.height = v.videoHeight || 360;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(v, 0, 0, canvas.width, canvas.height);
            canvas.toBlob(function(blob) {
                if (objectUrl) URL.revokeObjectURL(objectUrl);
                const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                callback(blob, dataUrl);
            }, 'image/jpeg', 0.85);
        } catch (err) {
            console.warn('Cannot extract video canvas frame:', err);
            if (objectUrl) URL.revokeObjectURL(objectUrl);
            callback(null, null);
        }
    };

    v.onerror = function() {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        callback(null, null);
    };
}

function onTestimonialVideoChosen(event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(file, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').textContent = '✓ Auto-Extracted Frame from Video';
        }
    });
}

function onTestimonialVideoUrlChanged(url) {
    if (!url.trim()) return;
    document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').textContent = '✓ Auto-Extracted Frame from Video';
        }
    });
}

function captureTestimonialFrame() {
    const file = document.getElementById('t_video_file').files[0];
    const url  = document.getElementById('t_video_url').value.trim();
    extractFrameFromVideoSource(file || url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').textContent = '✓ Captured Frame from Video';
        }
    });
}

function onProjectVideoChosen(event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('btnCapturePFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(file, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedProjectBlob = blob;
            document.getElementById('p_cover_preview_img').src = dataUrl;
            document.getElementById('p_cover_preview_box').style.display = 'flex';
            document.getElementById('p_cover_preview_status').textContent = '✓ Auto-Extracted Frame from Video';
        }
    });
}

function onProjectVideoUrlChanged(url) {
    if (!url.trim()) return;
    document.getElementById('btnCapturePFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedProjectBlob = blob;
            document.getElementById('p_cover_preview_img').src = dataUrl;
            document.getElementById('p_cover_preview_box').style.display = 'flex';
            document.getElementById('p_cover_preview_status').textContent = '✓ Auto-Extracted Frame from Video';
        }
    });
}

function captureProjectFrame() {
    const file = document.getElementById('p_video_file').files[0];
    const url  = document.getElementById('p_video_url').value.trim();
    extractFrameFromVideoSource(file || url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedProjectBlob = blob;
            document.getElementById('p_cover_preview_img').src = dataUrl;
            document.getElementById('p_cover_preview_box').style.display = 'flex';
            document.getElementById('p_cover_preview_status').textContent = '✓ Captured Frame from Video';
        }
    });
}

function previewSelectedImage(event, targetImgId) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(targetImgId);
        if (img) {
            img.src = e.target.result;
            img.closest('div[id$="_cover_preview_box"]').style.display = 'flex';
        }
    };
    reader.readAsDataURL(file);
}

// ── FORMAT HELPERS & ABORT ENGINE ────────────────────────────────
let currentUploadAbortController = null;
let activeUploadId = null;

function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
}

function formatDuration(seconds) {
    if (!isFinite(seconds) || seconds < 0) return '--';
    if (seconds < 60) return Math.round(seconds) + 's';
    const m = Math.floor(seconds / 60);
    const s = Math.round(seconds % 60);
    return `${m}m ${s}s`;
}

function cancelCurrentUpload() {
    if (currentUploadAbortController) {
        currentUploadAbortController.abort();
        currentUploadAbortController = null;
    }
    if (activeUploadId) {
        fetch('/api/upload/abort', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify({ upload_id: activeUploadId })
        }).catch(() => {});
        activeUploadId = null;
    }
    const ind = document.getElementById('uploadingIndicator');
    if (ind) ind.style.display = 'none';
    const vmProg = document.getElementById('vmProgressContainer');
    if (vmProg) vmProg.style.display = 'none';
    const vDrop = document.getElementById('vmDropZone');
    if (vDrop) vDrop.style.display = 'block';
    const vidProg = document.getElementById('videoUploadProgress');
    if (vidProg) vidProg.style.display = 'none';
    const pdfProg = document.getElementById('pdfUploadProgress');
    if (pdfProg) pdfProg.style.display = 'none';
    alert('Upload cancelled.');
}

// ── RESILIENT CHUNKED UPLOAD ENGINE (UP TO 2GB, LOSSLESS) ────────
async function uploadFileWithChunks(file, options = {}) {
    const chunkSize = options.chunkSize || (5 * 1024 * 1024); // 5MB chunks
    const totalSize = file.size;
    const totalChunks = Math.ceil(totalSize / chunkSize);
    const filename = options.customFilename || file.name || ('upload_' + Date.now() + '.mp4');
    const uploadId = 'up_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    activeUploadId = uploadId;

    currentUploadAbortController = new AbortController();
    const signal = options.abortSignal || currentUploadAbortController.signal;

    const startTime = Date.now();
    let bytesUploaded = 0;

    for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
        if (signal.aborted) {
            await fetch('/api/upload/abort', {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                body: JSON.stringify({ upload_id: uploadId })
            }).catch(() => {});
            throw new Error('Upload cancelled by user.');
        }

        const start = chunkIndex * chunkSize;
        const end = Math.min(start + chunkSize, totalSize);
        const chunkBlob = file.slice(start, end);
        const chunkSizeBytes = end - start;

        let chunkUploaded = false;
        let lastError = null;

        // Auto retry up to 3 times per chunk on network drops
        for (let attempt = 1; attempt <= 3; attempt++) {
            try {
                const fd = new FormData();
                fd.append('upload_id', uploadId);
                fd.append('chunk_index', chunkIndex);
                fd.append('total_chunks', totalChunks);
                fd.append('chunk', chunkBlob, `part_${chunkIndex}`);

                const res = await fetch('/api/upload/chunk', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                    body: fd,
                    signal
                });

                if (!res.ok) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || `Chunk ${chunkIndex + 1}/${totalChunks} failed (${res.status})`);
                }

                chunkUploaded = true;
                bytesUploaded += chunkSizeBytes;

                const elapsedSec = (Date.now() - startTime) / 1000;
                const speedBps = elapsedSec > 0 ? (bytesUploaded / elapsedSec) : 0;
                const remainingBytes = totalSize - bytesUploaded;
                const etaSec = speedBps > 0 ? (remainingBytes / speedBps) : 0;
                const pct = Math.min(99, Math.round((bytesUploaded / totalSize) * 100));

                if (typeof options.onProgress === 'function') {
                    options.onProgress({
                        percent: pct,
                        loaded: bytesUploaded,
                        total: totalSize,
                        loadedFormatted: formatBytes(bytesUploaded),
                        totalFormatted: formatBytes(totalSize),
                        speedFormatted: formatBytes(speedBps) + '/s',
                        etaFormatted: formatDuration(etaSec),
                        chunkIndex: chunkIndex + 1,
                        totalChunks: totalChunks
                    });
                }
                break;
            } catch (err) {
                lastError = err;
                if (signal.aborted) throw err;
                if (attempt < 3) {
                    await new Promise(r => setTimeout(r, 1000 * attempt));
                }
            }
        }

        if (!chunkUploaded) {
            throw lastError || new Error(`Failed to upload chunk ${chunkIndex + 1}/${totalChunks}`);
        }
    }

    // Assembly notification
    if (typeof options.onProgress === 'function') {
        options.onProgress({
            percent: 99,
            loaded: totalSize,
            total: totalSize,
            loadedFormatted: formatBytes(totalSize),
            totalFormatted: formatBytes(totalSize),
            speedFormatted: 'Assembling...',
            etaFormatted: 'Processing stream on disk...',
            chunkIndex: totalChunks,
            totalChunks: totalChunks,
            status: 'assembling'
        });
    }

    const finishRes = await fetch('/api/upload/finish', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: JSON.stringify({
            upload_id: uploadId,
            filename: filename,
            total_chunks: totalChunks,
            total_size: totalSize
        }),
        signal
    });

    if (!finishRes.ok) {
        const errJson = await finishRes.json().catch(() => ({}));
        throw new Error(errJson.message || `Failed to assemble file (${finishRes.status})`);
    }

    const finishData = await finishRes.json();
    if (typeof options.onProgress === 'function') {
        options.onProgress({
            percent: 100,
            loaded: totalSize,
            total: totalSize,
            loadedFormatted: formatBytes(totalSize),
            totalFormatted: formatBytes(totalSize),
            speedFormatted: 'Complete',
            etaFormatted: '0s',
            chunkIndex: totalChunks,
            totalChunks: totalChunks,
            status: 'done'
        });
    }

    currentUploadAbortController = null;
    activeUploadId = null;
    return finishData;
}

// ── UNIVERSAL UPLOAD HELPER ──────────────────────────────────────
async function uploadFile(fileOrBlob, filename = 'cover_frame.jpg', onProgress = null) {
    if (fileOrBlob instanceof File && fileOrBlob.size > (5 * 1024 * 1024)) {
        // Large file (> 5MB up to 2GB) -> use chunked uploader
        const result = await uploadFileWithChunks(fileOrBlob, {
            customFilename: filename !== 'cover_frame.jpg' ? filename : fileOrBlob.name,
            onProgress: onProgress
        });
        return result.url;
    }

    const fd = new FormData();
    if (fileOrBlob instanceof Blob && !(fileOrBlob instanceof File)) {
        fd.append('file', fileOrBlob, filename);
    } else {
        fd.append('file', fileOrBlob);
    }

    if (typeof onProgress === 'function') {
        onProgress({ percent: 40, loadedFormatted: '', totalFormatted: '', speedFormatted: 'Uploading...', etaFormatted: '' });
    }

    const res = await fetch('/api/upload', {
        method: 'POST',
        credentials: 'include',
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: fd
    });

    if (!res.ok) {
        const errData = await res.json().catch(() => ({}));
        throw new Error(errData.message || 'File upload failed (' + res.status + ')');
    }

    if (typeof onProgress === 'function') {
        onProgress({ percent: 100, loadedFormatted: '', totalFormatted: '', speedFormatted: 'Done', etaFormatted: '0s' });
    }

    const data = await res.json();
    return data.url;
}

function onModalVideoFileSelected(event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('v_file_selected_text').textContent = `✓ Selected: ${file.name} (${formatBytes(file.size)})`;
    }
}

function updateModalProgress(p) {
    const bar     = document.getElementById('modalUploadProgressBar');
    const pctText = document.getElementById('modalUploadPercentText');
    const metrics = document.getElementById('modalUploadMetrics');
    const eta     = document.getElementById('modalUploadEta');
    if (bar) bar.style.width = (p.percent || 0) + '%';
    if (pctText) pctText.textContent = (p.percent || 0) + '%';
    if (metrics) metrics.textContent = `${p.loadedFormatted || ''} / ${p.totalFormatted || ''} • ${p.speedFormatted || ''}`;
    if (eta) eta.textContent = p.etaFormatted ? `ETA: ${p.etaFormatted}` : '';
}

// ── SUBMIT TESTIMONIAL (CREATE / UPDATE) ─────────────────────────
async function submitTestimonial(e) {
    e.preventDefault();
    const errEl = document.getElementById('modalError');
    errEl.style.display = 'none';

    const editId      = document.getElementById('t_editing_id').value;
    const clientName  = document.getElementById('t_client_name').value.trim();
    const projectName = document.getElementById('t_project_name').value.trim();
    const clientRole  = document.getElementById('t_client_role').value.trim();
    const feedback    = document.getElementById('t_feedback').value.trim();
    const videoFile   = document.getElementById('t_video_file').files[0];
    const videoUrl    = document.getElementById('t_video_url').value.trim();
    const imageFile   = document.getElementById('t_image_file').files[0];
    const imageUrl    = document.getElementById('t_image_url').value.trim();

    if (!clientName) { errEl.textContent = 'Client name is required.'; errEl.style.display='block'; return; }
    
    const indicator = document.getElementById('uploadingIndicator');
    indicator.style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = videoFile ? 'UPLOADING REVIEW VIDEO (UP TO 2GB)...' : 'SAVING REVIEW...';
    document.getElementById('formTestimonial').style.display = 'none';

    try {
        let finalVideoUrl = videoUrl;
        let finalImageUrl = imageUrl;

        if (videoFile) {
            finalVideoUrl = await uploadFile(videoFile, videoFile.name, updateModalProgress);
        }
        if (imageFile) {
            finalImageUrl = await uploadFile(imageFile);
        } else if (!finalImageUrl && autoExtractedTestimonialBlob) {
            finalImageUrl = await uploadFile(autoExtractedTestimonialBlob, 'review_cover_' + Date.now() + '.jpg');
        } else if (!finalImageUrl && finalVideoUrl && (finalVideoUrl.includes('youtube.com') || finalVideoUrl.includes('youtu.be'))) {
            let ytId = '';
            if (finalVideoUrl.includes('watch?v=')) ytId = finalVideoUrl.split('watch?v=')[1]?.split('&')[0];
            else if (finalVideoUrl.includes('youtu.be/')) ytId = finalVideoUrl.split('youtu.be/')[1]?.split('?')[0];
            if (ytId) finalImageUrl = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
        }

        const payload = {
            client_name: clientName,
            project_name: projectName || null,
            client_role: clientRole || null,
            feedback: feedback || null,
            video_url: finalVideoUrl || null,
            image_url: finalImageUrl || null
        };

        const url    = editId ? `/api/testimonials/${editId}` : '/api/testimonials';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('reviews');
        location.reload();
    } catch (err) {
        indicator.style.display = 'none';
        document.getElementById('formTestimonial').style.display = 'block';
        errEl.textContent = '❌ ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PROJECT (CREATE / UPDATE) ─────────────────────────────
async function submitProject(e) {
    e.preventDefault();
    const errEl = document.getElementById('projectModalError');
    errEl.style.display = 'none';

    const editId      = document.getElementById('p_editing_id').value;
    const name        = document.getElementById('p_name').value.trim();
    const category    = document.getElementById('p_category').value;
    const locationVal = document.getElementById('p_location').value.trim();
    const duration    = document.getElementById('p_duration').value.trim();
    const budget      = document.getElementById('p_budget').value.trim();
    const description = document.getElementById('p_description').value.trim();
    const imageFile   = document.getElementById('p_image_file').files[0];
    const imageUrl    = document.getElementById('p_image_url').value.trim();
    const videoFile   = document.getElementById('p_video_file').files[0];
    const videoUrl    = document.getElementById('p_video_url').value.trim();

    if (!name) { errEl.textContent = 'Project name is required.'; errEl.style.display='block'; return; }
    
    const indicator = document.getElementById('uploadingIndicator');
    indicator.style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = videoFile ? 'UPLOADING PROJECT WALKTHROUGH (UP TO 2GB)...' : 'SAVING PROJECT...';
    document.getElementById('formProject').style.display = 'none';

    try {
        let finalVideoUrl = videoUrl;
        let finalImageUrl = imageUrl;

        if (videoFile) {
            finalVideoUrl = await uploadFile(videoFile, videoFile.name, updateModalProgress);
        }
        if (imageFile) {
            finalImageUrl = await uploadFile(imageFile);
        } else if (!finalImageUrl && autoExtractedProjectBlob) {
            finalImageUrl = await uploadFile(autoExtractedProjectBlob, 'project_cover_' + Date.now() + '.jpg');
        } else if (!finalImageUrl && finalVideoUrl && (finalVideoUrl.includes('youtube.com') || finalVideoUrl.includes('youtu.be'))) {
            let ytId = '';
            if (finalVideoUrl.includes('watch?v=')) ytId = finalVideoUrl.split('watch?v=')[1]?.split('&')[0];
            else if (finalVideoUrl.includes('youtu.be/')) ytId = finalVideoUrl.split('youtu.be/')[1]?.split('?')[0];
            if (ytId) finalImageUrl = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
        }

        const payload = {
            name,
            category,
            location: locationVal || null,
            duration: duration || null,
            budget: budget || null,
            description: description || null,
            image_urls: finalImageUrl ? [finalImageUrl] : [],
            video_url: finalVideoUrl || null
        };

        const url    = editId ? `/api/projects/${editId}` : '/api/projects';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('projects');
        location.reload();
    } catch (err) {
        indicator.style.display = 'none';
        document.getElementById('formProject').style.display = 'block';
        errEl.textContent = '❌ ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PACKAGE (CREATE / UPDATE) ─────────────────────────────
async function submitPackage(e) {
    e.preventDefault();
    const errEl = document.getElementById('packageModalError');
    errEl.style.display = 'none';

    const editId   = document.getElementById('pk_editing_id').value;
    const division = document.getElementById('pk_division').value;
    const tier     = document.getElementById('pk_tier').value;
    const title    = document.getElementById('pk_title').value.trim();
    const price    = document.getElementById('pk_price').value;
    const subtitle = document.getElementById('pk_subtitle').value.trim();
    const desc     = document.getElementById('pk_description').value.trim();

    if (!title || !price) { errEl.textContent = 'Title and price are required.'; errEl.style.display='block'; return; }

    try {
        const payload = {
            division,
            tier,
            title,
            price_per_sqft: parseFloat(price),
            subtitle: subtitle || null,
            description: desc || null
        };

        const url    = editId ? `/api/packages/${editId}` : '/api/packages';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('packages');
        location.reload();
    } catch (err) {
        errEl.textContent = '❌ ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PARTNER / VENDOR (CREATE / UPDATE) ─────────────────────
function onPartnerLogoUrlChanged(url) {
    const box = document.getElementById('pt_logo_preview_box');
    const img = document.getElementById('pt_logo_preview_img');
    if (url && url.trim()) {
        img.src = url.trim();
        box.style.display = 'flex';
    } else {
        box.style.display = 'none';
    }
}

async function submitPartner(e) {
    e.preventDefault();
    const errEl = document.getElementById('partnerModalError');
    errEl.style.display = 'none';

    const editId     = document.getElementById('pt_editing_id').value;
    const name       = document.getElementById('pt_name').value.trim();
    const division   = document.getElementById('pt_division').value;
    const websiteUrl = document.getElementById('pt_website_url').value.trim();
    const logoUrl    = document.getElementById('pt_logo_url').value.trim();
    const logoFile   = document.getElementById('pt_logo_file').files[0];

    if (!name) { errEl.textContent = 'Partner / Bank name is required.'; errEl.style.display='block'; return; }

    document.getElementById('uploadingIndicator').style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = 'SAVING PARTNER...';
    document.getElementById('formPartner').style.display = 'none';

    try {
        let finalLogoUrl = logoUrl;
        if (logoFile) {
            finalLogoUrl = await uploadFile(logoFile);
        }

        const payload = {
            name,
            division,
            website_url: websiteUrl || null,
            logo_url: finalLogoUrl || null,
            is_active: true
        };

        const url    = editId ? `/api/partners/${editId}` : '/api/partners';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (res.status === 401) {
            document.getElementById('uploadingIndicator').style.display = 'none';
            document.getElementById('formPartner').style.display = 'block';
            errEl.textContent = '❌ Session expired. Please login again to save changes.';
            errEl.style.display = 'block';
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed (' + res.status + ')'); }
        closeUploadModal();
        switchAdminTab('partners');
        location.reload();
    } catch (err) {
        document.getElementById('uploadingIndicator').style.display = 'none';
        document.getElementById('formPartner').style.display = 'block';
        errEl.textContent = '❌ ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── YOUTUBE LIVE SYNC & SETTINGS ─────────────────────────────────
async function triggerLiveYouTubeSync() {
    const btn = document.getElementById('btnSyncYtLive');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SYNCING CHANNEL...';

    try {
        const res = await fetch('/api/youtube/sync', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                url: document.getElementById('cfg_yt_channel_url')?.value || ''
            })
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Sync failed');
        }

        const data = json.data;
        if (data) {
            const countEl = document.getElementById('ytVideoCountDisplay');
            const lastSyncEl = document.getElementById('ytLastSyncedDisplay');
            const nameEl = document.getElementById('ytChannelNameDisplay');
            const gridCountEl = document.getElementById('ytGridCount');
            const sidebarCountEl = document.getElementById('sidebarYtCount');

            if (countEl) countEl.textContent = data.count + ' Videos';
            if (gridCountEl) gridCountEl.textContent = data.count;
            if (sidebarCountEl) sidebarCountEl.textContent = data.count;
            if (nameEl && data.channel_name) nameEl.textContent = data.channel_name;
            if (lastSyncEl) lastSyncEl.textContent = 'Just now';

            renderYouTubeVideoGrid(data.videos || []);
        }

        alert('✅ ' + json.message);
    } catch (err) {
        alert('❌ Sync failed: ' + err.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

async function saveYouTubeSettings(e) {
    e.preventDefault();
    const alertBox = document.getElementById('ytSettingsAlert');
    const saveBtn = document.getElementById('btnSaveYtSettings');
    const channelUrl = document.getElementById('cfg_yt_channel_url').value.trim();
    const apiKey = document.getElementById('cfg_yt_api_key').value.trim();

    if (alertBox) alertBox.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SAVING & SYNCING...';
    }

    try {
        const res = await fetch('/api/youtube/settings', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                channel_url: channelUrl,
                api_key: apiKey || null
            })
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Save failed');
        }

        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(37,211,102,0.15)';
            alertBox.style.border = '1px solid rgba(37,211,102,0.4)';
            alertBox.style.color = '#25D366';
            alertBox.textContent = '✅ ' + json.message;
        }

        if (json.data) {
            const data = json.data;
            const countEl = document.getElementById('ytVideoCountDisplay');
            const lastSyncEl = document.getElementById('ytLastSyncedDisplay');
            const nameEl = document.getElementById('ytChannelNameDisplay');
            const linkEl = document.getElementById('ytChannelLink');
            const gridCountEl = document.getElementById('ytGridCount');
            const sidebarCountEl = document.getElementById('sidebarYtCount');

            if (countEl) countEl.textContent = data.count + ' Videos';
            if (gridCountEl) gridCountEl.textContent = data.count;
            if (sidebarCountEl) sidebarCountEl.textContent = data.count;
            if (nameEl && data.channel_name) nameEl.textContent = data.channel_name;
            if (linkEl && data.channel_url) {
                linkEl.href = data.channel_url;
                linkEl.textContent = data.channel_url;
            }
            if (lastSyncEl) lastSyncEl.textContent = 'Just now';

            renderYouTubeVideoGrid(data.videos || []);
        }
    } catch (err) {
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(255,59,48,0.15)';
            alertBox.style.border = '1px solid rgba(255,59,48,0.4)';
            alertBox.style.color = '#FF3B30';
            alertBox.textContent = '❌ ' + err.message;
        }
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save" style="margin-right:6px;"></i> SAVE & SYNC CHANNEL';
        }
    }
}

function renderYouTubeVideoGrid(videos) {
    const grid = document.getElementById('ytVideosGrid');
    if (!grid) return;
    if (!videos || videos.length === 0) {
        grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;"><i class="fab fa-youtube" style="font-size:2.5rem;color:#FF0000;margin-bottom:10px;display:block;"></i>No videos synced yet. Click "SYNC LIVE VIDEOS NOW" to fetch your channel videos.</div>';
        return;
    }

    grid.innerHTML = videos.map(vid => `
        <div class="project-video-card">
            <div class="video-thumb-frame">
                <img src="${vid.thumbnail || 'https://img.youtube.com/vi/' + vid.youtubeId + '/hqdefault.jpg'}"
                     alt="${escapeHtml(vid.title)}"
                     onerror="this.src='https://img.youtube.com/vi/${vid.youtubeId}/hqdefault.jpg'">
                <div class="video-play-overlay" onclick="window.playVideoModal('${vid.videoUrl}', '${escapeHtml(vid.title)}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                    <div class="play-btn-circle">
                        <i class="fas fa-play" style="margin-left:2px;"></i>
                    </div>
                </div>
                <div style="position:absolute;bottom:8px;right:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#F0EBE0;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.15);">
                    <i class="fas fa-play" style="font-size:0.55rem;margin-right:3px;color:#D4AF37;"></i>${vid.duration || 'Video'}
                </div>
            </div>
            <div style="padding:12px 14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="font-size:0.68rem;color:#D4AF37;font-weight:700;margin-bottom:4px;">
                        ID: ${vid.youtubeId} ${vid.views ? '• ' + vid.views : ''}
                    </div>
                    <h4 style="color:#FFF;font-size:0.88rem;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="${escapeHtml(vid.title)}">
                        ${escapeHtml(vid.title)}
                    </h4>
                </div>
                <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(212,175,55,0.12);display:flex;justify-content:space-between;align-items:center;">
                    <button class="btn-whatsapp-outline" onclick="window.playVideoModal('${vid.videoUrl}', '${escapeHtml(vid.title)}')" style="padding:5px 12px;font-size:0.72rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;">
                        <i class="fas fa-play" style="margin-right:4px;"></i> Preview
                    </button>
                    <a href="${vid.watchUrl || 'https://www.youtube.com/watch?v=' + vid.youtubeId}" target="_blank" style="font-size:0.72rem;color:#FF5555;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                        <i class="fab fa-youtube"></i> Watch <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

// ── GUIDEBOOK PDF MANAGEMENT ──────────────────────────────────────
async function handleGuidebookUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    if (!file.name.toLowerCase().endsWith('.pdf') && file.type !== 'application/pdf') {
        alert('Please select a valid PDF file.');
        return;
    }
    const progress = document.getElementById('pdfUploadProgress');
    const bar      = document.getElementById('pdfProgressBar');
    const status   = document.getElementById('pdfUploadStatus');
    progress.style.display = 'block';
    status.textContent = '⏳ Uploading PDF...';

    try {
        const pdfUrl = await uploadFile(file, file.name, (p) => {
            if (bar) bar.style.width = (p.percent || 0) + '%';
            if (status) status.textContent = `Uploading PDF (${p.percent || 0}%)...`;
        });
        if (bar) bar.style.width = '95%';
        status.textContent = '💾 Saving settings...';
        const res = await fetch('/api/settings/guidebook', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ url: pdfUrl })
        });
        if (!res.ok) throw new Error('Failed to save setting (HTTP ' + res.status + ')');
        if (bar) bar.style.width = '100%';
        status.textContent = '✅ Done! Reloading...';
        setTimeout(() => location.reload(), 800);
    } catch (err) {
        progress.style.display = 'none';
        alert('❌ Upload failed: ' + err.message);
    }
}

async function deleteGuidebookPdf(event, btnEl) {
    if (event) { event.stopPropagation(); event.preventDefault(); }
    const confirmed = await showDeleteConfirmModal({
        title: 'RESET GUIDEBOOK PDF?',
        message: 'Delete the custom active Guidebook PDF? The system will revert back to the default bundled baseline PDF.',
        confirmText: 'Yes, Reset PDF'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/settings/guidebook', {
            method: 'DELETE',
            credentials: 'include',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        switchAdminTab('guidebook');
        alert('✅ Guidebook PDF reset successfully. Page will reload.');
        location.reload();
    } catch (err) {
        alert('❌ Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

// ── INTRO VIDEO MANAGEMENT ────────────────────────────────────────
async function handleIntroVideoUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    const progress = document.getElementById('videoUploadProgress');
    const bar      = document.getElementById('videoProgressBar');
    const status   = document.getElementById('videoUploadStatus');
    const metrics  = document.getElementById('introUploadMetrics');
    const pctText  = document.getElementById('introUploadPercentText');

    progress.style.display = 'block';
    status.textContent = '⏳ Uploading video (lossless chunked stream)...';

    try {
        const videoUrl = await uploadFile(file, file.name, (p) => {
            if (bar) bar.style.width = (p.percent || 0) + '%';
            if (pctText) pctText.textContent = (p.percent || 0) + '%';
            if (metrics) metrics.textContent = `${p.loadedFormatted || ''} / ${p.totalFormatted || ''} • ${p.speedFormatted || ''}`;
            if (status) status.textContent = p.status === 'assembling' ? '💾 Assembling video stream on disk...' : (p.etaFormatted ? `Uploading... ETA: ${p.etaFormatted}` : 'Uploading...');
        });

        status.textContent = '💾 Saving setting...';
        await saveIntroVideoSetting(videoUrl);
        if (bar) bar.style.width = '100%';
        status.textContent = '✅ Intro video updated successfully!';
        
        // Update display directly in the intro tab without switching to reviews
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = videoUrl;
        switchAdminTab('intro');

        setTimeout(() => {
            progress.style.display = 'none';
            alert('✅ Hero / Intro Video updated successfully!');
        }, 600);
    } catch (err) {
        progress.style.display = 'none';
        alert('❌ Upload failed: ' + err.message);
    }
}

async function saveIntroVideoUrl() {
    const url = document.getElementById('introVideoUrlInput').value.trim();
    if (!url) { alert('Please enter a video URL.'); return; }
    try {
        await saveIntroVideoSetting(url);
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = url;
        document.getElementById('introVideoUrlInput').value = '';
        switchAdminTab('intro');
        alert('✅ Intro video URL saved successfully!');
    } catch (err) {
        alert('❌ Save failed: ' + err.message);
    }
}

async function saveIntroVideoSetting(url) {
    const res = await fetch('/api/settings/intro-video', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
        body: JSON.stringify({ url: url })
    });
    if (!res.ok) throw new Error('Failed to save setting (HTTP ' + res.status + ')');
    return res.json();
}

async function deleteIntroVideo(event, btnEl) {
    if (event) { event.stopPropagation(); event.preventDefault(); }
    const confirmed = await showDeleteConfirmModal({
        title: 'RESET INTRO VIDEO?',
        message: 'Remove the active Hero / Engineer Intro video? The website will revert back to the default intro video asset.',
        confirmText: 'Yes, Reset Video'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/settings/intro-video', {
            method: 'DELETE',
            credentials: 'include',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = 'None (Using Default)';
        switchAdminTab('intro');
        alert('✅ Intro video reset successfully.');
    } catch (err) {
        alert('❌ Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

function previewIntroVideo() {
    const url = document.getElementById('activeVideoDisplay').textContent.trim();
    if (url && typeof window.playVideoModal === 'function') {
        window.playVideoModal(url, 'Engineer Intro Video Preview');
    } else {
        window.open(url, '_blank');
    }
}
</script>

</body>
</html>
