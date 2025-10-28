export function initScrollClass() {
  const body = document.body;

  function handleScroll() {
    if (window.scrollY > 0) {
      body.classList.add('scrolled');
    } else {
      body.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleScroll);
  handleScroll(); // check direct bij laden
}
