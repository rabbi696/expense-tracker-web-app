<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Tracker - Take Control of Your Finances</title>
    <!-- Tailwind CSS CDN (for utility classes if needed, though mostly custom CSS here) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1a2a6c, #b21f1f, #fdbb2d); /* Deep blue to red-orange gradient */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #e0e7ff; /* Light text for contrast */
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.1); /* More subtle transparency */
            backdrop-filter: blur(8px); /* Glassmorphism effect */
            border-radius: 20px;
            padding: 50px;
            max-width: 700px;
            width: 90%;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Softer border */
            text-align: center;
        }
        h1 {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 25px;
            color: #ffffff;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4);
        }
        p {
            font-size: 1.5rem;
            line-height: 1.7;
            margin-bottom: 40px;
            color: #c3daff; /* Complementary light blue */
        }
        .btn {
            display: inline-block;
            background: linear-gradient(to right, #00c6ff, #0072ff); /* Blue button gradient */
            color: #ffffff;
            padding: 18px 40px;
            border-radius: 35px;
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            opacity: 0.95;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.8rem;
            }
            p {
                font-size: 1.2rem;
            }
            .card {
                padding: 30px;
            }
            .btn {
                padding: 15px 30px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Welcome to Expense Tracker!</h1>
        <p>Your ultimate solution for managing personal finances with ease and clarity. Track, analyze, and control your spending like never before.</p>
        <a href="/login" class="btn">Get Started Now</a>
    </div>

</body>
</html>