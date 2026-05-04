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