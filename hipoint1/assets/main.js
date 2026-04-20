const toggle = document.querySelector('[data-nav-toggle]');
const menu = document.querySelector('[data-nav-menu]');

if (toggle && menu) {
  toggle.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
  });

  menu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      menu.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

const logoTrack = document.querySelector('[data-logo-track]');

if (logoTrack && logoTrack.children.length > 1) {
  const scrollLogos = () => {
    const first = logoTrack.firstElementChild;
    if (!first) return;

    const gap = parseFloat(getComputedStyle(logoTrack).columnGap || getComputedStyle(logoTrack).gap || '0');
    const offset = first.getBoundingClientRect().width + gap;

    logoTrack.style.transition = 'transform 0.7s ease';
    logoTrack.style.transform = `translateX(-${offset}px)`;

    logoTrack.addEventListener('transitionend', () => {
      logoTrack.style.transition = 'none';
      logoTrack.appendChild(first);
      logoTrack.style.transform = 'translateX(0)';
    }, { once: true });
  };

  setInterval(scrollLogos, 3000);
}

const locationPanel = document.querySelector('[data-location-panel]');
const mapMarkers = document.querySelectorAll('.map-marker[data-city]');

if (locationPanel && mapMarkers.length) {
  const nameEl = locationPanel.querySelector('[data-location-name]');
  const descEl = locationPanel.querySelector('[data-location-desc]');
  const focusEl = locationPanel.querySelector('[data-location-focus]');

  const locations = {
    mumbai: {
      name: 'Mumbai',
      desc: 'Our Mumbai office supports strategic advisory, operating model design, and leadership workshops for enterprise and growth-stage clients across western India.',
      focus: 'Business evaluations, transformation programs, and executive coaching.',
    },
    'navi-mumbai': {
      name: 'Navi Mumbai',
      desc: 'The Navi Mumbai team specializes in process redesign and implementation support for logistics, infrastructure, and technology-enabled services organizations.',
      focus: 'Lean management, KPI systems, and PMO execution.',
    },
    bharuch: {
      name: 'Bharuch',
      desc: 'From Bharuch, we partner with industrial and manufacturing businesses to improve throughput, quality, and organizational alignment.',
      focus: 'Operational excellence, workforce capability, and safety-led transformation.',
    },
    assam: {
      name: 'Assam',
      desc: 'Our Assam service network delivers regional leadership coaching and remote workshops for teams distributed across North-East India.',
      focus: 'Remote workshops, management enablement, and change communication.',
    },
    'port-blair': {
      name: 'Port-Blair',
      desc: 'Our Assam service network delivers regional leadership coaching and remote workshops for teams distributed across North-East India.',
      focus: 'Remote workshops, management enablement, and change communication.',
    },
  };

  const setActiveLocation = (cityKey) => {
    const location = locations[cityKey];
    if (!location || !nameEl || !descEl || !focusEl) return;

    mapMarkers.forEach((marker) => {
      marker.classList.toggle('active', marker.dataset.city === cityKey);
    });

    nameEl.textContent = location.name;
    descEl.textContent = location.desc;
    focusEl.textContent = location.focus;
  };

  mapMarkers.forEach((marker) => {
    marker.addEventListener('click', () => {
      setActiveLocation(marker.dataset.city);
    });
  });

  setActiveLocation(mapMarkers[0].dataset.city);
}

const codepenMap = document.querySelector('.codepen-map');
const mapFallback = document.querySelector('.map-fallback');

if (codepenMap && mapFallback) {
  const showFallback = () => {
    codepenMap.style.display = 'none';
    mapFallback.style.display = 'block';
  };

  codepenMap.addEventListener('error', showFallback);
}
