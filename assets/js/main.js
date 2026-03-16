// Main JavaScript for Colleen Adventures

document.addEventListener("DOMContentLoaded", function () {
  // Mobile Menu Toggle
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburger) {
    hamburger.addEventListener("click", function () {
      this.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  }

  // Close menu when clicking a link
  const navLinks = document.querySelectorAll(".nav-menu a");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      hamburger.classList.remove("active");
      navMenu.classList.remove("active");
    });
  });

  // Gallery Filtering
  const filterBtns = document.querySelectorAll(".filter-btn");
  const galleryItems = document.querySelectorAll(".gallery-item");

  if (filterBtns.length > 0) {
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", function () {
        // Remove active class from all buttons
        filterBtns.forEach((b) => b.classList.remove("active"));
        // Add active class to clicked button
        this.classList.add("active");

        const filterValue = this.getAttribute("data-filter");

        galleryItems.forEach((item) => {
          if (
            filterValue === "all" ||
            item.getAttribute("data-category") === filterValue
          ) {
            item.style.display = "block";
            setTimeout(() => {
              item.style.opacity = "1";
              item.style.transform = "scale(1)";
            }, 100);
          } else {
            item.style.opacity = "0";
            item.style.transform = "scale(0.8)";
            setTimeout(() => {
              item.style.display = "none";
            }, 300);
          }
        });
      });
    });
  }

  // Testimonial Slider (simple version)
  const testimonialCards = document.querySelectorAll(".testimonial-card");
  if (testimonialCards.length > 0) {
    let currentTestimonial = 0;

    // Hide all except first
    testimonialCards.forEach((card, index) => {
      if (index !== 0) {
        card.style.display = "none";
      }
    });

    // Auto rotate every 5 seconds
    setInterval(() => {
      testimonialCards[currentTestimonial].style.display = "none";
      currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
      testimonialCards[currentTestimonial].style.display = "block";
    }, 5000);
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Form validation
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      let isValid = true;
      const requiredFields = this.querySelectorAll("[required]");

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add("error");

          // Create error message if not exists
          let errorMsg = field.parentNode.querySelector(".error-message");
          if (!errorMsg) {
            errorMsg = document.createElement("span");
            errorMsg.className = "error-message";
            errorMsg.textContent = "This field is required";
            field.parentNode.appendChild(errorMsg);
          }
        } else {
          field.classList.remove("error");
          const errorMsg = field.parentNode.querySelector(".error-message");
          if (errorMsg) {
            errorMsg.remove();
          }
        }
      });

      // Email validation
      const emailFields = this.querySelectorAll('input[type="email"]');
      emailFields.forEach((field) => {
        if (field.value && !field.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
          isValid = false;
          field.classList.add("error");

          let errorMsg = field.parentNode.querySelector(".error-message");
          if (!errorMsg) {
            errorMsg = document.createElement("span");
            errorMsg.className = "error-message";
            errorMsg.textContent = "Please enter a valid email";
            field.parentNode.appendChild(errorMsg);
          }
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });
  });

  // Phone number formatting
  const phoneInputs = document.querySelectorAll('input[type="tel"]');
  phoneInputs.forEach((input) => {
    input.addEventListener("input", function (e) {
      let value = this.value.replace(/\D/g, "");
      if (value.length > 0) {
        if (value.length <= 3) {
          value = value;
        } else if (value.length <= 6) {
          value = value.slice(0, 3) + " " + value.slice(3);
        } else {
          value =
            value.slice(0, 3) +
            " " +
            value.slice(3, 6) +
            " " +
            value.slice(6, 10);
        }
        this.value = value;
      }
    });
  });

  // Back to top button
  const backToTop = document.createElement("button");
  backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
  backToTop.className = "back-to-top";
  backToTop.style.cssText = `
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        z-index: 999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: all 0.3s;
    `;

  backToTop.addEventListener("mouseenter", function () {
    this.style.background = "var(--secondary-color)";
  });

  backToTop.addEventListener("mouseleave", function () {
    this.style.background = "var(--primary-color)";
  });

  backToTop.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  document.body.appendChild(backToTop);

  window.addEventListener("scroll", function () {
    if (window.scrollY > 500) {
      backToTop.style.display = "block";
    } else {
      backToTop.style.display = "none";
    }
  });

  // Lazy loading images
  const images = document.querySelectorAll("img[data-src]");
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.add("loaded");
        observer.unobserve(img);
      }
    });
  });

  images.forEach((img) => imageObserver.observe(img));

  // Add loading class to images
  const allImages = document.querySelectorAll("img");
  allImages.forEach((img) => {
    img.addEventListener("load", function () {
      this.classList.add("loaded");
    });
  });
});

// Add error handling for images
window.addEventListener(
  "error",
  function (e) {
    if (e.target.tagName === "IMG") {
      e.target.src = "assets/images/default.jpg";
      e.target.onerror = null;
    }
  },
  true,
);
