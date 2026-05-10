// scripts.js — scoped per-gallery lightbox

const lightbox    = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightbox-img");
const closeBtn    = document.getElementById("close");
const nextBtn     = document.getElementById("next");
const prevBtn     = document.getElementById("prev");

let currentGalleryItems = []; // images belonging to the active gallery
let currentIndex = 0;

// Attach click handlers to every gallery image.
// Each image stores a reference to its sibling images (same .gallery wrapper).
document.querySelectorAll(".gallery").forEach((gallery) => {
  const items = Array.from(gallery.querySelectorAll(".gallery-item img"));

  items.forEach((img, index) => {
    img.addEventListener("click", () => {
      currentGalleryItems = items;   // scope to THIS gallery only
      currentIndex = index;
      lightboxImg.src = img.src;
      lightbox.style.display = "flex";
    });
  });
});

// Close
closeBtn.addEventListener("click", () => {
  lightbox.style.display = "none";
});

// Next (wraps within the active gallery)
nextBtn.addEventListener("click", () => {
  currentIndex = (currentIndex + 1) % currentGalleryItems.length;
  lightboxImg.src = currentGalleryItems[currentIndex].src;
});

// Previous (wraps within the active gallery)
prevBtn.addEventListener("click", () => {
  currentIndex = (currentIndex - 1 + currentGalleryItems.length) % currentGalleryItems.length;
  lightboxImg.src = currentGalleryItems[currentIndex].src;
});

// Close on backdrop click
lightbox.addEventListener("click", (e) => {
  if (e.target === lightbox) {
    lightbox.style.display = "none";
  }
});

// Close on Escape key
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    lightbox.style.display = "none";
  }
});