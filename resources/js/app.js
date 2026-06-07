import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

Alpine.data('siteHeader', () => ({
  mobileOpen: false,
  isSticky: false,

  init() {
    this.onScroll();
  },

  onScroll() {
    this.isSticky = window.scrollY > 80;
  },

  toggleMobile() {
    this.mobileOpen = !this.mobileOpen;
    document.body.classList.toggle('overflow-hidden', this.mobileOpen);
  },

  closeMobile() {
    this.mobileOpen = false;
    document.body.classList.remove('overflow-hidden');
  },
}));

window.Alpine = Alpine;
Alpine.start();
