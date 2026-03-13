/**
 * Zenizee Admin — Initialization
 * One-time migration: clears Cuba's cached purple palette from localStorage.
 */
(function() {
  var oldPrimary = localStorage.getItem('primary');
  var oldSecondary = localStorage.getItem('secondary');
  if (oldPrimary === '#7366ff' || oldSecondary === '#f73164' || oldPrimary === null) {
    localStorage.setItem('primary', '#D88827');
    localStorage.setItem('secondary', '#B8721F');
  }
})();
