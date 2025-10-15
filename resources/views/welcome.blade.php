<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POS System - Point of Sale Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .container {
                max-width: 1200px;
                width: 100%;
            }

            .auth-links {
                position: fixed;
                top: 20px;
                right: 20px;
                display: flex;
                gap: 15px;
                z-index: 100;
            }

            .auth-links a {
                padding: 10px 20px;
                background: rgba(255, 255, 255, 0.2);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 500;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .auth-links a:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }

            .header {
                text-align: center;
                margin-bottom: 60px;
                animation: fadeInDown 0.8s ease;
            }

            .logo {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
                margin-bottom: 20px;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
                background: white;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .logo-icon svg {
                width: 40px;
                height: 40px;
            }

            h1 {
                font-size: 3rem;
                font-weight: 700;
                color: white;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            }

            .subtitle {
                font-size: 1.2rem;
                color: rgba(255, 255, 255, 0.9);
                font-weight: 400;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 25px;
                margin-bottom: 40px;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                transition: all 0.3s ease;
                animation: fadeInUp 0.8s ease;
                animation-fill-mode: both;
            }

            .feature-card:nth-child(1) { animation-delay: 0.1s; }
            .feature-card:nth-child(2) { animation-delay: 0.2s; }
            .feature-card:nth-child(3) { animation-delay: 0.3s; }
            .feature-card:nth-child(4) { animation-delay: 0.4s; }
            .feature-card:nth-child(5) { animation-delay: 0.5s; }
            .feature-card:nth-child(6) { animation-delay: 0.6s; }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .feature-icon svg {
                width: 30px;
                height: 30px;
                stroke: white;
            }

            .feature-card h3 {
                font-size: 1.4rem;
                font-weight: 600;
                color: #2d3748;
                margin-bottom: 12px;
            }

            .feature-card p {
                color: #4a5568;
                line-height: 1.6;
                font-size: 0.95rem;
            }

            .cta-section {
                text-align: center;
                margin-top: 50px;
                animation: fadeIn 1s ease;
            }

            .cta-button {
                display: inline-block;
                padding: 18px 50px;
                background: white;
                color: #667eea;
                text-decoration: none;
                border-radius: 50px;
                font-weight: 600;
                font-size: 1.1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            }

            .cta-button:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
                background: #f7fafc;
            }

            .footer {
                text-align: center;
                margin-top: 50px;
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.9rem;
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @media (max-width: 768px) {
                h1 {
                    font-size: 2rem;
                }

                .subtitle {
                    font-size: 1rem;
                }

                .features-grid {
                    grid-template-columns: 1fr;
                }

                .auth-links {
                    position: relative;
                    top: 0;
                    right: 0;
                    justify-content: center;
                    margin-bottom: 20px;
                }
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            <div class="auth-links">
                @auth
                    <a href="{{ url('/home') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="container">
            <div class="header">
                <div class="logo">
                    <div class="logo-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <h1>POS Management System</h1>
                <p class="subtitle">Complete Point of Sale Solution for Your Business</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3>Sales Management</h3>
                    <p>Process transactions quickly and efficiently with our intuitive point of sale interface. Track sales in real-time and manage your daily operations seamlessly.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3>Product Inventory</h3>
                    <p>Manage your product catalog with ease. Track stock levels, organize by categories, and receive alerts when inventory runs low.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3>Cash Flow Tracking</h3>
                    <p>Monitor your business finances with comprehensive cash flow management. Track income, expenses, and maintain accurate financial records.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3>Purchase Orders</h3>
                    <p>Streamline your procurement process with integrated purchase management. Track orders from suppliers and maintain optimal stock levels.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3>Promotions & Discounts</h3>
                    <p>Create and manage promotional campaigns easily. Apply discounts, track promo performance, and boost your sales with targeted offers.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3>Analytics & Reports</h3>
                    <p>Make data-driven decisions with comprehensive reporting tools. Analyze sales trends, monitor performance, and grow your business intelligently.</p>
                </div>
            </div>

            <div class="cta-section">
                @auth
                    <a href="{{ url('/home') }}" class="cta-button">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="cta-button">Get Started</a>
                @endauth
            </div>

            <div class="footer">
                <p>Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }} | PHP v{{ PHP_VERSION }}</p>
            </div>
        </div>
    </body>
</html>
