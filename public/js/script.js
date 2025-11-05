// Create floating particles
    function createParticles() {
      const particlesContainer = document.getElementById('particles');
      const particleCount = 15;

      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.width = Math.random() * 6 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.animationDelay = Math.random() * 6 + 's';
        particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
        particlesContainer.appendChild(particle);
      }
    }

    // Enhanced sticky header with smooth transitions
    let lastScrollTop = 0;
    const header = document.getElementById('mainHeader');
    
    window.addEventListener("scroll", () => {
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      // Enhanced header behavior
      if (scrollTop > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.backdropFilter = 'blur(20px)';
        header.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
      } else {
        header.style.background = 'rgba(255, 255, 255, 0.8)';
        header.style.backdropFilter = 'blur(10px)';
        header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
      }
      
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
      
      // Enhanced back to top button
      const backToTop = document.getElementById('backToTop');
      if (scrollTop > 500) {
        backToTop.classList.remove('opacity-0', 'invisible');
        backToTop.classList.add('opacity-100', 'visible');
      } else {
        backToTop.classList.remove('opacity-100', 'visible');
        backToTop.classList.add('opacity-0', 'invisible');
      }
    });

    // Enhanced burger menu with smooth animations
    const burgerBtn = document.getElementById('burgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    burgerBtn.addEventListener('click', () => {
      sidebar.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      
      // Add staggered animation to menu items
      const menuItems = document.querySelectorAll('#sidebar .menu-item');
      menuItems.forEach((item, index) => {
        setTimeout(() => {
          item.style.transform = 'translateX(0)';
          item.style.opacity = '1';
        }, index * 100);
      });
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('translate-x-full');
      overlay.classList.add('hidden');
      document.body.style.overflow = '';
    });

    // Close sidebar when clicking on links
    const sidebarLinks = document.querySelectorAll('#sidebar a');
    sidebarLinks.forEach(link => {
      link.addEventListener('click', () => {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
      });
    });

    // Enhanced fade-in animation with staggered effects
    const fadeElements = document.querySelectorAll('.fade-element, .fade-left, .fade-right');
    
    const fadeInOnScroll = () => {
      fadeElements.forEach((element, index) => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (elementTop < windowHeight - 50) {
          // Add staggered delay for elements in the same section
          setTimeout(() => {
            element.classList.add('visible');
          }, (element.style.getPropertyValue('--item-index') || 0) * 150);
        }
      });
    };
    
    // Enhanced smooth scrolling with easing
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          const headerHeight = document.getElementById('mainHeader').offsetHeight;
          const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
          
          // Custom smooth scroll with easing
          const startPosition = window.pageYOffset;
          const distance = targetPosition - startPosition;
          const duration = 1000;
          let start = null;
          
          function smoothScroll(timestamp) {
            if (!start) start = timestamp;
            const progress = timestamp - start;
            const percentage = Math.min(progress / duration, 1);
            
            // Easing function (ease-in-out-cubic)
            const easing = percentage < 0.5 
              ? 4 * percentage * percentage * percentage 
              : (percentage - 1) * (2 * percentage - 2) * (2 * percentage - 2) + 1;
            
            window.scrollTo(0, startPosition + distance * easing);
            
            if (progress < duration) {
              requestAnimationFrame(smoothScroll);
            }
          }
          
          requestAnimationFrame(smoothScroll);
        }
      });
    });

    // FAQ Accordion functionality
    function toggleAccordion(targetId) {
      const target = document.getElementById(targetId);
      const icon = document.getElementById('icon' + targetId.slice(-1));
      const allAccordions = document.querySelectorAll('.accordion-collapse');
      const allIcons = document.querySelectorAll('[id^="icon"]');
      
      // Close all other accordions
      allAccordions.forEach((accordion, index) => {
        if (accordion.id !== targetId) {
          accordion.style.maxHeight = '0px';
          allIcons[index].style.transform = 'rotate(0deg)';
        }
      });
      
      // Toggle current accordion
      if (target.style.maxHeight === '0px' || !target.style.maxHeight) {
        target.style.maxHeight = target.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
      } else {
        target.style.maxHeight = '0px';
        icon.style.transform = 'rotate(0deg)';
      }
    }

    // Enhanced card hover effects with 3D transforms
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
      });
      
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
      });
    });

    // Pricing card enhanced effects
    const pricingCards = document.querySelectorAll('.pricing-card');
    pricingCards.forEach(card => {
      card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-15px) scale(1.02)';
      });
      
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0px) scale(1)';
      });
    });

    // Enhanced intersection observer for animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          
          // Special animation for feature items
          if (entry.target.classList.contains('feature-item')) {
            const index = entry.target.style.getPropertyValue('--item-index') || 0;
            setTimeout(() => {
              entry.target.style.transform = 'translateY(0) scale(1)';
              entry.target.style.opacity = '1';
            }, index * 100);
          }
        }
      });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.fade-element, .fade-left, .fade-right, .feature-item').forEach(el => {
      observer.observe(el);
    });

    // Initialize particles and animations on load
    window.addEventListener('load', () => {
      createParticles();
      fadeInOnScroll();
      
      // Add loading animation completion
      document.body.style.opacity = '1';
      document.body.style.transform = 'translateY(0)';
    });

    // Run animations on scroll
    window.addEventListener('scroll', fadeInOnScroll);

    // Add typing effect for main heading
    function typeWriter(element, text, speed = 100) {
      let i = 0;
      element.innerHTML = '';
      
      function typing() {
        if (i < text.length) {
          element.innerHTML += text.charAt(i);
          i++;
          setTimeout(typing, speed);
        }
      }
      typing();
    }

    // Parallax effect for background elements
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallaxElements = document.querySelectorAll('.morphing-shape');
      
      parallaxElements.forEach((element, index) => {
        const speed = 0.5 + (index * 0.1);
        element.style.transform = `translateY(${scrolled * speed}px)`;
      });
    });

    // Add performance optimization
    let ticking = false;
    function updateAnimations() {
      fadeInOnScroll();
      ticking = false;
    }

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(updateAnimations);
        ticking = true;
      }
    });

    // Add loading state
    document.body.style.opacity = '0';
    document.body.style.transform = 'translateY(20px)';
    document.body.style.transition = 'all 0.8s ease-out';