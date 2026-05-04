document.addEventListener('DOMContentLoaded', () => {

  const locationPanel = document.querySelector('[data-location-panel]');
  const mapMarkers = document.querySelectorAll('.map-marker[data-city]');

  if (!locationPanel || !mapMarkers.length) return;

  const nameEl = locationPanel.querySelector('[data-location-name]');
  const descEl = locationPanel.querySelector('[data-location-desc]');
  const focusEl = locationPanel.querySelector('[data-location-focus]');

  const locations = {
    mumbai: {
      name: 'Mumbai',
      desc: 'Our Mumbai office supports strategic advisory, operating model design, and leadership workshops for enterprise and growth-stage clients across western India.',
      focus: 'Business evaluations, transformation programs, and executive coaching.',
    },
    'port-blair': {
      name: 'Navi Mumbai',
      desc: 'The Navi Mumbai team specializes in process redesign and implementation support for logistics and infrastructure.',
      focus: 'Lean management, KPI systems, and PMO execution.',
    },
    bharuch: {
      name: 'Bharuch',
      desc: 'We partner with industrial businesses to improve throughput and quality.',
      focus: 'Operational excellence and workforce capability.',
    },
    assam: {
      name: 'Assam',
      desc: 'Regional leadership coaching and remote workshops.',
      focus: 'Management enablement and change communication.',
    }
  };

  const setActiveLocation = (cityKey) => {
  const location = locations[cityKey];
  if (!location) return;

  // ONLY toggle active class — do not modify DOM
  mapMarkers.forEach(marker => {
    if (marker.dataset.city === cityKey) {
      marker.classList.add('active');
    } else {
      marker.classList.remove('active');
    }
  });

  // Update aside safely
  nameEl.textContent = location.name;
  descEl.textContent = location.desc;
  focusEl.textContent = location.focus;
};

  mapMarkers.forEach(marker => {
    marker.addEventListener('click', () => {
      setActiveLocation(marker.dataset.city);
    });
  });

  // default selection
  setActiveLocation(mapMarkers[0].dataset.city);

});

const tooltip = document.getElementById('mapTooltip');

mapMarkers.forEach(marker => {

  marker.addEventListener('mouseenter', () => {
    tooltip.textContent = marker.dataset.label;
    tooltip.classList.add('show');
  });

  marker.addEventListener('mousemove', (e) => {
    const rect = document.querySelector('.india-map-wrap').getBoundingClientRect();

    tooltip.style.left = `${e.clientX - rect.left}px`;
    tooltip.style.top = `${e.clientY - rect.top}px`;
  });

  marker.addEventListener('mouseleave', () => {
    tooltip.classList.remove('show');
  });

});

mapMarkers.forEach(marker => {
  marker.addEventListener('click', () => {

    // bring clicked marker to front
    marker.parentNode.appendChild(marker);

    setActiveLocation(marker.dataset.city);
  });
});