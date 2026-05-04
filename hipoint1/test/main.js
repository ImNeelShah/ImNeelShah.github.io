document.addEventListener('DOMContentLoaded', () => {

  const svg = document.querySelector('.india-map-wrap svg');
  const tooltip = document.getElementById('mapTooltip');
  const tooltipTitle = tooltip.querySelector('.tooltip-title');
  const tooltipDesc = tooltip.querySelector('.tooltip-desc');
  const mapWrap = document.querySelector('.india-map-wrap');

  const nameEl = document.querySelector('[data-location-name]');
  const descEl = document.querySelector('[data-location-desc]');
  const focusEl = document.querySelector('[data-location-focus]');

  const locations = {
    mumbai: {
      name: 'Mumbai',
      desc: 'Strategic advisory & leadership workshops',
      focus: 'Business transformation'
    },
    'navi-mumbai': {
      name: 'Navi Mumbai',
      desc: 'Logistics & infrastructure support',
      focus: 'Operations'
    },
    bharuch: {
      name: 'Bharuch',
      desc: 'Industrial consulting',
      focus: 'Manufacturing'
    },
    assam: {
      name: 'Assam',
      desc: 'Regional leadership programs',
      focus: 'North-east'
    }
  };

  let activeMarker = null;

  // CLICK (delegated)
  svg.addEventListener('click', (e) => {
    const marker = e.target.closest('.map-marker');
    if (!marker) return;

    const city = marker.dataset.city;
    const location = locations[city];
    if (!location) return;

    // update active
    document.querySelectorAll('.map-marker').forEach(m => m.classList.remove('active'));
    marker.classList.add('active');

    // bring to front
    marker.parentNode.appendChild(marker);

    // update aside
    nameEl.textContent = location.name;
    descEl.textContent = location.desc;
    focusEl.textContent = location.focus;
  });

  // HOVER SHOW
  svg.addEventListener('mouseover', (e) => {
    const marker = e.target.closest('.map-marker');
    if (!marker) return;

    tooltipTitle.textContent = marker.dataset.label;
    tooltipDesc.textContent = marker.dataset.desc;
    tooltip.classList.add('show');
  });

  // MOVE
  svg.addEventListener('mousemove', (e) => {
    if (!tooltip.classList.contains('show')) return;

    const rect = mapWrap.getBoundingClientRect();
    tooltip.style.left = `${e.clientX - rect.left}px`;
    tooltip.style.top = `${e.clientY - rect.top}px`;
  });

  // HIDE
  svg.addEventListener('mouseout', (e) => {
    if (e.target.closest('.map-marker')) {
      tooltip.classList.remove('show');
    }
  });

});

document.querySelectorAll('.map-marker').forEach(m => {
  m.addEventListener('click', () => {
    console.log('MARKER CLICKED:', m.dataset.city);
  });
});

svg.addEventListener('mouseover', (e) => {
  const marker = e.target.closest('.map-marker');
  if (!marker) return;

  console.log('HOVER DETECTED');

  tooltip.style.opacity = '1';
  tooltip.style.background = 'red';
  tooltip.textContent = marker.dataset.city;
});