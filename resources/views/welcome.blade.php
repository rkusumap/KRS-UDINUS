
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portofolio</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.5/viewer.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            /* background-image: url('https://images.unsplash.com/photo-1503264116251-35a269479413?auto=format&fit=crop&w=1920&q=80'); */
            /* background-size: cover; */
            background-color: black;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .content {
            padding: 40px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        h2 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.6);
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        nav ul li a {
            display: block;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: white;
            color: black;
        }

        @media (max-width: 576px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }
        }

        .text-justify {
            text-align: justify;
        }

        .img-project{
          height:233px;
          object-fit: contain;
          vertical-align: middle;
          background-color: white; /* Add this line */
        }
    </style>
</head>

<body>
    <div class="content">
        <h1 class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <span>Hello</span>
        </h1>

        <h2 class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <span>This just for BackEnd of System</span>
        </h2>

        <h2 class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <span>See the Documentation</span>
        </h2>

        <h2 class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <a href="https://github.com/rkusumap/KRS-UDINUS">https://github.com/rkusumap/KRS-UDINUS</a>
        </h2>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.5/viewer.min.js"></script>
    <script>
        document.querySelectorAll('.img-wrapper').forEach(wrapper => {
            const viewer = new Viewer(wrapper.querySelector('img'), {
                inline: false,
                navbar: false,
                toolbar: true,
                title: false,
                movable: true,
                zoomable: true,
                scalable: false,
                transition: true,
            });

            // Open viewer on image click
            wrapper.addEventListener('click', () => {
                viewer.show();
            });
        });
    </script>
</body>

</html>
