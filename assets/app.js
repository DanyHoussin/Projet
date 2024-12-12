import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// Image d'accueil / Défilement

const images = document.querySelectorAll('.image'); // Sélectionne toutes les images
let currentIndex = 0;

function showNextImage() {
    // Supprime la classe active de l'image actuelle
    images[currentIndex].classList.remove('active');
    
    // Passe à l'image suivante (retour à 0 si la fin est atteinte)
    currentIndex = (currentIndex + 1) % images.length;
    
    // Ajoute la classe active à la nouvelle image
    images[currentIndex].classList.add('active');
}

// Change l'image toutes les 5 secondes
setInterval(showNextImage, 5000);

// Smoot Scroll Animation

const initSmoothScrolling = () => {
  // Initialize Lenis for smooth scroll effects. Lerp value controls the smoothness.
  const lenis = new Lenis({ lerp: 0.15 });

  // Ensure GSAP animations are in sync with Lenis' scroll frame updates.
  gsap.ticker.add((time) => {
    lenis.raf(time * 1000); // Convert GSAP's time to milliseconds for Lenis.
  });

  // Turn off GSAP's default lag smoothing to avoid conflicts with Lenis.
  gsap.ticker.lagSmoothing(0);
};

// Activate the smooth scrolling feature.
initSmoothScrolling();