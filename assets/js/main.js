

document.addEventListener('DOMContentLoaded', function () {

  const navbar = document.getElementById('kwNavbar');
  function handleScroll() {
    if (window.scrollY > 12) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }
  window.addEventListener('scroll', handleScroll);
  handleScroll();

  const waveform = document.querySelector('.kw-waveform');
  if (waveform) {
    const barCount = 90;
    const barWidth = 1200 / barCount;
    let svgBars = '';
    for (let i = 0; i < barCount; i++) {
      const heightSeed = Math.sin(i * 0.45) * 0.5 + 0.5; // wave-like height variance
      const height = 10 + heightSeed * 40;
      const y = (64 - height) / 2;
      const delay = (i * 0.025).toFixed(3);
      svgBars += `<rect x="${(i * barWidth).toFixed(1)}" y="${y.toFixed(1)}" width="${(barWidth * 0.55).toFixed(1)}" height="${height.toFixed(1)}" rx="1.5" style="animation-delay:${delay}s"></rect>`;
    }
    waveform.innerHTML = svgBars;
  }

  document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId.length > 1) {
        const target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          // collapse mobile nav if open
          const navMenu = document.getElementById('kwNavMenu');
          if (navMenu && navMenu.classList.contains('show')) {
            const bsCollapse = bootstrap.Collapse.getInstance(navMenu) || new bootstrap.Collapse(navMenu);
            bsCollapse.hide();
          }
        }
      }
    });
  });

});
