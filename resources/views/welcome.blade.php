<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Market | Fresh from Our Farms</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f8f2;
            font-family: Arial, sans-serif;
            color: #26352a;
        }

        /* Navigation */
        .navbar {
            background-color: #14532d;
            padding: 18px 0;
        }

        .navbar-brand {
            color: white;
            font-size: 23px;
            font-weight: bold;
            letter-spacing: 0.3px;
        }

        .navbar-brand:hover {
            color: #dcfce7;
        }

        .btn-login {
            color: white;
            border: 1px solid white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: white;
            color: #14532d;
        }

        .btn-register {
            background-color: #facc15;
            color: #26352a;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
        }

        .btn-register:hover {
            background-color: #eab308;
            color: #26352a;
        }

        /* Hero Section */
        .hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, #14532d, #228b4e);
            padding: 100px 20px;
            color: white;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 850px;
            margin: auto;
        }

        .hero-label {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.15);
            color: #dcfce7;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1.5px;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(35px, 5vw, 58px);
            line-height: 1.2;
            font-weight: bold;
            margin-bottom: 22px;
        }

        .hero p {
            font-size: 19px;
            line-height: 1.8;
            color: #ecfdf5;
            max-width: 700px;
            margin: 0 auto;
        }

        .btn-market {
            display: inline-block;
            background-color: #facc15;
            color: #26352a;
            padding: 15px 28px;
            border-radius: 9px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-market:hover {
            background-color: #eab308;
            color: #26352a;
            transform: translateY(-2px);
        }

        .hero-decoration {
            position: absolute;
            right: 7%;
            bottom: 15px;
            font-size: 170px;
            opacity: 0.12;
            user-select: none;
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

        /* Feature Cards */
        .feature-card {
            background-color: white;
            border: 1px solid #e2e8df;
            border-radius: 16px;
            padding: 32px 25px;
            height: 100%;
            box-shadow: 0 4px 15px rgba(20, 83, 45, 0.05);
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(20, 83, 45, 0.12);
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

        /* Call to Action */
        .cta-section {
            background-color: #e2f3e5;
            border: 1px solid #cce8d2;
            border-radius: 18px;
            padding: 40px 25px;
        }

        .cta-section h3 {
            color: #14532d;
            font-weight: bold;
        }

        .cta-section p {
            color: #526456;
            line-height: 1.8;
        }

        /* Footer */
        footer {
            background-color: #103d24;
            color: #d1e7d7;
            padding: 28px 15px;
            margin-top: 70px;
            text-align: center;
        }

        footer p {
            margin-bottom: 5px;
        }

        footer small {
            color: #a7c8b0;
        }

        /* Mobile */
        @media (max-width: 576px) {
            .hero {
                padding: 70px 20px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero-decoration {
                right: -15px;
                font-size: 100px;
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
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-decoration-none" href="/">
                🌱 Farmers Market
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('login') }}" class="btn btn-login">
                    Log In
                </a>

                <a href="{{ route('register') }}" class="btn btn-register">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="hero-content">
            <div class="hero-label">
                🌾 SUPPORTING OUR LOCAL FARMERS
            </div>

            <h1>
                Fresh Products,<br>
                Straight from Our Farmers
            </h1>

            <p>
                Discover agricultural products from local farmers.
                Find fresh produce, shop conveniently, and help support
                our farming community.
            </p>

            <div class="mt-4">
                <a href="#features" class="btn-market">
                    Explore Our Marketplace &nbsp; →
                </a>
            </div>
        </div>

        <div class="hero-decoration">
            🌾
        </div>
    </section>

    <!-- Features Section -->
    <section class="container my-5 py-4" id="features">
        <div class="text-center mb-5">
            <h2 class="section-heading">
                Welcome to Farmers Market
            </h2>

            <p class="section-description mt-3">
                A marketplace designed to connect local farmers with customers
                and make agricultural shopping easier.
            </p>
        </div>

        <div class="row g-4">

            <!-- Farmers -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        👨‍🌾
                    </div>

                    <h4>For Farmers</h4>

                    <p>
                        Register as a farmer, upload product photos,
                        manage agricultural listings, and offer your
                        products to potential customers.
                    </p>
                </div>
            </div>

            <!-- Fresh Products -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        🥬
                    </div>

                    <h4>Fresh Products</h4>

                    <p>
                        Browse agricultural products and discover
                        fresh vegetables, fruits, and other produce
                        offered by local farmers.
                    </p>
                </div>
            </div>

            <!-- Easy Shopping -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        🛒
                    </div>

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
    <section class="container mt-5">
        <div class="cta-section text-center">
            <h3>Ready to Explore Fresh Produce?</h3>

            <p class="mt-3 mb-4">
                Join our marketplace and discover products offered by local farmers.
            </p>

            <a href="{{ route('register') }}" class="btn btn-market">
                Get Started Today →
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>
            © 2026 Farmers Market | Supporting Local Farmers 🌱
        </p>

        <small>
            Connecting farmers and customers through one marketplace.
        </small>
    </footer>

</body>
</html>