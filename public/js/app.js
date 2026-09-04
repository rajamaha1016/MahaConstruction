/* =====================================================
   MAHA CONSTRUCTION — EXACT VIDEO MATCH INTERACTIVITY
   ===================================================== */

document.addEventListener('DOMContentLoaded', function () {

  // --- Mobile Navigation Drawer Toggle ---
  const navMobileToggle = document.getElementById('navMobileToggle');
  const navMenu = document.getElementById('navMenu');

  function toggleMobileMenu() {
    if (!navMenu) return;
    const isOpen = navMenu.classList.contains('open');
    if (isOpen) {
      navMenu.classList.remove('open');
      if (navMobileToggle) navMobileToggle.classList.remove('open');
      document.body.classList.remove('menu-open');
      document.body.style.overflow = '';
    } else {
      navMenu.classList.add('open');
      if (navMobileToggle) navMobileToggle.classList.add('open');
      document.body.classList.add('menu-open');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeMobileMenu() {
    if (navMenu && navMenu.classList.contains('open')) {
      navMenu.classList.remove('open');
      if (navMobileToggle) navMobileToggle.classList.remove('open');
      document.body.classList.remove('menu-open');
      document.body.style.overflow = '';
    }
  }

  if (navMobileToggle) {
    navMobileToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleMobileMenu();
    });
  }

  if (navMenu) {
    navMenu.querySelectorAll('.nav-item').forEach(item => {
      item.addEventListener('click', closeMobileMenu);
    });
  }

  document.addEventListener('click', function (e) {
    if (navMenu && navMenu.classList.contains('open')) {
      if (!navMenu.contains(e.target) && navMobileToggle && !navMobileToggle.contains(e.target)) {
        closeMobileMenu();
      }
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeMobileMenu();
    }
  });

  // --- Sticky Floating Navbar Scroll Effect ---
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 20) {
        navbar.classList.add('is-scrolled');
      } else {
        navbar.classList.remove('is-scrolled');
      }
    }, { passive: true });
  }

  // --- Back to Top Floating Button ---
  const backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 400) {
        backToTopBtn.style.opacity = '1';
        backToTopBtn.style.pointerEvents = 'auto';
      } else {
        backToTopBtn.style.opacity = '0';
        backToTopBtn.style.pointerEvents = 'none';
      }
    });
    backToTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // --- Quote Modal Trigger ---
  const quoteModal = document.getElementById('quoteModal');
  const openQuoteBtns = document.querySelectorAll('[data-open-quote]');
  const closeQuoteModal = document.getElementById('closeQuoteModal');

  openQuoteBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      if (quoteModal) {
        quoteModal.classList.add('open');
        document.body.classList.add('modal-open');
      }
    });
  });
  if (closeQuoteModal && quoteModal) {
    closeQuoteModal.addEventListener('click', function () {
      quoteModal.classList.remove('open');
      document.body.classList.remove('modal-open');
    });
  }

  // --- Quote Modal Form AJAX Submission ---
  const quoteModalForm = document.getElementById('quoteModalForm');
  const quoteSuccessMessage = document.getElementById('quoteSuccessMessage');
  const quoteSubmitBtn = document.getElementById('quoteSubmitBtn');

  if (quoteModalForm) {
    quoteModalForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (quoteSubmitBtn) quoteSubmitBtn.innerText = 'SUBMITTING...';
      const formData = new FormData(quoteModalForm);
      const data = Object.fromEntries(formData.entries());

      fetch('/api/leads/quote', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
      })
      .then(res => res.json())
      .then(res => {
        if (quoteSubmitBtn) quoteSubmitBtn.innerText = 'SUBMIT PROPOSAL REQUEST';
        if (quoteSuccessMessage) quoteSuccessMessage.style.display = 'block';
        quoteModalForm.reset();
        setTimeout(() => {
          if (quoteModal) quoteModal.classList.remove('open');
          if (quoteSuccessMessage) quoteSuccessMessage.style.display = 'none';
        }, 3000);
      })
      .catch(err => {
        if (quoteSubmitBtn) quoteSubmitBtn.innerText = 'SUBMIT PROPOSAL REQUEST';
        alert('Thank you! Your request has been logged.');
        if (quoteModal) quoteModal.classList.remove('open');
      });
    });
  }

  // --- Universal Video Modal Player (HireAndBuild Interactive Story Model) ---
  const videoModal = document.getElementById('videoModal');
  const modalVideoPlayer = document.getElementById('modalVideoPlayer');
  const modalYoutubePlayer = document.getElementById('modalYoutubePlayer');
  const modalVideoTitle = document.getElementById('modalVideoTitle');
  const modalStorySwitcher = document.getElementById('modalStorySwitcher');
  const modalStoryCounter = document.getElementById('modalStoryCounter');
  const modalPrevStoryBtn = document.getElementById('modalPrevStoryBtn');
  const modalNextStoryBtn = document.getElementById('modalNextStoryBtn');
  const closeVideoModal = document.getElementById('closeVideoModal');

  let currentModalStoryIdx = 0;
  let activeStoriesList = [];

  function collectStories() {
    const cards = Array.from(document.querySelectorAll('.story-card[data-video-url]'));
    activeStoriesList = cards.map(c => ({
      url: c.getAttribute('data-video-url'),
      title: c.getAttribute('data-client-name') ? `MAHA CONSTRUCTIONS · ${c.getAttribute('data-client-name')}` : 'MAHA CONSTRUCTIONS CLIENT STORY'
    }));
  }

  function getYouTubeEmbedUrl(url) {
    if (!url) return '';
    let videoId = '';
    if (url.includes('youtube.com/watch')) {
      const match = url.match(/[?&]v=([^&]+)/);
      if (match) videoId = match[1];
    } else if (url.includes('youtu.be/')) {
      const match = url.match(/youtu\.be\/([^?&]+)/);
      if (match) videoId = match[1];
    } else if (url.includes('youtube.com/shorts/')) {
      const match = url.match(/shorts\/([^?&]+)/);
      if (match) videoId = match[1];
    } else if (url.includes('youtube.com/embed/')) {
      return url.includes('autoplay=1') ? url : (url + (url.includes('?') ? '&' : '?') + 'autoplay=1&rel=0');
    }
    if (videoId) {
      return `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    }
    return url;
  }

  window.playVideoModal = function (url, title = 'MAHA CONSTRUCTIONS STORY') {
    if (!videoModal || !url) return;
    if (modalVideoTitle) modalVideoTitle.innerText = title;
    if (modalStorySwitcher) modalStorySwitcher.style.display = 'none';

    if (url.includes('youtube.com') || url.includes('youtu.be')) {
      if (modalVideoPlayer) {
        modalVideoPlayer.pause();
        modalVideoPlayer.removeAttribute('src');
        modalVideoPlayer.load();
        modalVideoPlayer.style.display = 'none';
      }
      if (modalYoutubePlayer) {
        modalYoutubePlayer.style.display = 'block';
        modalYoutubePlayer.src = getYouTubeEmbedUrl(url);
      }
    } else {
      if (modalYoutubePlayer) {
        modalYoutubePlayer.src = '';
        modalYoutubePlayer.style.display = 'none';
      }
      if (modalVideoPlayer) {
        modalVideoPlayer.style.display = 'block';
        modalVideoPlayer.src = url;
        modalVideoPlayer.load();
        const playPromise = modalVideoPlayer.play();
        if (playPromise !== undefined) {
          playPromise.catch(() => {
            // Autoplay with sound might be restricted; user can click play
          });
        }
      }
    }
    videoModal.classList.add('open');
  };

  window.playStoryIndex = function (index) {
    collectStories();
    if (activeStoriesList.length === 0) return;
    currentModalStoryIdx = Math.max(0, Math.min(activeStoriesList.length - 1, index));
    const story = activeStoriesList[currentModalStoryIdx];
    if (!story) return;

    window.playVideoModal(story.url, story.title);
    if (modalStorySwitcher && activeStoriesList.length > 1) {
      modalStorySwitcher.style.display = 'flex';
      if (modalStoryCounter) modalStoryCounter.innerText = `STORY ${currentModalStoryIdx + 1} / ${activeStoriesList.length}`;
    }
  };

  if (modalPrevStoryBtn) {
    modalPrevStoryBtn.addEventListener('click', () => {
      if (currentModalStoryIdx > 0) {
        window.playStoryIndex(currentModalStoryIdx - 1);
      }
    });
  }
  if (modalNextStoryBtn) {
    modalNextStoryBtn.addEventListener('click', () => {
      if (currentModalStoryIdx < activeStoriesList.length - 1) {
        window.playStoryIndex(currentModalStoryIdx + 1);
      }
    });
  }

  function hideVideoModal() {
    if (!videoModal) return;
    videoModal.classList.remove('open');
    if (modalVideoPlayer) {
      modalVideoPlayer.pause();
      modalVideoPlayer.removeAttribute('src');
      modalVideoPlayer.load();
    }
    if (modalYoutubePlayer) {
      modalYoutubePlayer.src = '';
    }
  }

  if (closeVideoModal) {
    closeVideoModal.addEventListener('click', hideVideoModal);
  }
  if (videoModal) {
    videoModal.addEventListener('click', function (e) {
      if (e.target === this) hideVideoModal();
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && videoModal && videoModal.classList.contains('open')) {
      hideVideoModal();
    }
  });

  // Bind non-story video trigger buttons
  document.querySelectorAll('[data-video-url]:not(.story-card)').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      const url = this.getAttribute('data-video-url');
      if (url) window.playVideoModal(url);
    });
  });

  // --- Package Comparison Matrix Modal ---
  const packageMatrixModal = document.getElementById('packageMatrixModal');
  const closeMatrixModal = document.getElementById('closeMatrixModal');
  const btnCloseMatrix = document.getElementById('btnCloseMatrix');

  window.openPackageMatrixModal = function () {
    if (packageMatrixModal) packageMatrixModal.classList.add('open');
  };

  if (closeMatrixModal && packageMatrixModal) {
    closeMatrixModal.addEventListener('click', function () {
      packageMatrixModal.classList.remove('open');
    });
  }
  if (btnCloseMatrix && packageMatrixModal) {
    btnCloseMatrix.addEventListener('click', function () {
      packageMatrixModal.classList.remove('open');
    });
  }

  document.querySelectorAll('[data-open-matrix]').forEach(btn => {
    btn.addEventListener('click', function () {
      window.openPackageMatrixModal();
    });
  });

  // Modal matrix division switcher (Residential / Commercial)
  document.querySelectorAll('.modal-mat-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.modal-mat-toggle').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const targetId = this.getAttribute('data-target-matrix');
      const resWrap = document.getElementById('modalMatResWrap');
      const comWrap = document.getElementById('modalMatComWrap');
      if (resWrap && comWrap) {
        if (targetId === 'modalMatComWrap') {
          resWrap.style.display = 'none';
          comWrap.style.display = 'block';
        } else {
          resWrap.style.display = 'block';
          comWrap.style.display = 'none';
        }
      }
    });
  });

  // --- Package Details Modal (Inclusions & Exclusions) ---
  const packageDetailsModal = document.getElementById('packageDetailsModal');
  const closePackageDetailsModal = document.getElementById('closePackageDetailsModal');
  let currentActivePackage = null;

  window.openPackageDetailsModal = function (pkg) {
    if (!pkg || !packageDetailsModal) return;
    currentActivePackage = pkg;

    const division = (pkg.division || 'residential').toUpperCase();
    const rawTier = (pkg.tier || 'standard').toUpperCase();
    const cleanTier = rawTier.replace(/\bTIER\b/i, '').trim();
    const tier = cleanTier ? cleanTier + ' TIER' : 'STANDARD TIER';
    const title = (pkg.title || 'PACKAGE').toUpperCase();
    const subtitle = pkg.subtitle || '';
    const rawPrice = pkg.price_per_sqft;
    const hasPrice = rawPrice !== null && rawPrice !== undefined && rawPrice !== '' && Number(rawPrice) > 0;
    const price = hasPrice ? Number(rawPrice).toLocaleString('en-IN') : null;
    const warranty = pkg.warranty_years ? `${pkg.warranty_years} Yrs Structural Warranty` : '10 Yrs Structural Warranty';
    const delivery = pkg.delivery_months ? `${pkg.delivery_months} Months Delivery` : '12 Months Delivery';
    const desc = pkg.description || `A complete ${cleanTier || 'standard'} construction package engineered for durability, premium craftsmanship, and full material transparency.`;

    const elTier = document.getElementById('modalPkgTierLabel');
    if (elTier) elTier.textContent = `${division} • ${tier}`;

    const elTitle = document.getElementById('modalPkgTitle');
    if (elTitle) elTitle.textContent = title;

    const elSub = document.getElementById('modalPkgSubtitle');
    if (elSub) elSub.textContent = subtitle;

    const elPrice = document.getElementById('modalPkgPrice');
    if (elPrice) {
      if (price) {
        elPrice.innerHTML = `₹${price} <span>/ sq.ft</span>`;
      } else {
        elPrice.innerHTML = `<span style="font-size:1.35rem;letter-spacing:0.02em;">CUSTOM ESTIMATE</span>`;
      }
    }

    const elWarranty = document.getElementById('modalPkgWarranty');
    if (elWarranty) elWarranty.innerHTML = `<i class="fas fa-shield-halved" style="color:var(--gold);"></i> ${warranty}`;

    const elDelivery = document.getElementById('modalPkgDelivery');
    if (elDelivery) elDelivery.innerHTML = `<i class="fas fa-calendar-check" style="color:var(--gold);"></i> ${delivery}`;

    const elDesc = document.getElementById('modalPkgDescription');
    if (elDesc) elDesc.textContent = desc;

    // Render Inclusions
    const elInc = document.getElementById('modalPkgInclusions');
    if (elInc) {
      elInc.innerHTML = '';
      const inclusions = Array.isArray(pkg.inclusions) ? pkg.inclusions : [];
      if (inclusions.length) {
        inclusions.forEach(item => {
          const li = document.createElement('li');
          li.innerHTML = `<i class="fas fa-circle-check" style="color:#10B981;"></i> <span>${item}</span>`;
          elInc.appendChild(li);
        });
      } else {
        elInc.innerHTML = `<li style="color:#94A3B8;font-style:italic;">Standard civil structural, masonry & MEP works included.</li>`;
      }
    }

    // Render Exclusions
    const elExc = document.getElementById('modalPkgExclusions');
    if (elExc) {
      elExc.innerHTML = '';
      const exclusions = Array.isArray(pkg.exclusions) ? pkg.exclusions : [];
      if (exclusions.length) {
        exclusions.forEach(item => {
          const li = document.createElement('li');
          li.innerHTML = `<i class="fas fa-circle-xmark" style="color:#EF4444;"></i> <span>${item}</span>`;
          elExc.appendChild(li);
        });
      } else {
        elExc.innerHTML = `<li style="color:#94A3B8;font-style:italic;">All listed standard specifications included. Premium upgrades available on request.</li>`;
      }
    }

    // Render Material Features & Specifications
    const elFeat = document.getElementById('modalPkgFeatures');
    if (elFeat) {
      elFeat.innerHTML = '';
      const features = Array.isArray(pkg.features) ? pkg.features : [];
      if (features.length) {
        features.forEach(item => {
          const li = document.createElement('li');
          li.innerHTML = `<i class="fas fa-check" style="color:var(--gold);font-size:0.75rem;"></i> <span>${item}</span>`;
          elFeat.appendChild(li);
        });
      } else {
        elFeat.innerHTML = `<li style="color:#94A3B8;font-style:italic;">Brand-grade materials adhering to IS specifications.</li>`;
      }
    }

    // Update WhatsApp link
    const elWA = document.getElementById('btnPkgWhatsApp');
    if (elWA) {
      const priceText = price ? `₹${price}/sq.ft` : 'Custom Estimate';
      const waMsg = encodeURIComponent(`Hello Er. Maha Rajan, I would like to inquire about the ${pkg.title || 'Package'} (${priceText}, ${division} • ${tier}). Please share more details.`);
      const rawWA = (window.companyWhatsappRaw || '919095929543').toString().replace(/[^0-9]/g, '');
      const targetWA = rawWA.length === 10 ? ('91' + rawWA) : (rawWA || '919095929543');
      elWA.href = `https://wa.me/${targetWA}?text=${waMsg}`;
    }

    packageDetailsModal.classList.add('open');
    document.body.classList.add('modal-open');
  };

  if (closePackageDetailsModal && packageDetailsModal) {
    closePackageDetailsModal.addEventListener('click', function () {
      packageDetailsModal.classList.remove('open');
      document.body.classList.remove('modal-open');
    });
  }

  // Click outside backdrop to close
  if (packageDetailsModal) {
    packageDetailsModal.addEventListener('click', function (e) {
      if (e.target === packageDetailsModal) {
        packageDetailsModal.classList.remove('open');
        document.body.classList.remove('modal-open');
      }
    });
  }

  // Listen on [data-open-package-details]
  document.querySelectorAll('[data-open-package-details]').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const raw = this.getAttribute('data-package');
      if (raw) {
        try {
          const pkg = JSON.parse(raw);
          window.openPackageDetailsModal(pkg);
        } catch (err) {
          console.error('Failed to parse package data', err);
        }
      }
    });
  });

  // Action button: REQUEST ESTIMATE FOR THIS PACKAGE
  const btnPkgRequestQuote = document.getElementById('btnPkgRequestQuote');
  if (btnPkgRequestQuote) {
    btnPkgRequestQuote.addEventListener('click', function () {
      if (packageDetailsModal) packageDetailsModal.classList.remove('open');
      if (quoteModal) {
        quoteModal.classList.add('open');
        document.body.classList.add('modal-open');

        if (currentActivePackage) {
          const div = (currentActivePackage.division || '').toLowerCase();
          const projTypeSelect = quoteModal.querySelector('select[name="project_type"]');
          if (projTypeSelect) {
            if (div === 'commercial') {
              projTypeSelect.value = 'Commercial Building';
            } else {
              projTypeSelect.value = 'Residential Villa';
            }
          }
          const messageInput = quoteModal.querySelector('textarea[name="message"]');
          if (messageInput) {
            messageInput.value = `Interested in: ${currentActivePackage.title} (${currentActivePackage.division ? currentActivePackage.division.toUpperCase() : ''} • ${currentActivePackage.tier ? currentActivePackage.tier.toUpperCase() : ''}) — ₹${Number(currentActivePackage.price_per_sqft || 0).toLocaleString('en-IN')}/sq.ft turnkey package.`;
          }
        }
      }
    });
  }

  // --- Residential / Commercial Package Tab Toggles ---
  const packageTabs = document.querySelectorAll('.package-tab-btn');
  packageTabs.forEach(tab => {
    tab.addEventListener('click', function () {
      packageTabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      const targetGroup = this.getAttribute('data-target-group');
      document.querySelectorAll('.package-group').forEach(group => {
        if (group.id === targetGroup) {
          group.style.display = 'grid';
        } else {
          group.style.display = 'none';
        }
      });
    });
  });

  // --- Free Home Builder's Guide Download Form ---
  const guideBookForm = document.getElementById('guideBookForm');
  const guideSuccessBox = document.getElementById('guideSuccessBox');
  const downloadAgainBtn = document.getElementById('downloadAgainBtn');

  if (guideBookForm) {
    guideBookForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const name = guideBookForm.querySelector('input[name="name"]')?.value || 'Guest';
      const phone = guideBookForm.querySelector('input[name="phone"]')?.value || '';
      const email = guideBookForm.querySelector('input[name="email"]')?.value || '';

      // 1. Submit lead to database and get dynamic PDF URL back
      fetch('/api/leads/guidebook', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ name, phone, email })
      })
      .then(res => res.json())
      .then(data => {
        const pdfUrl = data.pdf_url || '/uploads/1785792673_new book.pdf';

        // 2. Trigger auto-download
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = 'Nam_Kanavu_Illam_Home_Builders_Guide.pdf';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Store for "Download Again" button
        window._guidebookPdfUrl = pdfUrl;

        // 3. Reveal success card
        guideBookForm.style.display = 'none';
        if (guideSuccessBox) {
          guideSuccessBox.style.display = 'block';
          const namePlaceholder = guideSuccessBox.querySelector('.user-name-placeholder');
          if (namePlaceholder) namePlaceholder.innerText = name;
        }
      })
      .catch(err => {
        console.log('Guidebook lead logged locally', err);
        // fallback: still download
        const pdfUrl = '/uploads/1785792673_new book.pdf';
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = 'Nam_Kanavu_Illam_Home_Builders_Guide.pdf';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        guideBookForm.style.display = 'none';
        if (guideSuccessBox) guideSuccessBox.style.display = 'block';
      });
    });
  }

  if (downloadAgainBtn) {
    downloadAgainBtn.addEventListener('click', function () {
      const pdfUrl = window._guidebookPdfUrl || '/uploads/1785792673_new book.pdf';
      window.open(pdfUrl, '_blank');
    });
  }

  // --- Search Overlay ---
  const searchOverlay = document.getElementById('searchOverlay');
  const searchToggleBtn = document.getElementById('searchToggleBtn');
  const searchCloseBtn = document.getElementById('searchCloseBtn');

  if (searchToggleBtn && searchOverlay) {
    searchToggleBtn.addEventListener('click', () => searchOverlay.classList.add('open'));
  }
  if (searchCloseBtn && searchOverlay) {
    searchCloseBtn.addEventListener('click', () => searchOverlay.classList.remove('open'));
  }
  if (searchOverlay) {
    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) searchOverlay.classList.remove('open');
    });
  }

  // --- Universal Auto Slideshow Engine (Stories & Homes) ---
  function setupAutoSlideshow(config) {
    const track = document.getElementById(config.trackId);
    if (!track) return null;
    const cards = Array.from(track.querySelectorAll('.' + config.cardClass));
    if (cards.length === 0) return null;

    const dotsWrap = document.getElementById(config.dotsWrapId);
    const progressFill = document.getElementById(config.progressFillId);
    const prevBtn = document.getElementById(config.prevBtnId);
    const nextBtn = document.getElementById(config.nextBtnId);

    let currentIdx = 0;
    let timer = null;

    // Clear & build pagination dots
    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      cards.forEach((_, i) => {
        const dot = document.createElement('span');
        dot.className = 'stories-dot' + (i === 0 ? ' is-active' : '');
        dot.style.cursor = 'pointer';
        dot.addEventListener('click', (e) => {
          e.stopPropagation();
          goToSlide(i);
          restartTimer();
        });
        dotsWrap.appendChild(dot);
      });
    }
    const dots = dotsWrap ? Array.from(dotsWrap.children) : [];

    function goToSlide(index) {
      if (cards.length === 0) return;
      currentIdx = (index + cards.length) % cards.length;

      // Update card visual highlight
      cards.forEach((c, i) => {
        if (i === currentIdx) {
          c.classList.add('is-active');
        } else {
          c.classList.remove('is-active');
        }
      });

      // Update pagination dots
      dots.forEach((d, i) => {
        if (i === currentIdx) {
          d.classList.add('is-active');
        } else {
          d.classList.remove('is-active');
        }
      });

      // Update progress bar
      if (progressFill) {
        if (cards.length > 1) {
          progressFill.style.width = ((currentIdx) / (cards.length - 1)) * 100 + '%';
        } else {
          progressFill.style.width = '100%';
        }
      }

      // Smooth center scroll
      const activeCard = cards[currentIdx];
      if (activeCard) {
        const scrollPos = activeCard.offsetLeft - (track.clientWidth - activeCard.clientWidth) / 2;
        track.scrollTo({
          left: Math.max(0, scrollPos),
          behavior: 'smooth'
        });
      }
    }

    function nextSlide() {
      goToSlide(currentIdx + 1);
    }

    function prevSlide() {
      goToSlide(currentIdx - 1);
    }

    function startTimer() {
      stopTimer();
      if (cards.length > 1) {
        timer = setInterval(nextSlide, config.intervalMs || 3000);
      }
    }

    function stopTimer() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    function restartTimer() {
      stopTimer();
      startTimer();
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        prevSlide();
        restartTimer();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        nextSlide();
        restartTimer();
      });
    }

    // Pause on hover
    track.addEventListener('mouseenter', stopTimer);
    track.addEventListener('mouseleave', startTimer);

    // Touch swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    track.addEventListener('touchstart', (e) => {
      stopTimer();
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      if (touchStartX - touchEndX > 35) {
        nextSlide();
      } else if (touchEndX - touchStartX > 35) {
        prevSlide();
      }
      startTimer();
    }, { passive: true });

    // Initialize first slide and start auto-slideshow
    goToSlide(0);
    startTimer();

    return { goToSlide, nextSlide, prevSlide };
  }

  // Initialize Client Satisfaction Stories Slideshow (3s interval)
  setupAutoSlideshow({
    trackId: 'storiesTrack',
    cardClass: 'story-card',
    dotsWrapId: 'storiesDots',
    progressFillId: 'storiesProgressFill',
    prevBtnId: 'storiesPrevBtn',
    nextBtnId: 'storiesNextBtn',
    intervalMs: 3000
  });

  // Initialize HOMES WE'VE PROUDLY DELIVERED Slideshow (3s interval)
  setupAutoSlideshow({
    trackId: 'projectsTrack',
    cardClass: 'project-slide-card',
    dotsWrapId: 'projectsDots',
    progressFillId: 'projectsProgressFill',
    prevBtnId: 'projectsPrevBtn',
    nextBtnId: 'projectsNextBtn',
    intervalMs: 3000
  });

  // --- Contact Form Submission ---
  const contactFormCore = document.getElementById('contactFormCore');
  const contactSuccessCore = document.getElementById('contactSuccessCore');

  if (contactFormCore) {
    contactFormCore.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(contactFormCore);
      const data = Object.fromEntries(formData.entries());

      fetch('/api/leads/contact', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
      })
      .then(() => {
        contactFormCore.reset();
        if (contactSuccessCore) contactSuccessCore.style.display = 'block';
        setTimeout(() => {
          if (contactSuccessCore) contactSuccessCore.style.display = 'none';
        }, 4000);
      })
      .catch(() => {
        if (contactSuccessCore) contactSuccessCore.style.display = 'block';
      });
    });
  }

});
