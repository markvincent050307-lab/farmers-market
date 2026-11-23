<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AgriPulse | The Heartbeat of Local Agriculture</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f5f8f2;
            font-family: Arial, sans-serif;
            color: #26352a;
            margin: 0;
        }

        /* Navigation */
       .navbar {
    background: rgba(20, 83, 45, 0.97);
    padding: 16px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.10);
}

.navbar-brand {
    color: white;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
    transition: 0.3s ease;
}

.navbar-brand:hover {
    color: #facc15;
}

       .btn-login {
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 50px;
    padding: 10px 23px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-login:hover {
    background: white;
    color: #14532d;
    transform: translateY(-2px);
}

.btn-register {
    background: linear-gradient(135deg, #facc15, #fbbf24);
    color: #26352a;
    border-radius: 50px;
    padding: 10px 23px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(250, 204, 21, 0.2);
}

.btn-register:hover {
    background: white;
    color: #14532d;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

        /* Hero Slider */
      .hero-slider {
    position: relative;
    height: 600px;
    overflow: hidden;
    background: #14532d;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}

        .hero-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-size: cover;
            background-position: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
        }

       .hero-content {
    max-width: 850px;
    color: white;
    transform: translateY(25px);
    opacity: 0;
    transition: all 0.8s ease 0.2s;
    position: relative;
    z-index: 2;
    padding: 25px;
}

.hero-slide.active .hero-content {
    transform: translateY(0);
    opacity: 1;
}

        .hero-label {
            display: inline-block;
            background-color: rgba(255,255,255,0.15);
            color: #dcfce7;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1.5px;
            margin-bottom: 22px;
        }

       .hero-slide h1 {
    font-size: clamp(38px, 5vw, 64px);
    font-weight: 800;
    line-height: 1.12;
    letter-spacing: -1.5px;
    color: #ffffff;
    margin-bottom: 22px;
    text-shadow: 0 3px 15px rgba(0, 0, 0, 0.25);
}

       .hero-slide p {
    font-size: 18px;
    line-height: 1.9;
    margin-bottom: 32px;
    color: rgba(255, 255, 255, 0.94);
    max-width: 650px;
    font-weight: 400;
    letter-spacing: 0.2px;
}

       .btn-market {
    display: inline-block;
    background: linear-gradient(135deg, #facc15, #fbbf24);
    color: #26352a;
    padding: 15px 32px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    border: 2px solid transparent;
    box-shadow: 0 6px 18px rgba(250, 204, 21, 0.25);
    transition: all 0.3s ease;
}

.btn-market:hover {
    background: #ffffff;
    color: #14532d;
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
}

        /* Slider Arrows */
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border: none;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 22px;
            cursor: pointer;
            transition: 0.3s;
            z-index: 5;
        }

        .slider-arrow:hover {
            background: #facc15;
            color: #14532d;
        }

        .slider-arrow.prev {
            left: 25px;
        }

        .slider-arrow.next {
            right: 25px;
        }

        /* Slider Dots */
        .slider-dots {
            position: absolute;
            bottom: 25px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 12px;
            z-index: 5;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border: none;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: 0.3s;
        }

        .slider-dot.active {
            width: 32px;
            border-radius: 10px;
            background: #facc15;
        }

        /* Introduction */
        .section-heading {
            color: #14532d;
            font-weight: bold;
        }

        .section-description {
            color: #647067;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.8;
        }

        #latest-products .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 14px 28px rgba(20, 83, 45, 0.14) !important;
}

#latest-products .card-img-top {
    transition: transform 0.5s ease;
}

#latest-products .card:hover .card-img-top {
    transform: scale(1.06);
}

#latest-products .card-body h5:first-child {
    color: #14532d;
}

#latest-products .card-body {
    background-color: #ffffff;
}

/* Statistics Cards */
.stats-card {
    background: #ffffff;
    border: 1px solid #e2eee3;
    border-radius: 20px;
    padding: 30px 20px;
    height: 100%;
    box-shadow: 0 5px 18px rgba(20, 83, 45, 0.06);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(20, 83, 45, 0.12);
}

.stats-card h2 {
    font-size: 38px;
    margin-bottom: 10px;
}

.stats-card p {
    color: #647067;
}

        /* Feature Cards */
       .feature-card {
    background: #ffffff;
    border: 1px solid #e2e8df;
    border-radius: 20px;
    padding: 38px 28px;
    height: 100%;
    box-shadow: 0 6px 20px rgba(20, 83, 45, 0.06);
    transition: all 0.35s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    border-color: #bbf7d0;
    box-shadow: 0 16px 30px rgba(20, 83, 45, 0.13);
}

        .feature-icon {
            width: 75px;
            height: 75px;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #dcfce7;
            border-radius: 20px;
            font-size: 38px;
        }

        .feature-card h4 {
            color: #14532d;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #647067;
            line-height: 1.8;
            margin-bottom: 0;
        }

        /* Scroll Animation */
        .reveal {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Call to Action */
       .cta-section {
    background: linear-gradient(135deg, #dcfce7, #f0fdf4);
    border: 1px solid #bbf7d0;
    border-radius: 24px;
    padding: 55px 30px;
    box-shadow: 0 8px 25px rgba(20, 83, 45, 0.07);
    transition: all 0.3s ease;
}

.cta-section:hover {
    box-shadow: 0 14px 30px rgba(20, 83, 45, 0.12);
}

.cta-section h3 {
    color: #14532d;
    font-weight: 800;
    font-size: 30px;
}

.cta-section p {
    color: #526456;
    line-height: 1.8;
    font-size: 16px;
}

        /* Footer */
       footer {
    background: linear-gradient(135deg, #103d24, #14532d);
    color: #d1e7d7;
    padding: 40px 15px;
    margin-top: 70px;
    text-align: center;
    border-top: 4px solid #facc15;
}

footer p {
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.3px;
}

footer small {
    color: #a7c8b0;
    font-size: 13px;
}

        /* Mobile */
        @media (max-width: 576px) {


    #latest-products .card {
        border-radius: 16px !important;
    }

    .stats-card {
        padding: 24px 15px;
    }

    .stats-card h2 {
        font-size: 32px;
    }

    .feature-card {
        padding: 28px 20px;
    }

    .cta-section {
        padding: 38px 20px;
    }

    .cta-section h3 {
        font-size: 24px;
    }

            .hero-slider {
                height: 480px;
            }

            .hero-slide {
                padding: 35px 45px;
            }

            .hero-slide h1 {
                font-size: 34px;
            }

            .hero-slide p {
                font-size: 15px;
            }

            .slider-arrow {
                width: 38px;
                height: 38px;
                font-size: 17px;
            }

            .slider-arrow.prev {
                left: 8px;
            }

            .slider-arrow.next {
                right: 8px;
            }

            .navbar-brand {
                font-size: 19px;
            }

            .btn-login,
            .btn-register {
                padding: 8px 12px;
                font-size: 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
        
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-decoration-none" href="/">
                🌱 AgriPulse
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('login') }}" class="btn-login">
                    Log In
                </a>

                <a href="{{ route('register') }}" class="btn-register">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Slider -->
    <section class="hero-slider">

        <div class="hero-slide active"
             style="background-image: linear-gradient(90deg, rgba(10,55,29,.90), rgba(10,55,29,.25)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?w=1800');">

            <div class="hero-content text-center">
                <span class="hero-label">🌾 SUPPORTING LOCAL FARMERS</span>
                <h1>Fresh Products,<br>Straight from Our Farmers</h1>
                <p>Discover fresh agricultural products and support our local farming community.</p>
                <a href="#features" class="btn-market">Explore AgriPulse →</a>
            </div>
        </div>

        <div class="hero-slide"
             style="background-image: linear-gradient(90deg, rgba(10,55,29,.90), rgba(10,55,29,.25)), url('https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=1800');">

            <div class="hero-content text-center">
                <span class="hero-label">🥬 FRESH HARVEST EVERY DAY</span>
                <h1>Good Food Begins<br>with Good Farming</h1>
                <p>Find fresh vegetables, fruits, and farm products from local growers.</p>
                <a href="#features" class="btn-market">Discover More →</a>
            </div>
        </div>

        <div class="hero-slide"
             style="background-image: linear-gradient(90deg, rgba(10,55,29,.90), rgba(10,55,29,.25)), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1800');">

            <div class="hero-content text-center">
                <span class="hero-label">👨‍🌾 GROWING TOGETHER</span>
                <h1>Support Farmers.<br>Build Better Communities.</h1>
                <p>Connect directly with farmers and help strengthen local agriculture.</p>
                <a href="{{ route('register') }}" class="btn-market">Join AgriPulse →</a>
            </div>
        </div>

        <button class="slider-arrow prev" type="button" aria-label="Previous slide">&#10094;</button>
        <button class="slider-arrow next" type="button" aria-label="Next slide">&#10095;</button>

        <div class="slider-dots">
            <button class="slider-dot active" type="button" data-slide="0" aria-label="Slide 1"></button>
            <button class="slider-dot" type="button" data-slide="1" aria-label="Slide 2"></button>
            <button class="slider-dot" type="button" data-slide="2" aria-label="Slide 3"></button>
        </div>

    </section>

    <!-- AgriPulse Statistics -->
<section class="container my-5 py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #1b5e20;">
            AgriPulse in Numbers
        </h2>
        <p class="text-muted">
            Growing our community, one harvest at a time.
        </p>
    </div>

    <div class="row g-4 text-center">

        <div class="col-md-4">
            <div class="stats-card">
                <h2 class="fw-bold text-success counter"
                    data-target="{{ $totalFarmers }}">0</h2>
                <p class="mb-0 fw-semibold">Registered Farmers</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card">
                <h2 class="fw-bold text-success counter"
                    data-target="{{ $totalProducts }}">0</h2>
                <p class="mb-0 fw-semibold">Listed Products</p>
            </div>
        </div>

        <div class="col-md-4">
           <div class="stats-card">
                <h2 class="fw-bold text-success counter"
                    data-target="{{ $totalCompletedOrders }}">0</h2>
                <p class="mb-0 fw-semibold">Completed Orders</p>
            </div>
        </div>

    </div>
</section>

<!-- Latest Products -->
<section class="container my-5 py-4" id="latest-products">

    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: #1b5e20;">
            Fresh from Our Farmers
        </h2>
        <p class="text-muted">
            Discover fresh and locally grown products from our farmers.
        </p>
    </div>

    <div class="row g-4">

        @forelse($latestProducts as $product)

            <div class="col-md-4 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="card-img-top"
                             alt="{{ $product->name }}"
                             style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 220px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif

                    <div class="card-body p-4">

                        <h5 class="fw-bold">
                            {{ $product->name }}
                        </h5>

                        <p class="text-muted small mb-2">
                            Farmer: {{ $product->farmer->name ?? 'Local Farmer' }}
                        </p>

                        <h5 class="fw-bold text-success mb-3">
                            ₱{{ number_format($product->price, 2) }}
                        </h5>

                        <p class="small text-muted mb-0">
                            Available Stock: {{ $product->quantity }}
                        </p>

                    </div>
                </div>
            </div>

        @empty

            <div class="col-12 text-center">
                <p class="text-muted">
                    No products are available at the moment.
                </p>
            </div>

        @endforelse

    </div>

    <div class="text-center mt-5">
        <a href="{{ route('shop.index') }}"
           class="btn btn-success rounded-pill px-4 py-2">
            Explore All Products
        </a>
    </div>

</section>

    <!-- Features -->
    <section class="container my-5 py-4" id="features">

        <div class="text-center mb-5 reveal">
            <h2 class="section-heading">Welcome to AgriPulse</h2>

            <p class="section-description mt-3">
                A marketplace designed to connect local farmers with customers
                and make agricultural shopping easier.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4 reveal">
                <div class="feature-card text-center">
                    <div class="feature-icon">👨‍🌾</div>
                    <h4>For Farmers</h4>
                    <p>
                        Register as a farmer, upload product photos,
                        manage agricultural listings, and offer your
                        products to potential customers.
                    </p>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="feature-card text-center">
                    <div class="feature-icon">🥬</div>
                    <h4>Fresh Products</h4>
                    <p>
                        Browse agricultural products and discover
                        fresh vegetables, fruits, and other produce
                        offered by local farmers.
                    </p>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="feature-card text-center">
                    <div class="feature-icon">🛒</div>
                    <h4>Easy Shopping</h4>
                    <p>
                        Explore available products, add your selections
                        to your cart, place orders, and track your
                        purchases through your account.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="container mt-5 reveal">
        <div class="cta-section text-center">
            <h3>Ready to Explore Fresh Produce?</h3>

            <p class="mt-3 mb-4">
                Join our marketplace and discover products offered by local farmers.
            </p>

            <a href="{{ route('register') }}" class="btn-market">
                Get Started Today →
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2026 AgriPulse | Supporting Local Farmers 🌱</p>
        <small>Connecting farmers and customers through one marketplace.</small>
    </footer>

    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Hero Slider
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const previousButton = document.querySelector('.slider-arrow.prev');
        const nextButton = document.querySelector('.slider-arrow.next');

        if (slides.length > 0) {
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                slides[currentSlide].classList.remove('active');
                dots[currentSlide]?.classList.remove('active');

                currentSlide = (index + slides.length) % slides.length;

                slides[currentSlide].classList.add('active');
                dots[currentSlide]?.classList.add('active');
            }

            function startSlider() {
                clearInterval(slideInterval);

                slideInterval = setInterval(function () {
                    showSlide(currentSlide + 1);
                }, 5000);
            }

            nextButton?.addEventListener('click', function () {
                showSlide(currentSlide + 1);
                startSlider();
            });

            previousButton?.addEventListener('click', function () {
                showSlide(currentSlide - 1);
                startSlider();
            });

            dots.forEach(function (dot, index) {
                dot.addEventListener('click', function () {
                    showSlide(index);
                    startSlider();
                });
            });

            startSlider();
        }

        // Scroll Reveal Animation
        const revealElements = document.querySelectorAll('.reveal');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            revealElements.forEach(function (element) {
                observer.observe(element);
            });
        } else {
            revealElements.forEach(function (element) {
                element.classList.add('visible');
            });
        }

    });

    // AgriPulse Statistics Counter Animation
const counters = document.querySelectorAll('.counter');

const counterObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counter = entry.target;
            const target = Number(counter.dataset.target);
            const duration = 1500;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const progress = Math.min((currentTime - startTime) / duration, 1);
                const currentValue = Math.floor(progress * target);

                counter.textContent = currentValue.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            }

            requestAnimationFrame(updateCounter);
            observer.unobserve(counter);
        }
    });
}, {
    threshold: 0.5
});

counters.forEach(counter => counterObserver.observe(counter));

    </script>

</body>
</html>