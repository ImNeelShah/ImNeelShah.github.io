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

// Keyboard navigation: Escape closes, arrow keys navigate
document.addEventListener("keydown", (e) => {
  if (lightbox.style.display !== "flex") return;
  if (e.key === "Escape")     lightbox.style.display = "none";
  if (e.key === "ArrowRight") nextBtn.click();
  if (e.key === "ArrowLeft")  prevBtn.click();
});

// Touch swipe support for mobile
let touchStartX = 0;
let touchStartY = 0;

lightbox.addEventListener("touchstart", (e) => {
  touchStartX = e.changedTouches[0].clientX;
  touchStartY = e.changedTouches[0].clientY;
}, { passive: true });

lightbox.addEventListener("touchend", (e) => {
  const dx = e.changedTouches[0].clientX - touchStartX;
  const dy = e.changedTouches[0].clientY - touchStartY;

  // Treat as horizontal swipe only when it's clearly sideways (> 50 px)
  if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 50) {
    if (dx < 0) nextBtn.click();  // swipe left  → next
    else        prevBtn.click();  // swipe right → prev
  }
}, { passive: true });